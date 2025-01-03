<?php
require_once("../dataAccess/bd.php");
session_start();
global $conn;

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Validación de campos vacíos
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $errors[] = "Por favor, complete todos los campos.";
    }

    // Validación de formato del email
    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El correo electrónico proporcionado no es válido.";
    }

    // Validación del captcha (si no ha sido validado antes)
    if (empty($_SESSION['captcha_validated']) || !$_SESSION['captcha_validated']) {
        $captcha = $_POST['g-recaptcha-response'];
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

    // Si no hay errores de captcha, continuar con la validación de credenciales
    if (empty($errors)) {
        $email = $_POST['email'];
        $clave = $_POST['password'];

        $sql = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($clave, $row['password'])) {
                $_SESSION['nombreUser'] = $row['nombres'];
                $_SESSION['idUser'] = $row['id_usuario'];
                $_SESSION['id_rol'] = $row['id_rol'];
                echo json_encode(['success' => true, 'redirect' => '../index.php']);
                exit();
            } else {
                $errors[] = "La contraseña proporcionada es incorrecta.";
            }
        } else {
            $errors[] = "Las credenciales proporcionadas son incorrectas.";
        }
        $sql->close();
    }

    echo json_encode(['success' => false, 'errors' => $errors]);
    exit();
}
?>
