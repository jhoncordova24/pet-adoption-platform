<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patitas SOS Piura::Nosotros</title>
  <!-- Páginas para el tipo de letra e iconos -->
  <script src="https://kit.fontawesome.com/24a7aa86be.js" crossorigin="anonymous"></script>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
  <!-- Iconos chatbot -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
  <link rel="stylesheet" href="../assets/estilos/nosotros.css">
  <script src="../assets/js/script.js" defer></script>
  <script src="../assets/js/nosotros.js" defer></script>
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
  <section class="banner">
    <div class="content-banner">
      <div class="text">
        <h2>Patitas SOS Piura</h2>
        <p>
          Buscamos proteger la vida de perros y gatos en estado de maltrato y <br> abandono. Les brindamos alimentos,
          medicamentos y albergue, con <br> el fin de mejorar su calidad de vida y conseguirles un hogar.
        </p>
        <!-- <a href="#footer"></a> -->
      </div>
    </div>
  </section>
  <section class="nosotros">
    <fieldset class="marco-nosotros">
      <h1>¿Quienes somos?</h1>
      <br>
      <div class="wrapper">
        <div class="contenido">
          <h3>Patitas SOS Piura: Comprometidos con el Bienestar Animal</h3>
          <p>
            PATITAS SOS PIURA es una organización de voluntarios comprometidos con el bienestar animal, especialmente
            enfocada
            en ayudar a los animales callejeros. Nuestro objetivo es promover una cultura de respeto y cuidado hacia la
            vida animal.
            Brindamos asistencia a animales abandonados, procurando su bienestar y facilitando su adopción en hogares
            responsables.
            Además, fomentamos la colaboración de la comunidad, gobiernos locales, regionales e instituciones privadas
            en acciones para el bienestar animal.
          </p>
        </div>
      </div>
    </fieldset>
  </section>
  <div class="container">
    <div class="slider-wrapper">
      <button id="prev-slide" class="slide-button material-symbols-rounded">
        chevron_left
      </button>
      <ul class="image-list">
        <img class="image-item" src="/assets/img/img_nosotros/nosotros1.jpg" alt="img-1" />
        <img class="image-item" src="/assets/img/img_nosotros/nosotros2.jpg" alt="img-2" />
        <img class="image-item" src="/assets/img/img_nosotros/nosotros3.jpg" alt="img-3" />
        <img class="image-item" src="/assets/img/img_nosotros/nosotros4.jpg" alt="img-4" />
        <img class="image-item" src="/assets/img/img_nosotros/nosotros5.jpg" alt="img-5" />
        <img class="image-item" src="/assets/img/img_nosotros/nosotros6.jpg" alt="img-6" />
        <img class="image-item" src="/assets/img/img_nosotros/nosotros7.jpg" alt="img-7" />
        <img class="image-item" src="/assets/img/img_nosotros/nosotros8.jpg" alt="img-8" />
        <img class="image-item" src="/assets/img/img_nosotros/nosotros9.jpg" alt="img-9" />
        <img class="image-item" src="/assets/img/img_nosotros/nosotros10.jpeg" alt="img-10" />
      </ul>
      <button id="next-slide" class="slide-button material-symbols-rounded">
        chevron_right
      </button>
    </div>
    <div class="slider-scrollbar">
      <div class="scrollbar-track">
        <div class="scrollbar-thumb"></div>
      </div>
    </div>
  </div>

  <br>
  <br>

  <div class="mision">
    <h4 class="mision-titleUno">TRABAJANDO EN PRO DE LOS ANIMALES</h4>
    <h1 class="mision-titleDos">NUESTRA MISION</h1>
    <div class="card-pro">
      <div class="content">
        <p class="heading">LO QUE HACEMOS
        </p>
        <p class="para">
          El actuar como un puente entre fundaciones de adopción de mascotas y aquellos que desean dar un hogar amoroso
          a una mascota necesitada.
          Nos esforzamos por facilitar el proceso de adopción al proporcionar apoyo logístico, recursos y visibilidad a
          estas fundaciones.
        </p>
      </div>
    </div>
    <div class="card-pro">
      <div class="content">
        <p class="heading">LO QUE QUEREMOS
        </p>
        <p class="para">
          Promover la sensibilización colectiva fomentando la esterilización, el respeto a la vida, el NO al maltrato
          animal y
          la adopción responsable y soñamos con convertirnos en una organización líder en
          la protección y preservación de los animales que son víctimas del maltrato y la indiferencia.
        </p>
      </div>
    </div>
  </div>

  <section class="videoBanner">
    <div class="content-videoBanner">
      <fieldset class="marco-videoBanner">
        <div class="text-videoBanner">
          <br>
          <h2>HEMOS RESCATADO MÁS DE 300 PELUDOS</h2>
          <p>
            Muchos han sido felizmente adoptados,
            otros nos han enseñado a no darnos por vencidos y son ejemplo de perseverancia y gratitud.
            Algunos ya no nos acompañan, pero nos queda la sensación de haberles permitido conocer la bondad humana.
            Y están los que habitan el refugio y que siguen esperando una oportunidad para tener una familia y llenar
            sus hogares de alegría y amor.
            Puede que no salvemos millones de animales de la calle que existen, pero ayudaremos a los que estén a
            nuestro alcance,
            a los que el universo nos coloque en el camino.
          </p>
          <br>
          <iframe width="400" height="200" src="https://www.youtube.com/embed/1SjZTEToCnM?si=FjQqNJd4w6MXILbD"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <br>
      </fieldset>
    </div>
  </section>

  <br>
  <br>

  <div class="ayudarnos">
    <div class="titulos">
      <div class="tituloUno">
        <h4 class="ayudarnos-titleUno">NECESITAMOS TU AYUDA</h4>
      </div>
      <div class="tituloDos">
        <h1 class="ayudarnos-titleDos">Haz parte del cambio</h1>
      </div>
      <div class="ayudarnos-contenido">
        <div class="ayudarnos-contenidoUno">
          <span class="logoAyudarnos"><i class="fa-solid fa-house-chimney"></i></span>
          <h5><a href="#">Adopta</a></h5>
          <p>¡Descubre el amor en forma de patitas en nuestra página web! Encuentra a tu compañero peludo perfecto y
            cambia su vida para siempre. ¡Adopta hoy y llena tu hogar de alegría y compañerismo! Visita nuestro sitio
            web y da el primer paso hacia una nueva amistad.</p>
        </div>
        <div class="ayudarnos-contenidoDos">
          <span class="logoAyudarnos"><i class="fa-solid fa-paw"></i></span>
          <h5><a href="#">Padrinar</a></h5>
          <p>Conviértete en padrino de uno de nuestros adorables perritos. Tu apoyo garantiza su bienestar y felicidad
            mientras esperan su hogar definitivo. ¡Únete a nosotros y sé parte de esta noble causa! Navega en nuestra
            página web para más información.</p>
        </div>
      </div>
      <div class="ayudarnos-contenido">
        <div class="ayudarnos-contenidoUno">
          <span class="logoAyudarnos"><i class="fa-solid fa-hand-holding-dollar"></i></span>
          <h5><a href="#">Dona</a></h5>
          <p>¡Tu apoyo es crucial para salvar vidas caninas! Con tu donación, proporcionamos cuidados médicos, alimentos
            y refugio a perritos necesitados. Únete a nuestra causa y marca la diferencia. ¡Dona hoy para darles una
            segunda
            oportunidad llena de amor y cuidado!</p>
        </div>
        <div class="ayudarnos-contenidoDos">
          <span class="logoAyudarnos"><i class="fa-solid fa-user-group"></i></span>
          <h5><a href="#">Difunde</a></h5>
          <p>
            ¡Ayúdanos a encontrar hogares para nuestros adorables perritos! Comparte nuestro sitio web y difunde el
            mensaje de adopción. Juntos, podemos hacer que más perritos encuentren amor y cariño en un hogar para
            siempre.</p>
        </div>
      </div>
    </div>
  </div>

  <section class="pedido">
    <fieldset class="pedido-nosotros">
      <div class="pedido-wrapper">
        <div class="pedido-contenido">
          <br>
          <h3>Necesitamos tu apoyo</h3>
          <p>
            Queremos cada día poder ayudar a más y más peludos, es por eso que creamos Patitas SOS Piura.
            Si puedes abrirle un espacio en tu hogar de forma temporal a uno de nuestros peludos, te invitamos a
            inscribirte.
          </p>
          <br>
        </div>
      </div>
    </fieldset>
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

  <!-- Pie de página -->
  <?php include("footer.php"); ?>
</body>

</html>