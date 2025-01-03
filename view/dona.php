<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patitas SOS Piura::Dona</title>
    <!-- Páginas para el tipo de letra e iconos -->
    <script src="https://kit.fontawesome.com/24a7aa86be.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="../assets/estilos/ayudanos.css">
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
                <h1>Tu ayuda es esencial</h1>
                <p>
                    Tu generosidad alimenta, cuida y da
                    esperanza a los perritos
                    y gatitos que tanto lo necesitan.
            </div>
            <!--<a href="dona.php">Ayúdanos</a>-->
        </div>
    </section>

    <h1 class="title-dona">Canales de donación</h1>
    <div class="container-dona">
        <div class="yape">
            <p>
                ✅ Te invitamos a realizar un yape al siguiente número 963119856 (A nombre de la Asociación Patitas Sos
                Piura).
            </p>
            <img
                src="https://yt3.googleusercontent.com/l048nvZUXxmhjaDjxdJntZWSj03oOAK0ETKCQZup-Ea-aM_h8M94Jz87cw8JiwCHSEbv8llH=s900-c-k-c0x00ffffff-no-rj">
        </div>
        <div class="bcp">
            <p>
                ✅ Depositar a la Cuenta Ahorro soles BCP: 475-78705629-0-92 (A nombre
                de la Asociación Patitas Sos Piura).
            </p>
            <img
                src="https://yt3.googleusercontent.com/1il06CSbBwwG5lyybUYa6KnisWtswkvFPK9y2C92R3Vp5hd6rCdTBYD-TGKGAQt9V6FMMSXsxw=s900-c-k-c0x00ffffff-no-rj">
        </div>
        <div class="sos">
            <p>
                ✅ Comuníquese con nuestra voluntaria SOS Diana al 934836151 en caso de querer realizar otro tipo de
                donación.
                <img
                    src="https://about.fb.com/es/wp-content/uploads/sites/13/2020/04/WhatsApp_Logo_2-1.png">
            </p>
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