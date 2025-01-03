<?php
include '../../dataAccess/bd.php';
global $conn;
?>
<html>

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

    <?php
    include_once ("funciones.php");
    if (isset($_GET['id'])) {
        $id_solicitud = $_GET['id'];

        $result = obtenerDetallesSolicitud($conn, $id_solicitud);

        if ($result->num_rows > 0) {
            echo "<div class='modal fade show' id='editEmployeeModal' tabindex='-1' role='dialog' aria-labelledby='editEmployeeModalLabel' aria-hidden='true' style='display: block; background-color: rgba(0,0,0,0.5);'>
        <div class='modal-dialog' role='document' style='max-width: 80%;'>
            <div class='modal-content'>
                <form id='detalleForm'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='editEmployeeModalLabel'>Ver Solicitud</h5>
                        <a onclick='handleCancel()' class='close' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </a>
                    </div>
                    <div class='modal-body'>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='form-group'>
            <label>" . htmlspecialchars($row["nombre_pregunta"]) . "</label>
            <input type='text' class='form-control' name='respuestas[" . $row["id_detalle"] . "]' value='" . $row["respuesta"] . "' readonly>
          </div>";
            }
            echo "</div>"
                . "</form>"
                . "</div>
        </div>
        </div>";
        } else {
            echo "No se encontraron detalles para esta solicitud.";
        }
        $conn->close();
    } else {
        echo "ID de solicitud no proporcionado.";
    }
    ?>

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