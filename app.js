$(document).ready(function () {

    function setAuthToken() {
        const token = localStorage.getItem('jwt');
        if (token) {
            $.ajaxSetup({
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
        }
    }

    function attemptLogin() {
        var username = $("#username").val();
        var password = $("#password").val();

        if (username === "" || password === "") {
            Swal.fire({
                icon: "warning",
                title: "Atención",
                text: "Por favor, complete todos los campos requeridos.",
            });
            return; // Detener la función si hay campos vacíos
        }

        var dataObj = {
            username: username,
            password: password,
            fnc: "login",
        };

        $.ajax({
            url: "./ajax.php",
            type: "POST",
            data: dataObj,
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    localStorage.setItem('jwt', data.token);
                    localStorage.setItem('username', data.username);
                    setAuthToken();
                    window.location.href = "./src/modules/dashboard/dashboard.php";
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Usuario o contraseña incorrectos.",
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Ocurrió un error al intentar iniciar sesión.",
                });
            },
        });
    }

    $("#btn_login").click(function (e) {
        e.preventDefault();
        attemptLogin();
    });

    $(document).on('keypress',function(e) {
        if(e.which == 13) {
            e.preventDefault();
            console.log("Enter pressed");
            attemptLogin();
        }
    });

    setAuthToken();

    $(document).on("click", ".toggle-password", function () {
        let input = $("#password");
        if (input.attr("type") === "password") {
            input.attr("type", "text");
            $(this).toggleClass("fa-eye fa-eye-slash");
        } else {
            input.attr("type", "password");
            $(this).toggleClass("fa-eye-slash fa-eye");
        }
    });
});
