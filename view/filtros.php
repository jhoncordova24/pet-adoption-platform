<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_patitas_sos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM bd_mascota WHERE estado_adopcion = 0"; // Cambiado a bd_mascota

$filtros_aplicados = false;

if (!empty($_GET['especie'])) {
    $especie = implode("','", $_GET['especie']);
    $sql .= " AND id_especie IN ('$especie')";
    $filtros_aplicados = true;
}

if (!empty($_GET['tamano'])) {
    $tamano = implode("','", $_GET['tamano']);
    $sql .= " AND tamano IN ('$tamano')";
    $filtros_aplicados = true;
}

if (!empty($_GET['largo_pelo'])) {
    $largo_pelo = implode("','", $_GET['largo_pelo']);
    $sql .= " AND largo_pelo IN ('$largo_pelo')";
    $filtros_aplicados = true;
}

if (!empty($_GET['esterilizado'])) {
    $esterilizado = implode("','", $_GET['esterilizado']);
    $sql .= " AND esterilizado IN ('$esterilizado')";
    $filtros_aplicados = true;
}

if (!empty($_GET['sexo'])) {
    $sexo = implode("','", $_GET['sexo']);
    $sql .= " AND sexo IN ('$sexo')";
    $filtros_aplicados = true;
}

if (!$filtros_aplicados) {
    $sql = "SELECT * FROM bd_mascota WHERE estado_adopcion = 0
    ORDER BY id_mascota DESC ";
}

$result = $conn->query($sql);

$count = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($count >= 12) {
            echo '<div class="post hidden" data-category="' . $row["id_especie"] . '">';
        } else {
            echo '<div class="post" data-category="' . $row["id_especie"] . '">';
        }
        echo '<img src="' . $row["foto_mascota"] . '" alt="Mascota">';
        echo '<div class="overlay">';
        echo '<h3>Nombre: ' . $row["nombre_mascota"] . '</h3>';
        echo '<p>Edad: ' . calcular_edad($row["fecha_nacimiento"]) . '</p>';
        echo '<p>Sexo: ' . $row["sexo"] . '</p>';
        echo '</div>';
        echo '<div class="post-content">';
        $id_mascota = $row["id_mascota"];
        $enlace_codificado = base64_encode($id_mascota);
        echo '<a href="detalles_mascota.php?id=' . $enlace_codificado . '" class="adopt-btn">Más información</a>'; // Actualizado
        echo '</div>';
        echo '</div>';
        $count++;
    }
} else {
    echo "No hay mascotas disponibles.";
}
$conn->close();

function calcular_edad($fecha_nacimiento)
{
    $hoy = new DateTime();
    $nacimiento = new DateTime($fecha_nacimiento);
    $edad = $hoy->diff($nacimiento);

    $anios = $edad->y;
    $meses = $edad->m;

    $edad_texto = '';

    if ($anios > 0) {
        $edad_texto .= $anios . ($anios == 1 ? ' año' : ' años');
    }

    if ($meses > 0) {
        if ($anios > 0) {
            $edad_texto .= ' y ';
        }
        $edad_texto .= $meses . ($meses == 1 ? ' mes' : ' meses');
    }

    return $edad_texto;
}


?>
