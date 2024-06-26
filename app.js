$(document).ready(function () {
    setAuthToken();

    $("#btn_login").on("click", function (e) {
        e.preventDefault();
        attemptLogin();
    });

    document.addEventListener('keydown', function(e) {
        // console.log("Tecla presionada:", e.key);
        
        if (e.key === "Enter" && (document.activeElement === document.getElementById('username') || document.activeElement === document.getElementById('password'))) {
            e.preventDefault();
            attemptLogin();
        }
    });
    
    $(document).on("click", ".toggle-password", togglePasswordVisibility);

    function setAuthToken() {
        const token = localStorage.getItem('jwt');
        if (token) {
            $.ajaxSetup({ headers: { 'Authorization': 'Bearer ' + token } });
        }
    }

    function attemptLogin() {
        const username = $("#username").val().trim();
        const password = $("#password").val().trim();

        if (!username || !password) {
            Swal.fire("Atención", "Por favor, complete todos los campos requeridos.", "warning");
            return;
        }

        $.ajax({
            url: "./ajax.php",
            type: "POST",
            data: { username, password, fnc: "login" },
            dataType: "json",
            success: handleLoginResponse,
            error: handleError
        });
    }

    function handleLoginResponse(data) {
        if (data.success) {
            localStorage.setItem('jwt', data.token);
            localStorage.setItem('username', data.username);
            setAuthToken();
            window.location.href = "./src/modules/dashboard/dashboard.php";
        } else {
            Swal.fire("Error", "Usuario o contraseña incorrectos.", "error");
        }
    }

    function handleError(xhr, status, error) {
        console.error("Error:", error);
        Swal.fire("Error", "Ocurrió un error al intentar iniciar sesión.", "error");
    }

    function togglePasswordVisibility() {
        let input = $("#password");
        input.attr("type", input.attr("type") === "password" ? "text" : "password");
        $(this).toggleClass("fa-eye fa-eye-slash");
    }
});
