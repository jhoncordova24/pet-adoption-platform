<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patitas SOS Piura::Adopta</title>
    <script src="https://kit.fontawesome.com/24a7aa86be.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <!-- Iconos chatbot -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="../assets/estilos/adopta.css">
    <script src="../assets/js/adopta.js" defer></script>
    <script src="../assets/js/filtros.js" defer></script>
    <script src="../assets/js/link.js" defer></script>
    <script src="../assets/js/chatbot.js" defer></script>

</head>

<body>
    <!-- HEADER -->
    <?php include("header.php"); ?>
    <!-- FORMULARIOS -->
    <div class="blur-bg-overlay"></div>
    <div class="form-popup">
        <span class="close-btn material-symbols-rounded">close</span>
        <?php
        include("login.php");
        include("register.php");
        ?>
    </div>
    <section class="homepage" id="home">
        <div class="content">
            <div class="text">
                <h1>Encuentra a tu compañero perfecto</h1>
                <p>Encuentra a tu compañero perfecto.</p>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="left-side">
            <div class="filtro-container">
                <form id="filtros-form" onsubmit="event.preventDefault(); applyFilters();">
                    <hr>
                    <div class="filtro">
                        <h3 onclick="toggleSubMenu('tamano')">
                            Tamaño
                            <span id="toggle-symbol-tamano">+</span>
                        </h3>
                        <div id="tamano" class="submenu">
                            <label><input class="filter-checkbox" type="checkbox" name="tamano[]" value="Pequeño"> Pequeño</label>
                            <label><input class="filter-checkbox" type="checkbox" name="tamano[]" value="Mediano"> Mediano</label>
                            <label><input class="filter-checkbox" type="checkbox" name="tamano[]" value="Grande"> Grande</label>
                        </div>
                    </div>
                    <hr>
                    <div class="filtro">
                        <h3 onclick="toggleSubMenu('largoPelo')">
                            Largo de pelo
                            <span id="toggle-symbol-largoPelo">+</span>
                        </h3>
                        <div id="largoPelo" class="submenu">
                            <label><input class="filter-checkbox" type="checkbox" name="largo_pelo[]" value="Largo"> Largo</label>
                            <label><input class="filter-checkbox" type="checkbox" name="largo_pelo[]" value="Mediano"> Mediano</label>
                            <label><input class="filter-checkbox" type="checkbox" name="largo_pelo[]" value="Corto"> Corto</label>
                        </div>
                    </div>
                    <hr>
                    <div class="filtro">
                        <h3 onclick="toggleSubMenu('esterilizado')">
                            Esterilizado
                            <span id="toggle-symbol-esterilizado">+</span>
                        </h3>
                        <div id="esterilizado" class="submenu">
                            <label><input class="filter-checkbox" type="checkbox" name="esterilizado[]" value="1"> Sí</label>
                            <label><input class="filter-checkbox" type="checkbox" name="esterilizado[]" value="0"> No</label>
                        </div>
                    </div>
                    <hr>
                    <div class="filtro">
                        <h3 onclick="toggleSubMenu('especie')">
                            Especie
                            <span id="toggle-symbol-especie">+</span>
                        </h3>
                        <div id="especie" class="submenu">
                            <label><input class="filter-checkbox" type="checkbox" name="especie[]" value="1"> Gato</label>
                            <label><input class="filter-checkbox" type="checkbox" name="especie[]" value="2"> Perro</label>
                        </div>
                    </div>
                    <hr>
                    <div class="filtro">
                        <h3 onclick="toggleSubMenu('sexo')">
                            Sexo
                            <span id="toggle-symbol-sexo">+</span>
                        </h3>
                        <div id="sexo" class="submenu">
                            <label><input class="filter-checkbox" type="checkbox" name="sexo[]" value="Hembra"> Hembra</label>
                            <label><input class="filter-checkbox" type="checkbox" name="sexo[]" value="Macho"> Macho</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="right-side">
            <div class="container-post">
                <div style="text-align: right; margin-bottom: 20px; margin-right: 20px;">
                    <br>
                    <label for="ordenar-por" style="margin-right: 10px;">Ordenar por:</label>
                    <select id="ordenar-por" onchange="ordenarPosts(this.value)" style="padding: 8px; cursor: pointer; border: 1px solid #ccc; border-radius: 5px;">
                        <option value="nuevo">Lo más nuevo</option>
                        <option value="nombre-az">Nombre de A-Z</option>
                        <option value="nombre-za">Nombre de Z-A</option>
                    </select>
                </div>
                <div class="filtros-container">
                    <h1 class="filtros-titulo" onclick="toggleMenu()">Filtros <span id="triangulo" class="triangulo-cerrado"></span></h1>
                    <div id="menu" class="menu">
                        <hr>
                        <div class="row">
                            <div class="filtros">
                                <h3>Tamaño
                                    <hr>
                                </h3>
                                <div id="tamano">
                                    <label><input class="filter-checkbox" type="checkbox" name="tamano[]" value="Pequeño"> Pequeño</label>
                                    <br>
                                    <label><input class="filter-checkbox" type="checkbox" name="tamano[]" value="Mediano"> Mediano</label>
                                    <br>
                                    <label><input class="filter-checkbox" type="checkbox" name="tamano[]" value="Grande"> Grande</label>
                                </div>
                            </div>
                            <div class="filtros">
                                <h3>Largo de pelo
                                    <hr>
                                </h3>
                                <div id="largo_pelo">
                                    <label><input class="filter-checkbox" type="checkbox" name="largo_pelo[]" value="Largo"> Largo</label>
                                    <br>
                                    <label><input class="filter-checkbox" type="checkbox" name="largo_pelo[]" value="Mediano"> Mediano</label>
                                    <br>
                                    <label><input class="filter-checkbox" type="checkbox" name="largo_pelo[]" value="Corto"> Corto</label>
                                </div>
                            </div>
                            <div class="filtros">
                                <h3>Esterilizado
                                    <hr>
                                </h3>
                                <div id="esterilizado">
                                    <label><input class="filter-checkbox" type="checkbox" name="esterilizado[]" value="1"> Sí</label>
                                    <br>
                                    <label><input class="filter-checkbox" type="checkbox" name="esterilizado[]" value="0"> No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="filtros">
                                <h3>Especie
                                    <hr>
                                </h3>
                                <div id="especie">
                                    <label><input class="filter-checkbox" type="checkbox" name="especie[]" value="1"> Gato</label>
                                    <br>
                                    <label><input class="filter-checkbox" type="checkbox" name="especie[]" value="2"> Perro</label>
                                </div>
                            </div>
                            <div class="filtros">
                                <h3>Sexo
                                    <hr>
                                </h3>
                                <div id="sexo">
                                    <label><input class="filter-checkbox" type="checkbox" name="sexo[]" value="Hembra"> Hembra</label>
                                    <br>
                                    <label><input class="filter-checkbox" type="checkbox" name="sexo[]" value="Macho"> Macho</label>
                                </div>
                            </div>
                            <div class="filtros">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="posts">
                    <?php
                    $count = 0;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $dataIdMascota = ' data-id-mascota="' . $row["id_mascota"] . '"';
                            if ($count >= 12) {
                                echo '<div class="post hidden" data-category="' . $row["id_especie"] . '"' . $dataIdMascota . '>';
                            } else {
                                echo '<div class="post" data-category="' . $row["id_especie"] . '"' . $dataIdMascota . '>';
                            }
                            echo '<img src="' . $row["foto_mascota"] . '" alt="Mascota">';
                            echo '<div class="overlay">';
                            echo '<h3>Nombre: ' . $row["nombre_mascota"] . '</h3>';
                            echo '<p>Edad: ' . calcular_edad($row["fecha_nacimiento"]) . '</p>';
                            echo '<p>Sexo: ' . $row["sexo"] . '</p>';
                            echo '</div>';
                            echo '<div class="post-content">';
                            echo '<a href="detalles_mascota.php?id=' . $row["id_mascota"] . '" class="adopt-btn">Más información</a>';
                            echo '</div>';
                            echo '</div>';
                            $count++;
                        }
                    } else {
                        echo "No hay mascotas disponibles.";
                    }
                    ?>
                </div>
                <div style="text-align: center; margin-bottom: 20px;">
                    <button id="mostrar-mas-btn" onclick="mostrarMas()" style="background-color: transparent; border: 2px solid #5D1A1A; color: #5D1A1A; padding: 8px 16px; cursor: pointer;">Mostrar Más</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ajustar la posición del filtro al cargar la página y al hacer scroll
            adjustFilterPosition();

            $(window).scroll(function() {
                adjustFilterPosition();
            });

            function adjustFilterPosition() {
                var posicionDeseada = $('.imagen-portada').outerHeight() + 20; // 20px de espacio adicional
                $('.filtro-container').css('top', posicionDeseada + 'px');
            }
        });
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