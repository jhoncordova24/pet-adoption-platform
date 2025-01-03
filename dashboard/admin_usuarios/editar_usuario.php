<?php
session_start();
error_reporting(0);

include '../../dataAccess/bd.php';
global $conn;

$validar = $_SESSION['nombreUser'];

if( $validar == null || $validar = ''){
    header("Location: ../../index.php");
    die();
}
$validarID = $_SESSION['id_rol'];

if ($validarID == 1) {
    header("Location: ../../index.php");
    die();
}

$id = $_GET['id'];
$consulta = "SELECT * FROM usuario WHERE id_usuario = $id";
$resultado = mysqli_query($conn, $consulta);
$usuario = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es-MX">
    <head>
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
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">
    </head>
    <style>
        body {
            overflow-y: scroll;
        }
        .modal-content {
            max-height: calc(100vh - 100px);
            overflow-y: auto;
        }
    </style>
    <body>
        <div class="modal fade show" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel" aria-hidden="true" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="funciones.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editEmployeeModalLabel">Editar Usuario</h5>
                            <a onclick="handleCancel()" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nombres">Nombres:</label>
                                <input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo $usuario['nombres']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?php echo $usuario['apellidos']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo $usuario['telefono']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo:</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo $usuario['email']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="rol">Rol de usuario:</label>
                                <select id="rol" name="rol" class="form-control" required>
                                    <option value="1" <?php echo $usuario['id_rol'] == 1 ? 'selected' : ''; ?>>Usuario</option>
                                    <?php if ($_SESSION['id_rol'] == 3): ?>
                                        <option value="2" <?php echo $usuario['id_rol'] == 2 ? 'selected' : ''; ?>>Admin</option>
                                        <option value="3" <?php echo $usuario['id_rol'] == 3 ? 'selected' : ''; ?>>Super Admin</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <input type="hidden" name="action" value="editar_registro">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="handleCancel()">Cancelar</button>
                            <button type="submit" class="btn btn-success" onclick="handleSubmit()">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function handleCancel() {
                alert("Serás redirigido a la página de administración de usuarios.");
                window.location.href = "../../dashboard/indexUsuarios.php";
            }
        </script>
        <script>
            function handleSubmit() {
                alert("El usuario ha sido EDITADO. Serás redirigido a la página de administración de usuarios.");
                window.location.href = "../../dashboard/indexUsuarios.php";
            }
        </script>
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
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>


