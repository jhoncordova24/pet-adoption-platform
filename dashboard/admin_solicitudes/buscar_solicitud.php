<!doctype html>
<?php
include '../../dataAccess/bd.php';
global $conn;
session_start();
error_reporting(0);
$user_id = $_SESSION['idUser'];
$user_name = $_SESSION['nombreUser'];
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$validar = $_SESSION['nombreUser'];

if ($validar == null || $validar = '') {
    header("Location: ../../index.php");
    die();
}

$validarID = $_SESSION['id_rol'];

if ($validarID === 1) {
    header("Location: ../../index.php");
    die();
}
?>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Administración</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../dashboard/sources/css/bootstrap.min.css">
    <!----css3---->
    <link rel="stylesheet" href="../../dashboard/sources/css/custom.css">
    <!--google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!--google material icon-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <!-------sidebar--design------------>
        <div id="sidebar">
            <div class="sidebar-header">
                <a href="../../index.php">
                    <h3><img src="../../assets/img/logo.jpg" class="img-fluid" /><span>Patitas SOS Piura</span></h3>
                </a>
            </div>
            <ul class="list-unstyled component m-0">
                <li class="">
                    <a href="../indexUsuarios.php" class="dashboard"><i class="material-icons">dashboard</i>Usuarios</a>
                </li>
                <li class="">
                    <a href="../indexPublicaciones.php" class=""><i class="material-icons">content_copy</i>Eventos y
                        noticias</a>
                </li>
                <li class="">
                    <a href="../indexMascotas.php" class=""><i class="material-icons">grid_on</i>Mascotas</a>
                </li>
                <li class="active">
                    <a href="../indexSolicitudes.php" class=""><i
                            class="material-icons">library_books</i>Solicitudes</a>
                </li>
            </ul>
        </div>
        <!-------sidebar--design- close----------->
        <!-------page-content start----------->
        <div id="content">
            <!------top-navbar-start----------->
            <div class="top-navbar">
                <div class="xd-topbar">
                    <div class="row">
                        <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                            <div class="xp-menubar">
                                <span class="material-icons text-white">signal_cellular_alt</span>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-3 order-3 order-md-2">
                            <div class="xp-searchbar">
                                <form action="../admin_solicitudes/buscar_solicitud.php" method="POST">
                                    <div class="input-group">
                                        <input type="search" name="busqueda" class="form-control"
                                            placeholder="Buscar..."
                                            value="<?php echo isset($_POST['busqueda']) ? htmlspecialchars($_POST['busqueda'], ENT_QUOTES) : ''; ?>">
                                        <div class="input-group-append">
                                            <button class="btn" type="submit" id="button-addon2">🔎
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-10 col-md-6 col-lg-8 order-1 order-md-3">
                            <div class="xp-profilebar text-right">
                                <nav class="navbar p-0">
                                    <ul class="nav navbar-nav flex-row ml-auto">
                                        <?php
                                        $select = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario = '$user_id'") or die('query failed');
                                        if (mysqli_num_rows($select) > 0) {
                                            $fetch = mysqli_fetch_assoc($select);
                                            // Extraer la ruta de la imagen del usuario de la fila obtenida de la base de datos
                                            $imagen_usuario = $fetch['image'];
                                        }

                                        // Verificar si la imagen del usuario está vacía o no existe
                                        if (empty($imagen_usuario)) {
                                            $imagen_usuario = 'default-avatar.png'; // Imagen por defecto
                                        } else {
                                            $imagen_usuario = 'uploaded_img/' . $imagen_usuario;
                                        }

                                        echo '<li class="dropdown nav-item">
                                                        <a class="nav-link" href="#" data-toggle="dropdown">
                                                            <img src="../../assets/img/' . $imagen_usuario . '" style="width:40px; border-radius:50%;"/>
                                                            <span class="xp-user-live"></span>
                                                        </a>
                                                        <ul class="dropdown-menu small-menu">
                                                            <li><a href="/PatitasSOSPiuraOficial/view/perfil.php">
                                                                    <span class="material-icons">person_outline</span>
                                                                    Perfil
                                                                </a></li>
                                                            <li><a href="../../dataAccess/cerrar_sesion.php">
                                                                    <span class="material-icons">logout</span>
                                                                    Cerrar sesión
                                                                </a></li>
                                                        </ul>
                                                      </li>';
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="xp-breadcrumbbar text-center">
                        <h4 class="page-title">Resultados de la busqueda</h4>
                    </div>
                </div>
            </div>
            <!------top-navbar-end----------->
            <!------main-content-start----------->
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                                        <h2 class="ml-lg-2">Coincidencias</h2>
                                    </div>

                                </div>
                            </div>
                            <?php
                            require_once ("funciones.php");
                            // Configuración de paginación
                            $registros_por_pagina = 5;

                            // Inicializar la variable de búsqueda
                            $busqueda = '';

                            // Verificar si se ha enviado un término de búsqueda
                            if (isset($_POST['busqueda'])) {
                                $busqueda = $_POST['busqueda'];
                            }

                            // Obtener la página actual
                            if (isset($_GET['pagina'])) {
                                $pagina_actual = $_GET['pagina'];
                            } else {
                                $pagina_actual = 1;
                            }

                            // Calcular el offset
                            $offset = ($pagina_actual - 1) * $registros_por_pagina;

                            // Llamar a la función buscar_registro() para obtener los resultados de búsqueda
                            $resultados = buscar_registro($conn);

                            // Obtener el número total de registros para la búsqueda
                            $resultado_total = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                    FROM solicitud s
                                                    INNER JOIN bd_mascota m ON s.id_mascota = m.id_mascota
                                                    WHERE m.nombre_mascota LIKE '%$busqueda%'");

                            $row = mysqli_fetch_assoc($resultado_total);
                            $total_registros = $row['total'];

                            // Calcular el número total de páginas
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            ?>

                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>Mascota</th>
                                        <th>Estado</th>
                                        <th>Descripcion del estado</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="employeeTable">
                                    <?php
                                    foreach ($resultados as $fila) {
                                        ?>
                                    <tr>
                                        <td>
                                            <?php echo $fila['id_solicitud']; ?>
                                        </td>
                                        <td>
                                            <?php echo $fila['nombres']; ?>
                                        </td>
                                        <td>
                                            <?php echo $fila['nombre_mascota']; ?>
                                        </td>
                                        <td>
                                            <?php echo $fila['estado']; ?>
                                        </td>
                                        <td>
                                            <?php echo $fila['descripcion']; ?>
                                        </td>
                                        <td>
                                            <?php echo $fila['fecha']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($_SESSION['id_rol'] != 1) {
                                                ?>
                                            <a class="edit"
                                                href="admin_solicitudes/detalle.php?id=<?php echo $fila['id_solicitud']; ?>"
                                                data-toggle="tooltip" title="Revisar">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a class="delete"
                                                href="admin_solicitudes/actualizar_estado.php?id=<?php echo $fila['id_solicitud']; ?>"
                                                data-toggle="tooltip" title="Actualizar">
                                                <i class="material-icons">fact_check</i>
                                            </a>
                                            <?php
                                            } else {
                                                echo '';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- Paginación -->
                            <div class="clearfix">
                                <div class="hint-text">Mostrando
                                    <b><?php echo min(count($resultados), $registros_por_pagina); ?></b> de
                                    <b><?php echo $total_registros; ?></b>
                                </div>
                                <ul class="pagination">
                                    <?php if ($pagina_actual > 1): ?>
                                        <li class="page-item"><a href="?pagina=<?php echo $pagina_actual - 1; ?>"
                                                class="page-link">Atrás</a></li>
                                    <?php else: ?>
                                        <li class="page-item disabled"><a href="#" class="page-link">Atrás</a></li>
                                    <?php endif; ?>
                                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                        <li class="page-item <?php echo $i == $pagina_actual ? 'active' : ''; ?>"><a
                                                href="?pagina=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($pagina_actual < $total_paginas): ?>
                                        <li class="page-item"><a href="?pagina=<?php echo $pagina_actual + 1; ?>"
                                                class="page-link">Siguiente</a></li>
                                    <?php else: ?>
                                        <li class="page-item disabled"><a href="#" class="page-link">Siguiente</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!------main-content-end----------->
            <!----footer-design------------->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="footer-in">
                        <p class="mb-0">Copyright © 2024 Patitas SOS PIURA | Todos los derechos reservados</p>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    <!-------complete html----------->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../sources/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../sources/js/popper.min.js"></script>
    <script src="../sources/js/bootstrap.min.js"></script>
    <script src="../sources/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".xp-menubar").on('click', function () {
                $("#sidebar").toggleClass('active');
                $("#content").toggleClass('active');
            });

            $('.xp-menubar,.body-overlay').on('click', function () {
                $("#sidebar,.body-overlay").toggleClass('show-nav');
            });

        });
    </script>
</body>

</html>