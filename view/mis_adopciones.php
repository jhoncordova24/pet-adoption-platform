<?php

include '../dataAccess/bd.php';
session_start();


if (!isset($_SESSION['idUser'])) {
    header('Location: ../index.php');
    exit;
}

$idUser = $_SESSION['idUser'];

try {
    // Consulta SQL 
    $sql = "SELECT s.id_solicitud, s.fecha, u.nombres AS nombre_usuario, m.nombre_mascota AS nombre_mascota, m.foto_mascota AS foto, e.estado AS estado, s.descripcion AS descripcion_estado, m.telefono_dueño AS telefono_dueño, m.estado_adopcion AS estado_adopcion
    FROM solicitud AS s
    INNER JOIN usuario AS u ON s.id_usuario = u.id_usuario
    INNER JOIN bd_mascota AS m ON s.id_mascota = m.id_mascota
    INNER JOIN estado_solicitud AS e ON s.id_estado = e.id_estado
    WHERE s.id_usuario = ?";

    // Preparamos la consulta
    $stmt = mysqli_prepare($conn, $sql);

    // Verificar si la preparación de la consulta falló
    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta: " . mysqli_error($conn));
    }

    // Asignar el valor del parámetro para la consulta
    mysqli_stmt_bind_param($stmt, "i", $idUser);

    // Ejecutar la consulta
    mysqli_stmt_execute($stmt);

    // Obtener el resultado de la consulta
    $result = mysqli_stmt_get_result($stmt);

    // Verificar si hay resultados
    if (mysqli_num_rows($result) > 0) {
        // Iterar sobre los resultados
        $resultados = [];
        while ($fila = mysqli_fetch_assoc($result)) {
            $resultados[] = $fila;
        }
    } else {
        error_log("No se encontraron registros.");
    }

    // Liberar el resultado
    mysqli_free_result($result);

    // Cerrar la declaración
    mysqli_stmt_close($stmt);
} catch (Exception $e) {
    echo "Error en la consulta: " . $e->getMessage();
    exit;
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patitas SOS Piura::MisAdopciones</title>
    <!-- Páginas para el tipo de letra e iconos -->
    <script src="https://kit.fontawesome.com/24a7aa86be.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Iconos chatbot -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="../assets/estilos/mis_adopciones.css">
    <!-- Link's CSS -->
    <script src="../assets/js/script.js" defer></script>
    <script src="../assets/js/chatbot.js" defer></script>

</head>
<header>
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            display: flex;
            align-items: center;
            cursor: pointer;
            background-color: #922b21;
            color: white;
            padding: 10px;
            border: none;
            font-size: 15px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 100%;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            transform: translateY(-10px);
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown:hover .dropdown-content {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .material-icons {
            margin-left: 8px;
        }
    </style>

    <nav class="navbar">
        <span class="hamburger-btn material-symbols-rounded">menu</span>
        <a href="../index.php" class="logo">
            <img src="../assets/img/logo.jpg" alt="logo">
            <h2>Patitas SOS Piura</h2>
        </a>
        <ul class="links">
            <span class="close-btn material-symbols-rounded">close</span>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../view/novedades.php">Novedades</a></li>
            <li><a href="../view/adopta.php">Adopta</a></li>
            <li><a href="../view/nosotros.php">Nosotros</a></li>
            <li><a href="../view/dona.php">Dona</a></li>
            <?php
            if (isset($_SESSION['nombreUser'])) {
                echo '<li class="dropdown">
            <button class="dropbtn">Bienvenido, ' . $_SESSION['nombreUser'] . '<span class="material-icons">arrow_drop_down</span></button>
            <div class="dropdown-content">
                <a href="../view/perfil.php" style="font-size: 16px;">Ver perfil</a>';

                // Mostramos la opción "Mis adopciones" solo si el usuario tiene el rol 1
                if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] == 1) {
                    echo '<a href="../view/mis_adopciones.php" style="font-size: 16px;">Mis adopciones</a>';
                }

                // Mostramos la opción "Administrar" solo si el usuario es administrador (rol 2 o 3)
                if (isset($_SESSION['id_rol']) && ($_SESSION['id_rol'] == 2 || $_SESSION['id_rol'] == 3)) {
                    echo '<a href="../dashboard/indexUsuarios.php" style="font-size: 16px;">Administrar</a>';
                }

                echo '<a href="../dataAccess/cerrar_sesion.php" style="font-size: 16px;">Cerrar sesión</a>
            </div>
          </li>';
            }
            ?>
        </ul>
        <?php
        if (!isset($_SESSION['nombreUser'])) {
            echo '<button class="login-btn">Únete</button>';
        }
        ?>
    </nav>

    <!-- Importar Material Icons de Google -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- FORMULARIOS -->
    <div class="blur-bg-overlay"></div>
    <div class="form-popup">
        <span class="close-btn material-symbols-rounded">close</span>
        <?php
        include("login.php");
        ?>
        <?php
        include("register.php");
        ?>
    </div>
