<!doctype html>
<?php
include '../dataAccess/bd.php';
global $conn;
session_start();
error_reporting(0);
$user_id = $_SESSION['idUser'];
$user_name = $_SESSION['nombreUser'];
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$validar = $_SESSION['nombreUser'];

if ($validar == null || $validar = '') {
    header("Location: ../index.php");
    die();
}

$validarID = $_SESSION['id_rol'];

if ($validarID == 1) {
    header("Location: ../index.php");
    die();
}

function obtenerTituloRol($id_rol) {
    switch ($id_rol) {
        case 1:
            return 'Usuario';
        case 2:
            return 'Administrador';
        case 3:
            return 'Super Administrador';
        default:
            return 'Desconocido';
    }
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
        <link rel="stylesheet" href="../dashboard/sources/css/bootstrap.min.css">
        <!----css3---->
        <link rel="stylesheet" href="../dashboard/sources/css/custom.css">
        <!--google fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <!--google material icon-->
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">
    </head>
    <body>
        <div class="wrapper">
            <div class="body-overlay"></div>
            <!-------sidebar--design------------>
            <div id="sidebar">
                <div class="sidebar-header">
                    <a href="../index.php">
                        <h3><img src="../assets/img/logo.jpg" class="img-fluid"/><span>Patitas SOS Piura</span></h3>
                    </a>
                </div>
                <ul class="list-unstyled component m-0">
                    <li class="active">
                        <a href="indexUsuarios.php" class="dashboard"><i class="material-icons">dashboard</i>Usuarios</a>
                    </li>
                    <li class="">
                        <a href="indexPublicaciones.php" class=""><i class="material-icons">content_copy</i>Eventos y noticias</a>
                    </li>
                    <li class="">
                        <a href="indexMascotas.php" class=""><i class="material-icons">grid_on</i>Mascotas</a>
                    </li>
                    <li class="">
                        <a href="indexSolicitudes.php" class=""><i class="material-icons">library_books</i>Solicitudes</a>
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
                                    <form action="admin_usuarios/buscar_usuario.php" method="POST">
                                        <div class="input-group">
                                            <input type="search" name="busqueda" class="form-control" placeholder="Buscar..." value="<?php echo isset($_POST['busqueda']) ? htmlspecialchars($_POST['busqueda'], ENT_QUOTES) : ''; ?>">
                                            <div class="input-group-append">
                                                <button class="btn" type="submit" id="button-addon2">🔎</button>
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
                                                            <img src="../assets/img/' . $imagen_usuario . '" style="width:40px; border-radius:50%;"/>
                                                            <span class="xp-user-live"></span>
                                                        </a>
                                                        <ul class="dropdown-menu small-menu">
                                                            <li><a href="../../view/perfil.php">
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
                            <h4 class="page-title">Dashboard</h4>
                            <?php
                            if (isset($_SESSION['nombreUser']) && isset($_SESSION['id_rol'])) {
                                $titulo_rol = obtenerTituloRol($_SESSION['id_rol']);
                                echo '<ol class="breadcrumb">
                                    <li class="breadcrumb-item active">Bienvenido</li>
                                    <li class="breadcrumb-item active" aria-current="page">' . $titulo_rol . ' ' . $_SESSION['nombreUser'] . '</li>
                                  </ol>';
                            }
                            ?>
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
                                            <h2 class="ml-lg-2">Administrar usuarios</h2>
                                        </div>
                                        <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
                                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                                                <i class="material-icons">&#xE147;</i>
                                                <span>Agregar nuevo usuario</span>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <?php
                                include_once ("funciones.php");
                                // Configuración de paginación
                                $registros_por_pagina = 5;

                                if (isset($_GET['pagina'])) {
                                    $pagina_actual = $_GET['pagina'];
                                } else {
                                    $pagina_actual = 1;
                                }

                                // Calcula el offset
                                $offset = ($pagina_actual - 1) * $registros_por_pagina;

                                // Consulta SQL con límite y offset
                                $consulta = "SELECT usuario.id_usuario, usuario.nombres, usuario.apellidos, usuario.telefono, usuario.email, rol.titulo_rol, usuario.id_rol 
                                            FROM usuario 
                                            LEFT JOIN rol ON usuario.id_rol = rol.id_rol 
                                            LIMIT $offset, $registros_por_pagina";
                                $resultado = mysqli_query($conn, $consulta);

                                // Obtén el número total de registros
                                $resultado_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM usuario");
                                $row = mysqli_fetch_assoc($resultado_total);
                                $total_registros = $row['total'];

                                // Calcula el número total de páginas
                                $total_paginas = ceil($total_registros / $registros_por_pagina);
                                ?>
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Telefono</th>
                                            <th>Correo</th>
                                            <th>Rol</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>

                                    <tbody id="employeeTable">
                                        <?php
                                        while ($fila = mysqli_fetch_array($resultado)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $fila['id_usuario']; ?></td>
                                                <td><?php echo $fila['nombres']; ?></td>
                                                <td><?php echo $fila['apellidos']; ?></td>
                                                <td><?php echo $fila['telefono']; ?></td>
                                                <td style="text-transform: lowercase;"><?php echo $fila['email']; ?></td>
                                                <td><?php echo $fila['titulo_rol']; ?></td>
                                                <td>
                                                    <?php
                                                    // Verifica si el usuario actual es super admin y el usuario en la fila no es super admin
                                                    if ($_SESSION['id_rol'] == 3 && $fila['id_rol'] != 3) {
                                                        // Si el usuario es super admin y el usuario en la fila no es super admin, muestra los botones de editar y eliminar
                                                        ?>
                                                        <a class="edit" href="admin_usuarios/editar_usuario.php?id=<?php echo $fila['id_usuario']; ?>" data-toggle="tooltip" title="Edit">
                                                            <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
                                                        </a>
                                                        <a class="delete" href="admin_usuarios/eliminar_usuario.php?id=<?php echo $fila['id_usuario']; ?>" data-toggle="tooltip" title="Delete">
                                                            <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i>
                                                        </a>
                                                        <?php
                                                    } else {
                                                        // Si no se cumplen las condiciones anteriores, no muestra nada.
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
                                    <div class="hint-text">Mostrando <b><?php echo min(mysqli_num_rows($resultado), $registros_por_pagina); ?></b> de <b><?php echo $total_registros; ?></b></div>
                                    <ul class="pagination">
                                        <?php if ($pagina_actual > 1): ?>
                                            <li class="page-item"><a href="?pagina=<?php echo $pagina_actual - 1; ?>" class="page-link">Atrás</a></li>
                                        <?php else: ?>
                                            <li class="page-item disabled"><a href="#" class="page-link">Atrás</a></li>
                                        <?php endif; ?>
                                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                            <li class="page-item <?php echo $i == $pagina_actual ? 'active' : ''; ?>"><a href="?pagina=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a></li>
                                        <?php endfor; ?>

                                        <?php if ($pagina_actual < $total_paginas): ?>
                                            <li class="page-item"><a href="?pagina=<?php echo $pagina_actual + 1; ?>" class="page-link">Siguiente</a></li>
                                        <?php else: ?>
                                            <li class="page-item disabled"><a href="#" class="page-link">Siguiente</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div> 
                            </div>
                        </div>
                        <!-- Modal de Crear Usuario -->
                        <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addEmployeeModalLabel">Crear Usuario</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="crearUsuarioForm" action="admin_usuarios/funciones.php" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nombres" class="form-label">Nombres:</label>
                                                <input type="text" id="nombres" name="nombres" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="apellidos" class="form-label">Apellidos:</label>
                                                <input type="text" id="apellidos" name="apellidos" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono" class="form-label">Teléfono:</label>
                                                <input type="tel" id="telefono" name="telefono" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="form-label">Correo:</label>
                                                <input type="email" id="email" name="email" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="form-label">Contraseña:</label>
                                                <input type="password" id="password" name="password" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="rol" class="form-label">Rol de usuario *</label>
                                                <select id="rol" name="rol" class="form-control" required>
                                                    <option value="1" selected>Usuario</option>
                                                    <?php if ($_SESSION['id_rol'] == 3): ?>
                                                        <!-- Si el usuario actual es super admin, se muestran las opciones de administrador y super admin -->
                                                        <option value="2">Admin</option>
                                                        <option value="3">Super Admin</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <input type="hidden" name="action" value="crear_registro">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" onclick="handleSubmit()" class="btn btn-success">Crear</button>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!----add-modal end--------->

                        <!----edit-modal start--------->

                        <!----edit-modal end--------->

                        <!----delete-modal start--------->

                        <!----delete-modal end--------->   
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
        <script>
            function handleSubmit() {
                alert("El usuario ha sido creado con éxito.");
                window.location.href = "../../dashboard/indexUsuarios.php";
            }
        </script>
        <script src="sources/js/jquery-3.3.1.slim.min.js"></script>
        <script src="sources/js/popper.min.js"></script>
        <script src="sources/js/bootstrap.min.js"></script>
        <script src="sources/js/jquery-3.3.1.min.js"></script>
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
