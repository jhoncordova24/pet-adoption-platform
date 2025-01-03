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

if ($validarID === 1) {
    header("Location: ../../index.php");
    die();
}

$id = $_GET['id'];
$consulta = "SELECT * FROM solicitud WHERE id_solicitud = $id";
$resultado = mysqli_query($conn, $consulta);
$solicitud = mysqli_fetch_assoc($resultado);
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
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
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
    <div class="modal fade show" id="editEmployeeModal" tabindex="-1" role="dialog"
        aria-labelledby="editEmployeeModalLabel" aria-hidden="true"
        style="display: block; background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="funciones.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEmployeeModalLabel">Actualizar el estado de la solicitud</h5>
                        <a onclick="handleCancel()" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="estado">Estado de la solicitud:</label>
                            <select id="estado" name="estado" class="form-control" required>
                                <option value="1" <?php echo $solicitud['id_estado'] == 1 ? 'selected' : ''; ?>>Pendiente
                                </option>
                                <option value="2" <?php echo $solicitud['id_estado'] == 2 ? 'selected' : ''; ?>>Aceptado
                                </option>
                                <option value="3" <?php echo $solicitud['id_estado'] == 3 ? 'selected' : ''; ?>>Rechazado
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción(Max 300 caracteres):</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" required maxlength="300"
                                required><?php echo $solicitud['descripcion']; ?></textarea>
                        </div>
                        <input type="hidden" name="action" value="actualizar_solicitud">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="handleCancel()">Cancelar</button>
                        <button type="submit" class="btn btn-success" onclick="handleSubmit()">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function handleCancel() {
            alert("Serás redirigido a la página de administración de solicitudes.");
            window.location.href = "../../dashboard/indexSolicitudes.php";
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