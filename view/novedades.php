<?php
include("../dataAccess/bd.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patitas SOS Piura::Novedades</title>
    <!-- Páginas para el tipo de letra e iconos -->
    <script src="https://kit.fontawesome.com/24a7aa86be.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="../assets/estilos/novedades.css">
    <script src="../assets/js/script.js" defer></script>
    <script src="../assets/js/link.js" defer></script>
    <script src="../assets/js/chatbot.js" defer></script>
</head>

<body>
    <!-- HEADER -->
    <?php
    include("header.php");
    ?>
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
    <!-- IMAGEN INCIAL, PORTADA -->
    <section class="homepage" id="home">
        <div class="content">
            <div class="text">
                <h1>Explora las últimas novedades</h1>
                <p>
                    Últimas noticias y eventos en el mundo de Patitas SOS Piura.
            </div>
            <!--<a href="dona.php">Ayúdanos</a>-->
        </div>
    </section>
    <!-- NOTICIAS Y EVENTOS -->
    <h1 class="title-novedades">¡Descubre lo que está sucediendo!</h1>
    <div class="container-post">
        <input type="radio" id="TODOS" name="categories" value="TODOS" checked>
        <input type="radio" id="NOTICIA" name="categories" value="NOTICIA">
        <input type="radio" id="EVENTO" name="categories" value="EVENTO">

        <div class="container-category">
            <label for="TODOS">Todos</label>
            <label for="NOTICIA">Noticias</label>
            <label for="EVENTO">Eventos</label>
        </div>

        <div class="posts">
            <?php
            $sql = "SELECT * FROM novedades ORDER BY fecha_publicacion DESC";
            $result = $conn->query($sql);
            while ($mostrar = mysqli_fetch_array($result)) {
            ?>
                <div class="post" data-category="<?php echo $mostrar['tipo']; ?>">
                    <div class="ctn-img">
                        <img src="<?php echo $mostrar['img']; ?>">
                    </div>
                    <h2><?php echo $mostrar['titulo']; ?></h2>
                    <span><?php echo $mostrar['descripcion']; ?></span>
                    <ul class="ctn-tag">
                        <li>Publicado el: <?php echo $mostrar['fecha_publicacion']; ?></li>
                        <?php if ($mostrar['tipo'] === 'EVENTO') { ?>
                            <li class="evento_fecha">Fecha de evento: <?php echo $mostrar['fecha_evento']; ?></li>
                            <li class="evento_lugar"><?php echo $mostrar['lugar_hora']; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

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
                <p>¡Hola! 🐶🐱 Bienvenido a Patitas SOS Piura.<br>¿Cómo puedo ayudarte hoy? ❤️</p>
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