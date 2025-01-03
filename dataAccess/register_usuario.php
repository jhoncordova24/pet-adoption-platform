<?php
require_once("../dataAccess/bd.php");
session_start();
global $conn;

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = []; // Array para almacenar los errores

    // Obtenemos los datos del formulario
    $nombre = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $fecha_nacimiento = $_POST['edad'] ?? '';
    $email = $_POST['email'] ?? '';
    $contrasena = $_POST['password'] ?? '';

    // Validación de campos vacíos
    if (empty($nombre) || empty($apellidos) || empty($fecha_nacimiento) || empty($email) || empty($contrasena)) {
        $errors[] = "Por favor, complete todos los campos.";
    }

    // Validación del formato del correo electrónico
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El correo electrónico proporcionado no es válido.";
    }

    // Validación de la fecha de nacimiento y la edad
    function calcularEdad($fecha_nacimiento)
    {
        try {
            $hoy = new DateTime();
            $fecha_nac = new DateTime($fecha_nacimiento);

            if ($fecha_nac > $hoy) {
                throw new Exception("Fecha de nacimiento no válida.");
            }

            $edad = $hoy->diff($fecha_nac);
            return $edad->y;
        } catch (Exception $e) {
            return false;
        }
    }
    $edad_usuario = calcularEdad($fecha_nacimiento);

    if ($edad_usuario === false || $edad_usuario < 18) {
        $errors[] = "Debes ser mayor de edad y proporcionar una fecha válida.";
    }

    // Verificación del captcha
    if (empty($_SESSION['captcha_validated']) || !$_SESSION['captcha_validated']) {
        $captcha = $_POST['g-recaptcha-response'] ?? '';
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => '6LeyJeEpAAAAABAxflK9ij_aSPInziXAGcjLqwpT',
            'response' => $captcha,
        ];
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($data),
            ],
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $json = json_decode($response, true);

        if (!$json['success']) {
            $errors[] = "Por favor, verifica que eres humano.";
        } else {
            $_SESSION['captcha_validated'] = true;
        }
    }

    // Si no hay errores, procedemos con el registro
    if (empty($errors)) {
        // Verificamos si el correo ya existe en la base de datos
        $checkEmail = "SELECT * FROM usuario WHERE email = ?";
        $stmt = $conn->prepare($checkEmail);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "El correo electrónico proporcionado ya existe.";
        } else {
            // Hashear la contraseña
            $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

            // Insertar los datos del usuario
            $insertQuery = "INSERT INTO usuario (nombres, apellidos, edad, email, password, id_rol) 
                            VALUES (?, ?, ?, ?, ?, 1)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sssss", $nombre, $apellidos, $fecha_nacimiento, $email, $hashed_password);

            if ($stmt->execute()) {
                // Guardar los datos del usuario en sesión
                $last_id = $conn->insert_id;
                $_SESSION['nombreUser'] = $nombre;
                $_SESSION['idUser'] = $last_id;
                $_SESSION['id_rol'] = 1; // Aseguramos que el rol del usuario sea 1 (usuario regular)

                echo json_encode(['success' => true, 'redirect' => '../index.php']);
                exit();
            } else {
                $errors[] = "Hubo un error al registrar al usuario. Por favor, inténtelo nuevamente.";
            }
        }
        $stmt->close();
    }

    // Si hay errores, los devolvemos en formato JSON
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit();
}
