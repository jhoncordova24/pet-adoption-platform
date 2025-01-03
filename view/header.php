<?php session_start(); ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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