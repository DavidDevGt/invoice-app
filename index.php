<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario'])) {
    $_SESSION = array();

    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Invoice2Go</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/assets/login-style.css">
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form-title" style="background-image: url(./src/assets/img/bg-login.jpg); background-position: center top; background-size: cover;">
                    <span class="login100-form-title-1">
                        LOGIN
                    </span>
                </div>

                <div class="login100-form mt-3">
                    <div class="wrap-input100 mb-3">
                        <span class="label-input100">Usuario</span>
                        <input class="input100" type="text" id="username" placeholder="Ingrese su usuario">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 mb-5">
                        <span class="label-input100">Contraseña</span>
                        <input class="input100" type="password" id="password" placeholder="Ingrese su contraseña">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" id="btn_login">
                            Iniciar Sesión
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="./src/include/jquery/jquery-4.0.0-beta.min.js"></script>
    <script src="app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>