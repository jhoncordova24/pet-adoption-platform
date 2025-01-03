<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        .error {
            color: #922b21;
            font-size: 12px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            z-index: 1000;
        }

        .modal.visible {
            display: block;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .modal-overlay.visible {
            display: block;
        }

        .close-modal {
            margin-top: 20px;
            border: none;
            background-color: #922b21;
            color: white;
            padding: 10px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="form-box login">
        <div class="form-details">
            <h2>Bienvenido</h2>
            <p>Nos alegra verte de regreso. Juntos, seguiremos haciendo una diferencia en las vidas de nuestras mascotas adoptadas.</p>
        </div>
        <div class="form-content">
            <h2>Inicia Sesión</h2>
            <form id="loginForm">
                <div class="input-field">
                    <input type="email" required name="email" id="email">
                    <label>Correo electrónico</label>
                    <span class="error" id="emailError"></span>
                </div>
                <div class="input-field">
                    <input type="password" required name="password" id="password">
                    <label>Contraseña</label>
                    <span class="error" id="passwordError"></span>
                </div>
                <div class="input-field">
                    <div id="recaptcha-container"></div>
                    <span class="error" id="captchaError"></span>
                </div>
                <br>
                <button type="submit">Iniciar Sesión</button>
            </form>
            <div class="bottom-link">
                No tienes una cuenta? <a href="#" id="signup-link">Registrate</a>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar errores -->
    <div class="modal-overlay" id="modal-overlay"></div>
    <div class="modal" id="errorModal">
        <p id="modalMessage"></p>
        <button class="close-modal" onclick="closeModal()">Cerrar</button>
    </div>

    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('recaptcha-container', {
                'sitekey': '6LeyJeEpAAAAAM9nKgYpbMmHQgimIeksggdo6g-p'
            });
        };

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Captura los datos del formulario
            const formData = new FormData(this);

            // Envía la solicitud AJAX
            fetch('../dataAccess/login_usuario.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect; // Redirige si el login es exitoso
                    } else {
                        showModal(data.errors); // Muestra los errores en el modal
                    }
                })
                .catch(error => {
                    showModal(["Ocurrió un error al procesar la solicitud."]);
                });
        });

        function showModal(errors) {
            const modal = document.getElementById('errorModal');
            const overlay = document.getElementById('modal-overlay');
            const modalMessage = document.getElementById('modalMessage');

            // Limpia mensajes previos y añade los nuevos errores
            modalMessage.innerHTML = errors.map(err => `<p>${err}</p>`).join('');

            modal.classList.add('visible');
            overlay.classList.add('visible');
        }

        function closeModal() {
            const modal = document.getElementById('errorModal');
            const overlay = document.getElementById('modal-overlay');
            modal.classList.remove('visible');
            overlay.classList.remove('visible');
        }
    </script>

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
</body>

</html>