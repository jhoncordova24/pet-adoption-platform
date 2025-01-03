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

        case 'buscar_mascota':
            buscar_registro($conn);
            break;
    }
}

function crear_registro($conn) {
    extract($_POST);

    // Si la fecha de nacimiento no está establecida, usa la fecha de hoy
    $fecha_nacimiento = !empty($fecha_nacimiento) ? date('Y-m-d', strtotime($fecha_nacimiento)) : date('Y-m-d');

    $consulta = "INSERT INTO bd_mascota (nombre_mascota, fecha_nacimiento, sexo, largo_pelo, tamano, esterilizado, peso, id_especie, descripcion, foto_mascota, estado_adopcion, estado_medico, telefono_dueño) 
                 VALUES ('$nombre_mascota', '$fecha_nacimiento', '$sexo', '$largo_pelo', '$tamano', '$esterilizado', '$peso', '$id_especie', '$descripcion', '$foto_mascota', '$estado_adopcion', '$estado_medico', '$telefono_dueño')";

    if (mysqli_query($conn, $consulta)) {
        header('Location: ../../dashboard/indexMascotas.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function editar_registro($conn) {
    extract($_POST);
    $consulta = "UPDATE bd_mascota SET 
                    nombre_mascota = '$nombre_mascota', 
                    fecha_nacimiento = '$fecha_nacimiento', 
                    sexo = '$sexo', 
                    largo_pelo = '$largo_pelo', 
                    tamano = '$tamano', 
                    esterilizado = '$esterilizado', 
                    peso = '$peso', 
                    id_especie = '$id_especie', 
                    descripcion = '$descripcion', 
                    foto_mascota = '$foto_mascota', 
                    estado_adopcion = '$estado_adopcion', 
                    estado_medico = '$estado_medico', 
                    telefono_dueño = '$telefono_dueño' 
                WHERE id_mascota = '$id_mascota'";
    if (mysqli_query($conn, $consulta)) {
        header('Location: ../../dashboard/indexMascotas.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function eliminar_registro($conn) {
    extract($_POST);
    $id = $_POST['id_mascota'];
    $consulta = "DELETE FROM bd_mascota WHERE id_mascota = $id";
    if (mysqli_query($conn, $consulta)) {
        header('Location: ../../dashboard/indexMascotas.php');
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
                window.location.href="../../dashboard/indexMascotas.php";
            </script>
        ';
    }

    $busqueda = $_POST['busqueda'];
    $consulta = "SELECT bd_mascota.id_mascota, 
                        bd_mascota.nombre_mascota, 
                        bd_mascota.fecha_nacimiento, 
                        bd_mascota.sexo, 
                        bd_mascota.largo_pelo, 
                        bd_mascota.tamano, 
                        bd_mascota.esterilizado, 
                        bd_mascota.peso, 
                        bd_especie.nombre_especie AS nombre_especie, 
                        bd_mascota.descripcion, 
                        bd_mascota.foto_mascota, 
                        bd_mascota.estado_adopcion, 
                        bd_mascota.estado_medico,
                        bd_mascota.telefono_dueño 
                 FROM bd_mascota 
                 INNER JOIN bd_especie ON bd_mascota.id_especie = bd_especie.id_especie WHERE nombre_mascota LIKE '%$busqueda%'";
    $resultado = mysqli_query($conn, $consulta);

    // Recoger los resultados en un array
    $resultados = array();
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $resultados[] = $fila;
    }
    return $resultados;
}

