<style>
    .modal-content {
        font-family: Arial, sans-serif;
        font-size: 13px;
        line-height: 1.6;
        color: #666;
        text-align: justify;
    }

    .modal-section-title {
        color: #dc143c;
        font-size: 17px;
    }

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
<!-- FORMULARIO DE REGISTRO -->
<div class="form-box signup">
    <div class="form-details">
        <h2>Crea tu cuenta</h2>
        <p>Descubre cómo puedes cambiar la vida de una mascota. Únete a nosotros y comienza tu viaje hacia la adopción
            hoy mismo.</p>
    </div>
    <div class="form-content">
        <h2>Registrate</h2>
        <form action="../dataAccess/register_usuario.php" method="POST" id="registerForm">
            <div class="input-field">
                <input type="text" required pattern="[a-zA-ZáéíóúÁÉÍÓÚ\s]+" title="Ingresa solo letras" name="nombres">
                <label>Ingresa tu nombre</label>
            </div>
            <div class="input-field">
                <input type="text" required pattern="[a-zA-ZáéíóúÁÉÍÓÚ\s]+" title="Ingresa solo letras"
                    name="apellidos">
                <label>Ingresa tus apellidos</label>
            </div>
            <div class="input-field">
                <input
                    type="date"
                    required
                    name="edad"
                    max="<?php echo date('Y-m-d'); ?>"
                    min="<?php echo date('Y-m-d', strtotime('-120 years')); ?>">
                <label>Ingresa tu fecha de nacimiento</label>
            </div>
            <div class="input-field">
                <input type="email" required name="email">
                <label>Ingresa tu correo electrónico</label>
            </div>
            <div class="input-field">
                <input type="password" required name="password">
                <label>Crea tu contraseña</label>
            </div>
            <div class="policy-text">
                <input type="checkbox" id="policy" required>
                <label for="policy">
                    Acepto los
                    <a href="view/terminos.php" id="terms-link" class="option">Términos y condiciones</a>
                </label>
            </div>
            <div class="input-field">
                <div class="g-recaptcha" data-sitekey="6LeyJeEpAAAAAM9nKgYpbMmHQgimIeksggdo6g-p"></div>
            </div>
            <br>
            <button type="submit" name="signUp">Registrarse</button>
        </form>
        <div class="bottom-link">
            ¿Ya tienes una cuenta?
            <a href="#" id="login-link">Inicia Sesión</a>
        </div>
    </div>
</div>

<!-- Modal para mostrar errores -->
<div class="modal-overlay" id="modal-overlay"></div>
<div class="modal" id="errorModal">
    <p id="modalMessage"></p>
    <button class="close-modal" onclick="closeModal()">Cerrar</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var termsLink = document.getElementById('terms-link');
        var checkBox = document.getElementById('policy');

        termsLink.addEventListener('click', function(event) {
            event.preventDefault(); // Evita la acción predeterminada del enlace (redireccionamiento)

            Swal.fire({
                title: 'Términos y condiciones',
                html: `
                <div class="modal-content">
                    
                    <p>
                        Al utilizar nuestro sitio web, usted acepta cumplir y estar sujeto a los siguientes términos y condiciones de uso. Estos términos, junto con nuestra política de privacidad, regulan la relación entre usted y nuestra organización en relación a este sitio web. Si no está de acuerdo con alguna parte de estos términos y condiciones, le recomendamos no utilizar nuestro sitio web.
                    </p>
                    <h2 class="modal-section-title">1. Definiciones</h2>
                    <p>
                        En nuestro sitio web, solo los usuarios registrados tienen la capacidad de adoptar mascotas disponibles. Los usuarios no registrados pueden explorar y ver información sobre las mascotas, pero para iniciar el proceso de adopción, es necesario registrarse en el sitio.
                        Los dueños de las mascotas proporcionan la información necesaria exclusivamente al administrador del sitio, quien luego la publica junto con un número de contacto correspondiente. Esto permite a los usuarios registrados contactar directamente para obtener más información o comenzar el proceso de adopción de una mascota.
                    </p>
                    <h2 class="modal-section-title">2. Registro de usuario</h2>
                    <p>
                        Para utilizar ciertas funciones del sitio web, usted debe registrarse y crear una cuenta. Al registrarse, se compromete a proporcionar información verdadera, precisa, actual y completa.
                    </p>
                    <h2 class="modal-section-title">3. Uso del sitio web</h2>
                    <p>
                        Usted se compromete a utilizar este sitio web exclusivamente para fines legales y de manera que no infrinja los derechos de terceros ni restrinja o inhiba su uso y disfrute del mismo.
                    </p>
                    <h2 class="modal-section-title">4. Proceso de adopción</h2>
                    <p>
                        La adopción de una mascota a través de nuestro sitio web está sujeta a la aprobación por parte del administrador. Una vez aprobada, facilitaremos los detalles de contacto del dueño de la mascota al adoptante. Es importante destacar que la organización no asume responsabilidad por cualquier problema que pueda surgir durante o después del proceso de adopción entre el dueño y el adoptante.
                    </p>
                    <h2 class="modal-section-title">5. Privacidad y protección de datos</h2>
                    <p>
                        Respetamos su privacidad y estamos comprometidos a proteger sus datos personales. Su información personal
                        será utilizada únicamente para los fines específicos relacionados con esta solicitud. No compartiremos sus
                        datos con terceros sin su consentimiento explícito.
                    </p>
                    <h2 class="modal-section-title">6. Responsabilidad</h2>
                    <p>
                        Patitas SOS Piura no será responsable de ninguna pérdida o daño que pueda derivarse del uso del sitio web o de la adopción de una mascota, y no garantizamos la exactitud, integridad o utilidad de la información proporcionada por los usuarios del sitio.
                    </p>
                    <h2 class="modal-section-title">7. Términos del servicio</h2>
                    <p>
                        Podemos suspender o terminar su acceso al sitio web en cualquier momento, sin previo aviso, por cualquier motivo, incluyendo, pero no limitado a, el incumplimiento de estos términos y condiciones.
                    </p>
                    <h2 class="modal-section-title">8. Ley Aplicable y Jurisdicción</h2>
                    <p>
                        Estos términos y condiciones se regirán e interpretarán de acuerdo con las leyes de Perú, y cualquier disputa que surja en relación con estos términos estará sujeta a la jurisdicción exclusiva de los tribunales de Piura, Perú.
                    </p>
                    <h2 class="modal-section-title">9. Contacto</h2>
                    <p>
                        Si tiene alguna pregunta sobre estos términos y condiciones, por favor contáctenos en patitas.sos@gmail.com.
                    </p>
                </div>
            `,
                showCancelButton: true,
                cancelButtonText: 'Rechazar',
                confirmButtonText: 'Aceptar',
                cancelButtonColor: 'gray',
                confirmButtonColor: '#dc143c',
                width: '40%',
            }).then((result) => {
                if (result.isConfirmed) {
                    checkBox.checked = true;
                }
            });
        });
    });
</script>
<script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Captura los datos del formulario
        const formData = new FormData(this);

        // Envía la solicitud AJAX
        fetch('../dataAccess/register_usuario.php', {
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