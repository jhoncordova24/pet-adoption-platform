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
$consulta = "SELECT * FROM bd_mascota WHERE id_mascota = $id";
$resultado = mysqli_query($conn, $consulta);
$mascota = mysqli_fetch_assoc($resultado);
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
                        <h5 class="modal-title" id="editMascotaModalLabel">Editar Mascota</h5>
                        <a onclick="handleCancel()" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id_especie">Especie:</label>
                            <select id="id_especie" name="id_especie" class="form-control" required>
                                <option value="1" <?php echo $mascota['id_especie'] == 1 ? 'selected' : ''; ?>>Gato
                                </option>
                                <option value="2" <?php echo $mascota['id_especie'] == 2 ? 'selected' : ''; ?>>Perro
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="foto_mascota">URL de la imagen:</label>
                            <input type="text" id="foto_mascota" name="foto_mascota" class="form-control" required
                                oninput="loadImagePreview()" value="<?php echo $mascota['foto_mascota']; ?>">
                            <?php if (!empty($mascota['foto_mascota'])): ?>
                                <div class="text-center mt-3">
                                    <img src="<?php echo $mascota['foto_mascota']; ?>" alt="Vista previa de la imagen"
                                        style="width: 340px;">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="sexo">Sexo:</label>
                            <select id="sexo" name="sexo" class="form-control" required>
                                <option value="Macho" <?php echo $mascota['sexo'] == 'Macho' ? 'selected' : ''; ?>>Macho
                                </option>
                                <option value="Hembra" <?php echo $mascota['sexo'] == 'Hembra' ? 'selected' : ''; ?>>
                                    Hembra</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre_mascota">Nombre:</label>
                            <input type="text" id="nombre_mascota" name="nombre_mascota" class="form-control" required
                                value="<?php echo $mascota['nombre_mascota']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control"
                                value="<?php echo $mascota['fecha_nacimiento']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="largo_pelo" class="form-label">Largo de pelo:</label>
                            <select id="largo_pelo" name="largo_pelo" class="form-control" required>
                                <option value="Corto" <?php echo $mascota['largo_pelo'] == 'Corto' ? 'selected' : ''; ?>>
                                    Corto</option>
                                <option value="Mediano" <?php echo $mascota['largo_pelo'] == 'Mediano' ? 'selected' : ''; ?>>Mediano</option>
                                <option value="Largo" <?php echo $mascota['largo_pelo'] == 'Largo' ? 'selected' : ''; ?>>
                                    Largo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tamano" class="form-label">Tamaño:</label>
                            <select id="tamano" name="tamano" class="form-control" required>
                                <option value="Pequeño" <?php echo $mascota['tamano'] == 'Pequeño' ? 'selected' : ''; ?>>
                                    Pequeño</option>
                                <option value="Mediano" <?php echo $mascota['tamano'] == 'Mediano' ? 'selected' : ''; ?>>
                                    Mediano</option>
                                <option value="Grande" <?php echo $mascota['tamano'] == 'Grande' ? 'selected' : ''; ?>>
                                    Grande</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="esterilizado">Esterilizado:</label>
                            <select id="esterilizado" name="esterilizado" class="form-control" required>
                                <option value="1" <?php echo $mascota['esterilizado'] == '1' ? 'selected' : ''; ?>>Si
                                </option>
                                <option value="0" <?php echo $mascota['esterilizado'] == '0' ? 'selected' : ''; ?>>No
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="peso">Peso (en KG):</label>
                            <input type="number" id="peso" name="peso" class="form-control" step="0.01"
                                value="<?php echo $mascota['peso']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" class="form-control"
                                required><?php echo $mascota['descripcion']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="estado_medico" class="form-label">Estado médico:</label>
                            <textarea id="estado_medico" name="estado_medico" class="form-control"
                                required><?php echo $mascota['estado_medico']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="telefono_dueño" class="form-label">Teléfono del Dueño:</label>
                            <textarea id="telefono_dueño" name="telefono_dueño" class="form-control"
                                required><?php echo $mascota['telefono_dueño']; ?></textarea>
                        </div>
                        <input type="hidden" name="action" value="editar_registro">
                        <input type="hidden" name="id_mascota" value="<?php echo $mascota['id_mascota']; ?>">
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
            alert("Serás redirigido a la página de administración de mascotas.");
            window.location.href = "../../dashboard/indexMascotas.php";
        }
    </script>
    <script>
        function handleSubmit() {
            alert("La mascota ha sido EDITADA. Serás redirigido a la página de administración de mascotas.");
            window.location.href = "../../dashboard/indexMascotas.php";
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