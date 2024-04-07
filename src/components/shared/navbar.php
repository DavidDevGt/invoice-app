<?php require_once "./../../config/db_functions.php" ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLeftAlignExample" aria-controls="navbarLeftAlignExample" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarLeftAlignExample">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                $resultPadres = getModulosPadre(); // Obtiene módulos padre
                while ($padre = dbFetchAssoc($resultPadres)) : // Itera sobre cada módulo padre
                    $resultHijos = getModulosHijos($padre['id']); // Obtiene módulos hijos del padre actual
                    if (dbNumRows($resultHijos) > 0) : // Verifica si el módulo padre tiene hijos
                ?>
                        <!-- Navbar dropdown para módulos con hijos -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown-<?php echo $padre['id']; ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $padre['nombre']; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown-<?php echo $padre['id']; ?>">
                                <?php while ($hijo = dbFetchAssoc($resultHijos)) : // Itera sobre cada módulo hijo 
                                ?>
                                    <li><a class="dropdown-item" href="<?php echo $hijo['ruta']; ?>"><?php echo $hijo['nombre']; ?></a></li>
                                <?php endwhile; ?>
                            </ul>
                        </li>
                    <?php
                    else : // Si el módulo padre no tiene hijos, se muestra como un enlace normal
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><?php echo $padre['nombre']; ?></a>
                        </li>
                <?php
                    endif;
                endwhile;
                ?>
            </ul>
            <!-- End Left links -->

        </div>
        <!-- Collapsible wrapper -->

        <!-- Right elements -->
        <div class="d-flex align-items-center">

            <!-- Notifications -->
            <div class="dropdown">
                <a class="link-secondary me-3 hidden-arrow" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell text-white dropdown-toggle"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-notifications" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="#">Pedido No. 3005 retenido por X días</a>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Factura Firmada No. 25340</a>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Usuario2 cambio su estado a Almuerzo</a>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Pedido No. 3005 retenido por X días</a>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Factura Firmada No. 25340</a>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Usuario2 cambio su estado a Almuerzo</a>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Pedido No. 3005 retenido por X días</a>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Factura Firmada No. 25340</a>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Usuario2 cambio su estado a Almuerzo</a>
                        <hr class="dropdown-divider">
                    </li>
                </ul>
            </div>

            <!-- Avatar -->
            <div class="dropdown">
                <a class="dropdown-toggle d-flex text-white align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://picsum.photos/200" class="rounded-circle" height="25" alt="Retrato en blanco y negro de un hombre" loading="lazy">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                    <li><a class="dropdown-item" href="#">Mi perfil</a></li>
                    <li><a class="dropdown-item" href="#">Configuración</a></li>
                    <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
        <!-- Right elements -->
    </div>
    <!-- Container wrapper -->
</nav>

<style>
    .dropdown-notifications {
        max-height: 250px;
        overflow-y: auto;
        font-size: 11px;
    }

    .dropdown-notifications .dropdown-item {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }
</style>

<script>
    const LARGO_CARACTER = 35;
    document.addEventListener("DOMContentLoaded", function() {
        var notifications = document.querySelectorAll(".dropdown-notifications .dropdown-item");
        notifications.forEach(function(item) {
            if (item.textContent.length > LARGO_CARACTER) {
                item.textContent = item.textContent.substring(0, LARGO_CARACTER) + "...";
            }
        });
    });
</script>