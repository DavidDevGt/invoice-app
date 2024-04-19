function verifyToken() {
    const token = localStorage.getItem('jwt');
    const lastActivity = localStorage.getItem('lastActivity');
    const currentTime = new Date().getTime();

    if (!token || (lastActivity && (currentTime - lastActivity > 1800000))) { // 1800000 ms = 30 minutos
        logout();
        return;
    }

    // Actualiza la última actividad en localStorage
    localStorage.setItem('lastActivity', currentTime);

    $.ajax({
        url: './../../components/security/middleware.php',
        type: 'POST',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        success: function (data) {
            console.log("Token verificado con éxito");
        },
        error: function (xhr, status, error) {
            console.error("Token no válido o sesión expirada:", error);
            logout();
        }
    });
}

function logout() {
    localStorage.removeItem('jwt');
    localStorage.removeItem('username');
    localStorage.removeItem('lastActivity');
    var baseURL = getBaseURL();
    window.location.href = baseURL + "/index.php";
}

function getBaseURL() {
    var baseURL;
    if (window.location.hostname === "localhost") {
        baseURL = window.location.protocol + "//" + window.location.hostname;
        if (window.location.port) {
            baseURL += ":" + window.location.port;
        }
        baseURL += "/invoice-app";
    } else {
        baseURL = window.location.protocol + "//" + window.location.hostname;
        if (window.location.port) {
            baseURL += ":" + window.location.port;
        }
    }
    return baseURL;
}

// $(document).ready(function() {
//     verifyToken();
// });
