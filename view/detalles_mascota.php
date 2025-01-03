<?php
session_start();
include("../dataAccess/bd.php");

// Verificar si se proporciona un ID de mascota válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Si no hay ID de mascota, redirigir al index
    header('Location: ../index.php');
    exit;
}

$isAuthenticated = isset($_SESSION['nombreUser']);

$mascota_id = base64_decode($_GET['id']);

$sql = "SELECT * FROM bd_mascota WHERE id_mascota = '$mascota_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Mascota no encontrada.";
    exit;
}

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

// Calcular la edad de la mascota
$edad = calcular_edad($row["fecha_nacimiento"]);

$esterilizado = $row["esterilizado"] ? "Sí" : "No";

if (isset($_POST['button-cuestionario'])) {
    $mascota_id = base64_decode($_GET['id']);
    if (isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])) {
        $user_id = $_SESSION['idUser'];
    }


    $fecha = date('Y-m-d');
    $preguntasRespuestas = [];

    // Recolectar respuestas de preguntas
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'pregunta_') === 0) {
            $pregunta_id = str_replace('pregunta_', '', $key);
            if ($pregunta_id == 1 || $pregunta_id == 3) {
                // Las preguntas 1 y 3 se manejan como texto
                $preguntasRespuestas[$pregunta_id] = $_POST[$key];
            } else {
                // Las demás preguntas se manejan como texto libre
                $preguntasRespuestas[$pregunta_id] = $value;
            }
        }
    }

    try {
        // Iniciar una transacción
        mysqli_begin_transaction($conn);
        $id_estado = 1;
        $descripcion = 'Solicitud por revisar';
        // Insertar la solicitud
        $stmt = $conn->prepare('INSERT INTO solicitud (id_usuario, id_mascota, id_estado, descripcion, fecha) VALUES (?, ?, ?, ?,?)');
        $stmt->bind_param('iiiss', $user_id, $mascota_id, $id_estado, $descripcion, $fecha);


        $stmt->execute();

        if ($stmt->errno) {
            throw new Exception("Error en la inserción de la solicitud: " . $stmt->error);
        }

        $solicitud_id = $conn->insert_id;

        // Insertar los detalles de la solicitud
        $stmt = $conn->prepare('INSERT INTO detalle_solicitud (id_solicitud, id_pregunta, respuesta) VALUES (?, ?, ?)');
        $stmt->bind_param('iis', $solicitud_id, $pregunta_id, $respuesta);

        foreach ($preguntasRespuestas as $pregunta_id => $respuesta) {
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Error en la inserción de detalle_solicitud: " . $stmt->error);
            }
        }

        // Confirmar la transacción
        mysqli_commit($conn);
        header('Location: mis_adopciones.php');
        exit;
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patitas SOS Piura::DetallesMascota</title>
    <!-- Páginas para el tipo de letra e iconos -->
    <script src="https://kit.fontawesome.com/24a7aa86be.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <!-- Iconos chatbot -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="../assets/estilos/detalles_mascota.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="../assets/js/script.js" defer></script>
    <script src="../assets/js/chatbot.js" defer></script>

</head>

