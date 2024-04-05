$(document).ready(function () {
    // Cambiamos el selector a clase del botón ya que no estamos usando un formulario
    $("#btn_login").click(function (e) {
        e.preventDefault(); // Evita el comportamiento por defecto del botón

        var dataObj = {
            username: $("#username").val(),
            password: $("#password").val(),
            fnc: "login",
        };

        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: dataObj,
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    window.location.href = "src/modules/dashboard.php";
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
