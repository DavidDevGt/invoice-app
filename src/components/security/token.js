function verifyToken() {
    const token = localStorage.getItem('jwt');
    if (!token) {
        var baseURL = getBaseURL();
        window.location.href = baseURL + "/index.php";
        return;
    }

    $.ajax({
        url: './../../components/header/default.php',
        type: 'POST',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        success: function(data) {
            console.log("Token verificado con éxito");
        },
        error: function(xhr, status, error) {
            console.error("Token no válido o sesión expirada:", error);
            var baseURL = getBaseURL();
            window.location.href = baseURL + "/index.php";
        }
    });

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
}

// $(document).ready(function() {
//     verifyToken();
// });
