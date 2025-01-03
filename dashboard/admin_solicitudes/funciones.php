<?php

require_once ("../../dataAccess/bd.php");
global $conn;

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'actualizar_solicitud':
            actualizar_solicitud($conn); // Pasar la variable $conn como argumento
            break;
            
        case 'buscar_registro':
            buscar_registro($conn);
            break;
    }
}

function obtenerDetallesSolicitud($conn, $id_solicitud)
{
    // Asegúrate de que el ID de la solicitud sea seguro para usar en una consulta SQL
    $id_solicitud = intval($id_solicitud);

    // Define la consulta SQL
    $sql = "SELECT ds.id_detalle, p.nombre_pregunta, ds.respuesta
            FROM detalle_solicitud ds
            JOIN pregunta p ON ds.id_pregunta = p.id_pregunta
            WHERE ds.id_solicitud = $id_solicitud";

    // Ejecuta la consulta y devuelve el resultado
    return $conn->query($sql);
}

function actualizar_solicitud($conn)
{
    extract($_POST);
    $consulta = "UPDATE solicitud SET 
                    id_estado = '$estado', 
                    descripcion = '$descripcion' 
                WHERE id_solicitud = '$id'";
    if (mysqli_query($conn, $consulta)) {
        // Paso 1: Obtener el id_mascota de la tabla solicitud
        $sql_select = "SELECT id_mascota FROM solicitud WHERE id_solicitud = $id";
        $result = $conn->query($sql_select);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_mascota = $row['id_mascota'];

            // Paso 3: Actualizar el estado de adopción de la tabla bd_mascota según el estado
            if ($estado == 2) {
                $estado_adopcion = 1; // Estado adoptado
            } else {
                $estado_adopcion = 0; // Estado no adoptado
            }

            $sql_update_mascota = "UPDATE bd_mascota SET estado_adopcion = $estado_adopcion WHERE id_mascota = $id_mascota";

            if (mysqli_query($conn, $sql_update_mascota)) {
                header('Location: ../../dashboard/indexSolicitudes.php');
            } else {
                echo "Error al actualizar estado de adopción de la mascota: " . mysqli_error($conn);
            }
        } else {
            echo "No se encontró la mascota asociada a esta solicitud.";
        }
    } else {
        echo "Error al actualizar la solicitud: " . mysqli_error($conn);
    }
}

function buscar_registro($conn)
{
    // Verificar si el campo de búsqueda está vacío
    if (empty($_POST['busqueda'])) {
        echo '
            <script>
                alert("Por favor ingrese un criterio de búsqueda.");
                window.location.href="../../dashboard/indexSolicitudes.php";
            </script>
        ';
        exit; // Salir del script si el campo de búsqueda está vacío
    }

    // Sanitizar y escapar el valor de búsqueda para prevenir inyecciones SQL
    $busqueda = mysqli_real_escape_string($conn, $_POST['busqueda']);

    // Consulta SQL para buscar registros por nombre de mascota en la tabla solicitud
    $consulta = "SELECT s.id_solicitud, 
                        e.id_estado, 
                        u.nombres, 
                        m.nombre_mascota, 
                        e.estado, 
                        s.descripcion, 
                        s.fecha 
                 FROM solicitud s
                 INNER JOIN usuario u ON s.id_usuario = u.id_usuario
                 INNER JOIN bd_mascota m ON s.id_mascota = m.id_mascota
                 INNER JOIN estado_solicitud e ON s.id_estado = e.id_estado
                 WHERE m.nombre_mascota LIKE '%$busqueda%'";

    $resultado = mysqli_query($conn, $consulta);

    // Verificar si hay resultados
    if (!$resultado) {
        echo "Error al ejecutar la consulta: " . mysqli_error($conn);
        return array(); // Devolver un array vacío si hay error
    }

    // Recoger los resultados en un array
    $resultados = array();
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $resultados[] = $fila;
    }

    return $resultados;
}
