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
<main class="container">
        <div class="row justify-content-center">
            <div class="login-container">
                <!-- Contenido del contenedor -->
                <div class="d-flex w-100 bg-white p-5 rounded shadow-lg justify-content-between">
                    <!-- Logotipo y texto a la izquierda -->
                    <div class="d-flex flex-column justify-content-center align-items-center w-50">
                        <img src="https://fshama.netlify.app/media/logo%201.svg" alt="Logo InvoiceApp" style="max-width: 100px;">
                        <h2 class="text-center mt-3">InvoiceApp</h2>
                    </div>
                    <!-- Formulario de inicio de sesión a la derecha -->
                    <div class="w-50">
                        <h3 class="mb-4">Inicio de Sesión</h3>
                        <form id="loginForm" action="procesar_login.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Ingresa tu nombre de usuario" required="">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required="">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning btn-block">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="./src/include/jquery/jquery-4.0.0-beta.min.js"></script>
    <script src="app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>