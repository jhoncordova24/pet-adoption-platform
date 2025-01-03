<?php
session_start();
error_reporting(0);

include '../../dataAccess/bd.php';
global $conn;

$validar = $_SESSION['nombreUser'];

if ($validar == null || $validar = '') {
    header("Location: ../../index.php");
    die();
}
$validarID = $_SESSION['id_rol'];

if ($validarID == 1) {
    header("Location: ../../index.php");
    die();
}

if (isset($_POST['ids'])) {
    $ids = $_POST['ids'];
    $idList = implode(',', array_map('intval', $ids)); // Sanitizar los IDs

    $consulta = "DELETE FROM bd_mascota WHERE id_mascota IN ($idList)";
    if (mysqli_query($conn, $consulta)) {
        echo "Mascotas eliminadas correctamente.";
    } else {
        echo "Error al eliminar las mascotas: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Confirmar Eliminación</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../../dashboard/sources/css/bootstrap.min.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../../dashboard/sources/css/custom.css">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <!-- Google Material Icons -->
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
        <style>
            body {
                overflow-y: scroll;
            }
            .modal-content {
                max-height: calc(100vh - 100px);
                overflow-y: auto;
            }
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <!-- Modal de Eliminación -->
            <div class="modal fade show" tabindex="-1" id="deleteEmployeeModal" role="dialog" style="display: block; background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Eliminar Mascota</h5>
                            <a onclick="handleCancel()" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>
                        <div class="modal-body">
                            <p>¿Desea confirmar la eliminación del registro?</p>
                            <p class="text-warning"><small>Esta acción no se puede revertir.</small></p>
                        </div>
                        <div class="modal-footer">
                            <form action="funciones.php" method="POST">
                                <input type="hidden" name="action" value="eliminar_registro">
                                <input type="hidden" name="id_mascota" value="<?php echo $_GET['id']; ?>">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="handleCancel()">Cancelar</button>
                                <button type="submit" class="btn btn-danger" onclick="handleSubmit()">Eliminar</button>
                            </form>
                        </div>   
                    </div>
                </div>
            </div>
            <!-- Fin del Modal de Eliminación -->
        </div>
        <!-- Bootstrap JS y dependencias -->
        <script>
            function handleCancel() {
                alert("Serás redirigido a la página de administración de mascotas.");
                window.location.href = "../../dashboard/indexPublicaciones.php";
            }
        </script>
        <script>
            function handleSubmit() {
                alert("La mascota ha sido ELIMINADA. Serás redirigido a la página de administración de mascotas.");
                window.location.href = "../../dashboard/indexPublicaciones.php";
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