<>
    <header>
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

                    // Mostrar opción "Mis adopciones" solo si el usuario tiene el rol 1
                    if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] == 1) {
                        echo '<a href="../view/mis_adopciones.php" style="font-size: 16px;">Mis adopciones</a>';
                    }

                    // Mostrar opción "Administrar" solo si el usuario es administrador (rol 2 o 3)
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
    </header>
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

    <h1 class="title-cards">Sigue estos pasos para una adopción exitosa</h1>
    <div class="card-father">
        <div class="card">
            <img src="../assets/img/paso1.png" class="image">
            <p class="number-h1">01</p>
            <p class="h1">Regístrate para empezar</p>
            <p class="p">Para comenzar el proceso de adopción, necesitas estar registrado en nuestra plataforma, esto
                nos ayuda a conocerte mejor.</p>
        </div>
        <div class="card">
            <img src="../assets/img/paso2.png" class="image">
            <p class="number-h1">02</p>
            <p class="h1">Completa el formulario de adopción con responsabilidad</p>
            <p class="p">Tu honestidad y respuestas coherentes son fundamentales, ya que queremos asegurarnos de que
                nuestros animales encuentren el mejor ambiente posible.</p>
        </div>
        <div class="card">
            <img src="../assets/img/paso3.png" class="image">
            <p class="number-h1">03</p>
            <p class="h1">Sigue el progreso de tu solicitud</p>
            <p class="p">Revisa regularmente la sección "Mis Adopciones" para conocer si tu solicitud ha sido aprobada o
                rechazada. Estaremos en contacto para mantenerte informado sobre el progreso de tu solicitud.</p>
        </div>
    </div>

    <div class="container-detalles">
        <div class="mascota-detalles">
            <img src="<?php echo $row["foto_mascota"]; ?>" alt="Foto de <?php echo $row["nombre_mascota"]; ?>">
            <div class="mascota-info">
                <h1><?php echo $row["nombre_mascota"]; ?></h1>
                <p><strong>Edad:</strong> <?php echo $edad; ?>.</p>
                <p><strong>Sexo:</strong> <?php echo $row["sexo"]; ?>.</p>
                <p><strong>Peso:</strong> <?php echo $row["peso"]; ?> Kg.</p>
                <p><strong>Tamaño:</strong> <?php echo $row["tamano"]; ?>.</p>
                <p><strong>Largo de pelo:</strong> <?php echo $row["largo_pelo"]; ?>.</p>
                <p><strong>Estado médico:</strong> <?php echo $row["estado_medico"]; ?></p>
                <p><strong>Esterilizado:</strong> <?php echo $esterilizado; ?>.</p>
                <p><strong>Descripción:</strong> <?php echo $row["descripcion"]; ?></p>
                <button class="button-adoptar" onclick="scrollToForm()">
                    <svg height="32" width="32" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="empty">
                        <path d="M0 0H24V24H0z" fill="none"></path>
                        <path
                            d="M16.5 3C19.538 3 22 5.5 22 9c0 7-7.5 11-10 12.5C9.5 20 2 16 2 9c0-3.5 2.5-6 5.5-6C9.36 3 11 4 12 5c1-1 2.64-2 4.5-2zm-3.566 15.604c.881-.556 1.676-1.109 2.42-1.701C18.335 14.533 20 11.943 20 9c0-2.36-1.537-4-3.5-4-1.076 0-2.24.57-3.086 1.414L12 7.828l-1.414-1.414C9.74 5.57 8.576 5 7.5 5 5.56 5 4 6.656 4 9c0 2.944 1.666 5.533 4.645 7.903.745.592 1.54 1.145 2.421 1.7.299.189.595.37.934.572.339-.202.635-.383.934-.571z">
                        </path>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" class="filled">
                        <path fill="none" d="M0 0H24V24H0z"></path>
                        <path
                            d="M16.5 3C19.538 3 22 5.5 22 9c0 7-7.5 11-10 12.5C9.5 20 2 16 2 9c0-3.5 2.5-6 5.5-6C9.36 3 11 4 12 5c1-1 2.64-2 4.5-2z">
                        </path>
                    </svg>
                    <a href="#adoptar">Adoptar</a>
                </button>


            </div>
        </div>
    </div>


    <div class="container" id="adoptar">
        <div class="title">Un paso hacia la felicidad. Adopta a <?php echo htmlspecialchars($row["nombre_mascota"]); ?>
        </div>
        <div class="content">
            <form action="" method="POST" id="formularioAdopcion">
                <div class="user-details">
                    <?php
                    $query = 'SELECT * FROM pregunta';
                    $result = mysqli_query($conn, $query);

                    while ($pregunta = mysqli_fetch_assoc($result)) {
                        echo '<div class="input-box">';
                        echo '<span class="details">' . htmlspecialchars($pregunta['nombre_pregunta']) . '</span>';

                        if ($pregunta['id_pregunta'] == 1 || $pregunta['id_pregunta'] == 3) {
                            // Opciones predefinidas para preguntas 1 y 3
                            echo '<select name="pregunta_' . $pregunta['id_pregunta'] . '" required class="custom-select"';
                            if (!$isAuthenticated) {
                                echo ' disabled';
                            }
                            echo '>';
                            echo '<option class="opciones" value="">Selecciona una opción</option>';
                            // Agregar opciones específicas aquí
                            if ($pregunta['id_pregunta'] == 1) {
                                echo '<option value="Busco compañía y afecto en mi hogar.">
                                Busco compañía y afecto en mi hogar.</option>';
                                echo '<option value="Quiero darle una segunda oportunidad a un animal necesitado.">
                                Quiero darle una segunda oportunidad a un animal necesitado.</option>';
                                echo '<option value="Estoy listo para asumir la responsabilidad de cuidar a una mascota.">
                                Estoy listo para asumir la responsabilidad de cuidar a una mascota.</option>';
                                echo '<option value="Quiero enseñar a mis hijos sobre el cuidado de los animales.">
                                Quiero enseñar a mis hijos sobre el cuidado de los animales.</option>';
                                echo '<option value="Siento que mi hogar puede brindarle un ambiente seguro y amoroso.">
                                Siento que mi hogar puede brindarle un ambiente seguro y amoroso.</option>';
                                echo '<option value="Me gustaría tener una mascota que se adapte a mi estilo de vida.">
                                Me gustaría tener una mascota que se adapte a mi estilo de vida.</option>';
                                echo '<option value="Creo que mi familia y yo estamos listos para darle un hogar permanente.">
                                Creo que mi familia y yo estamos listos para darle un hogar permanente.</option>';
                                echo '<option value="Estoy buscando un compañero de aventuras.">
                                Estoy buscando un compañero de aventuras.</option>';
                                echo '<option value="Quiero compartir mi vida con un animal que me haga feliz.">
                                Quiero compartir mi vida con un animal que me haga feliz.</option>';
                            } elseif ($pregunta['id_pregunta'] == 3) {
                                echo '<option value="Casa con patio o jardín.">
                                Casa con patio o jardín.</option>';
                                echo '<option value="Apartamento con espacio limitado pero accesible.">
                                Apartamento con espacio limitado pero accesible.</option>';
                                echo '<option value="Apartamento con acceso a áreas comunes al aire libre.">
                                Apartamento con acceso a áreas comunes al aire libre.</option>';
                                echo '<option value="Casa en el campo con espacio abierto.">
                                Casa en el campo con espacio abierto.</option>';
                                echo '<option value="Casa con acceso a áreas verdes">
                                Casa con acceso a áreas verdes</option>';
                            }
                            echo '</select>';
                        } else {
                            echo '<input type="text" name="pregunta_' . $pregunta['id_pregunta'] . '" placeholder="Cuéntanos" required';
                            if (!$isAuthenticated) {
                                echo ' disabled';
                            }
                            echo '>';
                        }

                        echo '</div>';
                    }
                    mysqli_free_result($result);
                    mysqli_close($conn);
                    ?>
                </div>
                <div class="button">
                    <?php if ($isAuthenticated): ?>
                        <input type="submit" value="Enviar solicitud de adopción" name="button-cuestionario">
                    <?php else: ?>
                        <button type="button" onclick="showAlert()">Enviar solicitud de adopción</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $("a[href^='#']").click(function(e) {
                e.preventDefault();
                var position = $($(this).attr("href")).offset().top;

                $("body, html").animate({
                    scrollTop: position
                }, 1000);
            });
        });
    </script>
    <script>
        function showAlert() {
            Swal.fire({
                icon: 'warning',
                title: 'Algo salió mal',
                text: 'Debes estar registrado o iniciar sesión para enviar tu solicitud de adopción.',
                confirmButtonColor: '#dc143c',
                backdrop: false,
            });
        }
    </script>

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

    <!-- Pie de página -->
    <?php
    include("footer.php");
    ?>
    </body>

</html>