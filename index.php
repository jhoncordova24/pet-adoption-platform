<?php
include("dataAccess/bd.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patitas SOS Piura::Inicio</title>
  <!-- Páginas para el tipo de letra e iconos -->
  <script src="https://kit.fontawesome.com/24a7aa86be.js" crossorigin="anonymous"></script>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
  <!-- Iconos chatbot -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
  <!-- Estilos CSS -->
  <link rel="stylesheet" href="../assets/estilos/index.css">
  <!-- Archivos JS -->
  <script src="../assets/js/script.js" defer></script>
  <script src="../assets/js/link.js" defer></script>
  <script src="../assets/js/carrouselindex.js" defer></script>
  <script src="../assets/js/chatbot.js" defer></script>
</head>

<body>
  <!-- HEADER -->
  <?php
  include("view/header.php");
  ?>
  <!-- FORMULARIOS -->
  <div class="blur-bg-overlay"></div>
  <div class="form-popup">
    <span class="close-btn material-symbols-rounded">close</span>
    <?php
    include("view/login.php");
    ?>
    <?php
    include("view/register.php");
    ?>
  </div>
  <!-- IMAGEN INCIAL, PORTADA -->
  <section class="homepage" id="home">
    <div class="content">
      <div class="text">
        <h1>Por una convivencia responsable</h1>
        <p>
          Construyendo un futuro donde todos los seres vivos sean valorados y respetados.
      </div>
      <a href="view/adopta.php">Adopta</a>
    </div>
  </section>
  <!-- Pequeña sección de NOSOTROS -->
  <section class="nosotros" id="nosotros">
    <h1>¿Quienes somos?</h1>
    <div class="wrapper">
      <div class="contenido">
        <h3>Patitas SOS Piura: Comprometidos con el Bienestar Animal</h3>
        <p>
          Patitas SOS Piura es una organización comprometida con el bienestar animal, enfocada en rescatar, cuidar y
          encontrar hogares
          responsables para animales en situación de abandono. Nuestra misión es promover el respeto y la protección de
          la vida animal,
          fomentando una cultura de cuidado y participación ciudadana.
          Trabajamos en colaboración con la comunidad y autoridades locales para asegurar un futuro mejor para nuestras
          mascotas.
        </p>
        <button class="animated-button">
          <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
            </path>
          </svg>
          <span class="text"><a href="view/nosotros.php">Leer más</a></span>
          <span class="circle"></span>
          <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
            </path>
          </svg>
        </button>
        <div class="social">
          <a href="https://www.facebook.com/patitasSOS"><i class="fa-brands fa-facebook"></i></a>
          <a href="https://www.instagram.com/patitassospiura/"><i class="fa-brands fa-instagram"></i></a>
        </div>
      </div>
      <div class="image-section">
        <img src="assets/img/nosotrosindex.jpg">
      </div>
  </section>
  <!-- Pequeña sección de NOVEDADES -->
  <div class="noticias">
    <h1 class="noticias-title">Novedades</h1>
    <?php
    $sql = "SELECT * FROM novedades ORDER BY fecha_publicacion DESC LIMIT 3";
    $result = $conn->query($sql);
    while ($mostrar = mysqli_fetch_array($result)) {
    ?>
      <div class="card">
        <div class="card-image">
          <img src="<?php echo $mostrar['img'] ?>">
        </div>
        <div class="card-details">
          <p class="text-title"><?php echo $mostrar['titulo'] ?></p>
          <!-- <p class="text-body"><?php echo $mostrar['descripcion'] ?></p>-->
        </div>
        <button class="card-button"><a href="view/novedades.php">Ver más</a></button>
      </div>
    <?php
    }
    ?>
  </div>

  <!-- Pequeña sección de ALGUNAS MASCOTAS PARA ADOPTAR -->
  <div class="carousel-wrapper">
    <h1 class="carrousel-title">¡Te están esperando!</h1>
    <p>Descubre a tus futuros compañeros de vida. Haz clic para conocer a las adorables mascotas que están esperando por
      ti
      y están listas para ser parte de tu familia.</p>
    <i id="left" class="fa-solid fa-angle-left"></i>
    <?php
    $sql = "SELECT * FROM bd_mascota ORDER BY id_mascota";
    $result = $conn->query($sql);
    ?>
    <ul class="carousel">
      <?php
      while ($mascota = mysqli_fetch_array($result)) {
      ?>
        <li class="card">
          <div class="img">
            <a href="view/adopta.php">
              <img src="<?php echo $mascota['foto_mascota']; ?>" alt="img" draggable="false">
            </a>
          </div>
          <h2><?php echo $mascota['nombre_mascota']; ?></h2>
        </li>
      <?php
      }
      ?>
    </ul>
    <i id="right" class="fa-solid fa-angle-right"></i>
  </div>

  <!-- Sección PARA INVITAR A DONAR -->
  <section class="donacion-seccion" id="donacion">
    <h1>¿Cómo puedes ayudar?</h1>
    <div class="contenedor">
      <div class="contenido">
        <h3>Apoya a Patitas SOS Piura con tu donación</h3>
        <p>
          Tu generosidad puede marcar una diferencia significativa en las vidas de los animales necesitados.
          Con tu valiosa donación, no solo estamos proporcionando atención médica, alimentos y refugio a los animales
          rescatados, sino que también estamos construyendo un futuro más brillante para todas las criaturas en nuestro
          planeta. Tu apoyo nos permite continuar nuestra misión de proteger y cuidar a aquellos que no pueden hacerlo
          por sí
          mismos. Juntos, podemos crear un mundo mejor donde todos los seres vivos puedan prosperar.
        </p>
        <a href="view/dona.php"><button class="c-button c-button--gooey">Realizar donación</a>
        <div class="c-button__blobs">
          <div></div>
          <div></div>
          <div></div>
        </div>
        </button>
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display: block; height: 0; width: 0;">
          <defs>
            <filter id="goo">
              <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
              <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo">
              </feColorMatrix>
              <feBlend in="SourceGraphic" in2="goo"></feBlend>
            </filter>
          </defs>
        </svg>
      </div>
      <div class="seccion-imagen">
        <img src="../assets/img/img_nosotros/nosotros1.jpg" alt="Imágen de donación">
      </div>
    </div>
  </section>

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

  <!-- PIE DE PAGINA -->
  <?php
  include("view/footer.php");
  ?>
</body>

</html>