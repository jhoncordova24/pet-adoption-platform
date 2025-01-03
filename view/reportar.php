<?php
// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y limpiar los datos recibidos
    $id_solicitud = $_POST['id_solicitud'];
    $texto_reporte = htmlspecialchars($_POST['texto_reporte']);

    // Incluir archivo de conexión a la base de datos
    include '../dataAccess/bd.php';

    try {
        // Consultar si ya existe un reporte para esta solicitud
        $sql_check = "SELECT reporte FROM solicitud WHERE id_solicitud = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "i", $id_solicitud);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        // Verificar si hay resultados
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            // Ya existe un reporte, realizar actualización
            $sql = "UPDATE solicitud SET reporte = ? WHERE id_solicitud = ?";
            $action = 'actualizado';
        } else {
            // No existe un reporte, realizar inserción
            $sql = "INSERT INTO solicitud (id_solicitud, reporte) VALUES (?, ?)";
            $action = 'enviado';
        }

        // Preparar la consulta SQL
        $stmt = mysqli_prepare($conn, $sql);

        // Verificar si la preparación de la consulta falló
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($conn));
        }

        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, "si", $texto_reporte, $id_solicitud);

        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);

        // Verificar si se actualizó o insertó correctamente
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Mostrar mensaje de éxito
            echo "<script>
                window.location.href = 'mis_adopciones.php';
            </script>";
        } else {
            // Mostrar mensaje de error
            echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al enviar el reporte. Por favor, inténtelo nuevamente más tarde.',
                        });
                    </script>";
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);

    } catch (Exception $e) {
        echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error en la consulta: " . $e->getMessage() . "',
                    });
                </script>";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Reporte</title>
    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Aquí podrías incluir tus estilos CSS si los tienes -->
    <link rel="stylesheet" href="../assets/estilos/reporte.css">
</head>

<body>
    <!-- Formulario de reporte -->
    <form id="reporteForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h2>Reporte de Solicitud</h2>

        <?php
        // Lógica para obtener el ID de la solicitud según tu flujo de datos
        if (isset($_GET['id_solicitud'])) {
            $id_solicitud = $_GET['id_solicitud'];
        } elseif (isset($_POST['id_solicitud'])) {
            $id_solicitud = $_POST['id_solicitud'];
        } else {
            // Manejar el caso donde no se proporcionó el id_solicitud
            echo "Error: No se proporcionó el ID de la solicitud.";
            exit;
        }
        ?>
        <input type="hidden" name="id_solicitud" value="<?php echo htmlspecialchars($id_solicitud); ?>">

        <label for="texto_reporte">Cuentanos, ¿Qué pasó?</label><br>
        <textarea id="texto_reporte" name="texto_reporte" rows="4" cols="50" required></textarea><br>

        <!-- Botón para enviar el formulario -->
        <button type="button" id="enviarReporte">Enviar Reporte</button>
    </form>


    <!-- Script para mostrar SweetAlert de confirmación antes de enviar -->
    <script>
        document.getElementById('enviarReporte').addEventListener('click', function () {
            var textoReporte = document.getElementById('texto_reporte').value.trim();

            if (textoReporte === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Por favor, ingrese su reporte antes de enviar.',
                });
            } else {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esto luego de enviar el reporte.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, enviar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#922b21',
                    cancelButtonColor: '#CCD1D1',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si confirma, enviar el formulario
                        document.getElementById('reporteForm').submit();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        // Si cancela, mostrar mensaje de cancelación
                        Swal.fire({
                            title: 'Cancelado',
                            text: 'Tu reporte no fue enviado.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    </script>

</body>

</html>