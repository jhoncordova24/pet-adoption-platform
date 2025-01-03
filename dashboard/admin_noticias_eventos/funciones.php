<?php

require_once ("../../dataAccess/bd.php");
global $conn;

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'editar_registro':
            editar_registro($conn); // Pasar la variable $conn como argumento
            break;

        case 'eliminar_registro':
            eliminar_registro($conn); // Pasar la variable $conn como argumento
            break;

        case 'crear_registro':
            crear_registro($conn);
            break;

        case 'buscar_registro':
            buscar_registro($conn);
            break;
    }
}

function crear_registro($conn) {
    extract($_POST);

    // Si la fecha de publicación no está establecida, usa la fecha de hoy
    $fecha_publicacion = !empty($fecha_publicacion) ? date('Y-m-d', strtotime($fecha_publicacion)) : date('Y-m-d');

    // Valida y formatea las fechas
    $fecha_evento = !empty($fecha_evento) ? date('Y-m-d', strtotime($fecha_evento)) : null;

    $consulta = "INSERT INTO novedades (tipo, img, titulo, descripcion, fecha_publicacion, fecha_evento, lugar_hora) 
                 VALUES ('$tipo', '$img', '$titulo', '$descripcion', '$fecha_publicacion', '$fecha_evento', '$lugar_hora')";

    if (mysqli_query($conn, $consulta)) {
        header('Location: ../../dashboard/indexPublicaciones.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function editar_registro($conn) {
    extract($_POST);
    $consulta = "UPDATE novedades SET 
                    tipo = '$tipo', 
                    img = '$img', 
                    titulo = '$titulo', 
                    descripcion = '$descripcion',  
                    fecha_evento = '$fecha_evento', 
                    lugar_hora = '$lugar_hora' 
                WHERE id = '$id'";
    if (mysqli_query($conn, $consulta)) {
        header('Location: ../../dashboard/indexPublicaciones.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function eliminar_registro($conn) {
    extract($_POST);
    $id = $_POST['id'];
    $consulta = "DELETE FROM novedades WHERE id = $id";
    if (mysqli_query($conn, $consulta)) {
        header('Location: ../../dashboard/indexPublicaciones.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function buscar_registro($conn) {
    // Verificar si el campo de búsqueda está vacío
    if (empty($_POST['busqueda'])) {
        echo '
            <script>
                alert("Por favor ingrese un criterio de busqueda.");
                window.location.href="../../dashboard/indexUsuarios.php";
            </script>
        ';
    }

    $busqueda = $_POST['busqueda'];
    $consulta = "SELECT * FROM novedades WHERE titulo LIKE '%$busqueda%'";
    $resultado = mysqli_query($conn, $consulta);

    // Recoger los resultados en un array
    $resultados = array();
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $resultados[] = $fila;
    }
    return $resultados;
}