</header>

<body>
    <?php
    echo '
    <h1 class="titulo">¡Hola ' . $_SESSION['nombreUser'] . ', revisa el estado de tus solicitudes de adopción!</h1>' ?>
    <table class="tabla-registros">
        <thead>
            <tr>
                <th>Fecha de la solicitud</th>
                <th>Nombre de la mascota</th>
                <th>Foto</th>
                <th>Estado de la solicitud</th>
                <th>Descripción</th>
                <th>Contacto</th>
            </tr>
        </thead>
        <tbody>

            <?php
            if (empty($resultados)) {
                echo '<tr><td colspan="6">No se encontraron solicitudes de adopción.</td></tr>';
            } else {
                foreach ($resultados as $fila):
            ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($fila['nombre_mascota']); ?></td>
                        <td><img class="img-mascota" src="<?php echo htmlspecialchars($fila['foto']); ?>"
                                alt="Descripción de la imagen"></td>
                        <td><?php echo htmlspecialchars($fila['estado']); ?></td>
                        <td><?php echo htmlspecialchars($fila['descripcion_estado']); ?></td>
                        <td>
                            <?php if ($fila['estado_adopcion'] == 1): ?>
                                <?php
                                $telefono = htmlspecialchars($fila['telefono_dueño']);
                                $nombre_mascota = htmlspecialchars($fila['nombre_mascota']);

                                $prefijo = "+51";


                                $telefono_completo = $prefijo . $telefono;
                                echo "<script>var telefonoDueño = '" . $telefono_completo . "';</script>";

                                ?>
                                <button class="button-info" id="openModalBtn"> Ver información
                                </button><br>
                                <a class="problem" href="reportar.php?id_solicitud=<?php echo $fila['id_solicitud']; ?>">¿Algo salió mal?</a>


                            <?php elseif ($fila['estado_adopcion'] == 0): ?>
                                Información no disponible.
                            <?php else: ?>

                            <?php endif; ?>
                        </td>
                    </tr>
            <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>

    <!-- CHATBOT -->
    <button class="chatbot-toggler">
        <span class="material-symbols-rounded">mode_comment</span>
        <span class="material-symbols-outlined">close</span>
    </button>
    <div class="chatbot">
        <header>
            <h2>Patitas Chatbot</h2>
            <span class="close-btn material-symbols-outlined">close</span>
        </header>
        <ul class="chatbox">
            <li class="chat incoming">
                <span class="material-symbols-outlined">smart_toy</span>
                <p>¡Hola! 🐶🐱 Bienvenido a Patitas SOS Piura.<br>¿Cómo puedo ayudarte hoy?</p>
            </li>
        </ul>
        <div class="chat-input">
            <textarea placeholder="Escribe tu mensaje..." spellcheck="false" required></textarea>
            <span id="send-btn" class="material-symbols-rounded">send</span>
        </div>
    </div>

    <script>
        document.getElementById('openModalBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Datos del Dueño',
                html: '<p><a href="../view/terminos.php" style="color: #dc143c; text-decoration: underline; font-size: 15px; text-align: center;">Consulta nuestros Términos y Condiciones para conocer nuestras limitaciones de responsabilidad al contactar con el dueño de la mascota.</a></p>' +
                    '<br>' +
                    '<p>Contáctate al: <a href="https://api.whatsapp.com/send?&text=¡Hola! He completado el proceso de adopción a través de Patitas SOS Piura y estoy dispuesto a adoptar a <?php echo urlencode($nombre_mascota); ?>." style="color: black; text-decoration: none; font-size: 17px; text-align: center;"><strong>' + telefonoDueño + '</a></strong></p>',
                showCancelButton: true,
                cancelButtonText: 'Cerrar',
                showConfirmButton: false, // Ocultar el botón de OK
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#922b21',
                backdrop: false,
            });
        });
    </script>
    <?php
    include("footer.php");
    ?>
</body>

</html>