<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Invoice2Go</title>
    <link href="./src/include/bootstrap5/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/assets/login-style.css">
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form-title" style="background-image: url(./src/assets/img/bg-login.jpg); background-position: center top; background-size: cover;">
                    <span class="login100-form-title-1">
                        FERRETERIA SHAMA
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
    <script src="./app.js"></script>
    <script src="./src/include/bootstrap5/bootstrap.bundle.min.js"></script>
    <script src="./src/include/sweetalert2/sweetalert2@11.js"></script>
</body>

</html>