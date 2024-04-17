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

    $("#btn_login").click(function (e) {
        e.preventDefault();

        var dataObj = {
            username: $("#username").val(),
            password: $("#password").val(),
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
                    window.location.href = "./src/modules/usuario/index.php";
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
    });

    // Cargar si ya esta
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
