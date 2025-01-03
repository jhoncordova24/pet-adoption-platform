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

$id = $_GET['id'];
$consulta = "SELECT * FROM novedades WHERE id = $id";
$resultado = mysqli_query($conn, $consulta);
$publicacion = mysqli_fetch_assoc($resultado);
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
                    <form action="funciones.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editEmployeeModalLabel">Editar Publicación</h5>
                            <a onclick="handleCancel()" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tipo">Tipo:</label>
                                <select id="tipo" name="tipo" class="form-control" required>
                                    <option value="EVENTO" <?php echo $publicacion['tipo'] == 'EVENTO' ? 'selected' : ''; ?>>Evento</option>
                                    <option value="NOTICIA" <?php echo $publicacion['tipo'] == 'NOTICIA' ? 'selected' : ''; ?>>Noticia</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="img">URL de la imagen:</label>
                                <input type="text" id="img" name="img" class="form-control" value="<?php echo $publicacion['img']; ?>" required>
                                <?php if (!empty($publicacion['img'])): ?>
                                    <div class="text-center mt-3">
                                        <img src="<?php echo $publicacion['img']; ?>" alt="Imagen actual" style="width: 320px;">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="titulo">Título:</label>
                                <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo $publicacion['titulo']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción(Max 300 caracteres):</label>
                                <textarea id="descripcion" name="descripcion" class="form-control" required maxlength="300" required><?php echo $publicacion['descripcion']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="fecha_evento">Fecha del evento:</label>
                                <input type="date" id="fecha_evento" name="fecha_evento" class="form-control" value="<?php echo $publicacion['fecha_evento']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="lugar_hora">Lugar y hora:</label>
                                <input type="text" id="lugar_hora" name="lugar_hora" class="form-control" value="<?php echo $publicacion['lugar_hora']; ?>">
                            </div>
                            <input type="hidden" name="action" value="editar_registro">
                            <input type="hidden" name="id" value="<?php echo $publicacion['id']; ?>">
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
                alert("Serás redirigido a la página de administración de publicaciones.");
                window.location.href = "../../dashboard/indexPublicaciones.php";
            }
        </script>
        <script>
            function handleSubmit() {
                alert("La publicación ha sido editada. Serás redirigido a la página de administración de publicaciones.");
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

