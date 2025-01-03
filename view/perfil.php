<?php
include '../dataAccess/bd.php';
session_start();
if (!isset($_SESSION['idUser'])) {
   header("Location: ../index.php");
   exit;
}
$user_id = $_SESSION['idUser'];
$user_name = $_SESSION['nombreUser'];

if (isset($_POST['update_profile'])) {

   $update_telefono = mysqli_real_escape_string($conn, $_POST['update_telefono']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
   $update_ubi = mysqli_real_escape_string($conn, $_POST['update_ubi']);
   $update_descrip = mysqli_real_escape_string($conn, $_POST['update_descrip']);

   mysqli_query($conn, "UPDATE `usuario` SET telefono = '$update_telefono', email = '$update_email', ubicacion = '$update_ubi', descripcion = '$update_descrip'
    WHERE id_usuario = '$user_id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   $update_pass = $_POST['update_pass'];
   $new_pass = $_POST['new_pass'];
   $confirm_pass = $_POST['confirm_pass'];

   if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
      // Comprobar que las nuevas contraseñas coincidan
      if ($new_pass !== $confirm_pass) {
         $message[] = '¡Las nuevas contraseñas no coinciden!';
      } else if (!password_verify($update_pass, $old_pass)) {
         // Verificar que la contraseña antigua sea correcta
         $message[] = '¡La contraseña actual no coincide!';
      } else {
         // Hashear la nueva contraseña y actualizar en la base de datos si la antigua es correcta
         $hashed_new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
         $update_query = "UPDATE `usuario` SET password = '$hashed_new_pass' WHERE id_usuario = '$user_id'";
         if (mysqli_query($conn, $update_query)) {
            $message[] = '¡Contraseña actualizada correctamente!';
         } else {
            $message[] = 'Error al actualizar la contraseña: ' . mysqli_error($conn);
         }
      }
   }

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = '../assets/img/uploaded_img/' . $update_image;

   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $message[] = 'La imagen es demasiado grande';
      } else {
         $image_update_query = mysqli_query($conn, "UPDATE `usuario` SET image = '$update_image' WHERE id_usuario = '$user_id'") or die('query failed');
         if ($image_update_query) {
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
            $message[] = '¡Imagen actualizada con éxito!';
         }
      }
   }

}
?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Patitas SOS Piura::PerfilDeUsuario</title>
   <script src="https://kit.fontawesome.com/24a7aa86be.js" crossorigin="anonymous"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
   <link rel="stylesheet" href="../assets/estilos/perfil.css">
   <script src="../assets/js/script.js" defer></script>
   <script>
      // Elimina el mensaje después de 5 segundos
      setTimeout(function () {
         var messageElement = document.querySelector('.message');
         if (messageElement) {
            messageElement.remove();
         }
      }, 5000);
   </script>
</head>
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
   include ("login.php");
   ?>
   <?php
   include ("register.php");
   ?>
</div>

<body>
   <div class="update-profile">
      <?php
      $select = mysqli_query($conn, "SELECT * FROM `usuario` WHERE id_usuario = '$user_id'") or die('query failed');
      if (mysqli_num_rows($select) > 0) {
         $fetch = mysqli_fetch_assoc($select);
      }
      ?>
      <form action="" method="post" enctype="multipart/form-data">
         <h1 class="perfil-tittle">Bienvenido a tu perfil, <?php echo $user_name; ?></h1>
         <?php
         if ($fetch['image'] == '') {
            echo '<img src="../assets/img/default-avatar.png">';
         } else {
            echo '<img src="../assets/img/uploaded_img/' . $fetch['image'] . '">';
         }
         if (isset($message)) {
            foreach ($message as $message) {
               echo '<div class="message">' . $message . '</div>';
            }
         }
         ?>
         <div class="flex">
            <div class="inputBox">
               <span>Actualiza tu foto de perfil:</span>
               <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
               <span>Teléfono:</span>
               <input type="text" name="update_telefono" placeholder="Ingresa tu número telefónico"
                  value="<?php echo $fetch['telefono']; ?>" class="box">
               <span>Descripción:</span>
               <input type="text" name="update_descrip" placeholder="Cuentanos sobre ti"
                  value="<?php echo $fetch['descripcion']; ?>" class="box">

               <span>Ingresa tu ubicación:</span>
               <input type="text" name="update_ubi" placeholder="Ingresa tu ubicación"
                  value="<?php echo $fetch['ubicacion']; ?>" class="box">
            </div>
            <div class="inputBox">
               <span>Actualiza tu correo electrónico:</span>
               <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">

               <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
               <span>Ingresa tu contraseña:</span>
               <input type="password" name="update_pass" placeholder="Ingresa tu contraseña actual" class="box">
               <span>Crea tu nueva contraseña:</span>
               <input type="password" name="new_pass" placeholder="Ingresa tu nueva contraseña" class="box">
               <span>Confirma tu nueva contraseña:</span>
               <input type="password" name="confirm_pass" placeholder="Confirma tu nueva contraseña" class="box">
            </div>
         </div>
         <input type="submit" value="Actualizar perfil" name="update_profile" class="btn">
         <a href="../index.php" class="delete-btn">Regresar</a>
      </form>
   </div>
   <?php
   include ("footer.php");
   ?>
</body>

</html>