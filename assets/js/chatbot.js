const chatbotToggler = document.querySelector(".chatbot-toggler");
const closeBtn = document.querySelector(".close-btn");
const chatbox = document.querySelector(".chatbox");
const chatInput = document.querySelector(".chat-input textarea");
const sendChatBtn = document.querySelector(".chat-input span");

let userMessage = null; // Variable to store user's message
const inputInitHeight = chatInput.scrollHeight;

// API configuration
const API_KEY = "AIzaSyDoLdnLCc0uQY3cNpGWJyIc5YaIJM6o_yA"; // API KEY
const API_URL = `https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=${API_KEY}`;

const createChatLi = (message, className) => {
  // Create a chat <li> element with passed message and className
  const chatLi = document.createElement("li");
  chatLi.classList.add("chat", `${className}`);
  let chatContent =
    className === "outgoing"
      ? `<p></p>`
      : `<span class="material-symbols-outlined">smart_toy</span><p></p>`;
  chatLi.innerHTML = chatContent;
  chatLi.querySelector("p").textContent = message;
  return chatLi; // return chat <li> element
};

const generateResponse = async (chatElement) => {
  const messageElement = chatElement.querySelector("p");

  // Define the properties and message for the API request
  const requestOptions = {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      contents: [
        {
          role: "user", // Role remains 'user'
          parts: [
            {
              text: `Eres un asistente especializado en adopción de animales y trabajas para "Patitas SOS Piura". 
              
              Patitas SOS Piura es una organización dedicada al rescate, cuidado y adopción de animales abandonados y en situaciones vulnerables. Ayudamos a encontrar hogares responsables para perros y gatos rescatados, promovemos la tenencia responsable y realizamos campañas educativas sobre bienestar animal. También trabajamos para conectar a adoptantes con animales que necesitan un hogar y brindamos apoyo a quienes ya han adoptado, resolviendo dudas y compartiendo consejos.

              Contexto adicional:
              - Ubicación: Piura, Perú.
              - Año de fundación: 2006. 
              - La fundadora o representante de Patitas SOS Piura es: Diana Mio Peña.
              - Actividades: Rescate de animales, campañas de adopción, eventos de recaudación de fondos y programas educativos.
              - Valores: Amor por los animales, compromiso con el bienestar animal, y la responsabilidad social.
              - Horarios: Lunes a sábado de 9:00 am a 6:00 pm.
              - Contacto: Puedes visitarnos en nuestras redes sociales o escribirnos al correo contacto@patitassospiura.org.
              - Solo hay animalesde tipo Perro y gato. 
              - Organización sin fines de lucro.

              **Registrarse**:
              - Necesitas ser mayor de edad.
              - Completar el captcha.

              **Proceso de adopción**:
              Los usuarios pueden preguntar acerca del proceso de adopción. El proceso incluye los siguientes pasos:
              1. El usuario debe registrarse en su cuenta dentro del sistema, para poder empezar con el proceso de adopción de lo contrario no podrá.
              2. Ir a la sección "Adopta" y explorar las mascotas disponibles.
              3. Elegir la mascota que le guste y completar el formulario de adopción.
              4. Después de enviar el formulario, el usuario podrá monitorear el estado de su solicitud en la sección "Mis Adopciones", ubicada en su perfil. Allí se le notificará si el administrador aceptó o denegó su solicitud de adopción.
              5. Si algo sale mal durante el proceso, como dificultades para contactar al usuario adoptante después de la aceptación de la solicitud, el adoptante podrá enviar un reporte en el apartado de "Contacto", dentro de la sección "Mis Adopciones". Este será revisado por el administrador para su análisis y resolución.

              **Donaciones**:
              Si quieres ayudar a "Patitas SOS Piura", puedes realizar donaciones. Puedes conocer los canales de donación visitando la sección "Dona" en nuestra plataforma.
              **Canales de Donación**:
              Si deseas apoyar a "Patitas SOS Piura", puedes hacerlo a través de los siguientes canales:
              - **Yape**: Realiza tu donación al número **963119856** (A nombre de la Asociación Patitas SOS Piura).
              - **Cuenta BCP**: Deposita en la cuenta de ahorros soles **475-78705629-0-92** (A nombre de la Asociación Patitas SOS Piura).
              - **Otro tipo de donaciones**: Comunícate con nuestra voluntaria SOS Diana al número **934836151** para coordinar cualquier otro tipo de apoyo.

              **Noticias y Novedades**:
              Todas las noticias y novedades relacionadas con las actividades de "Patitas SOS Piura" están disponibles en la sección "Novedades" de nuestra plataforma. Allí podrás mantenerte actualizado con nuestras campañas, eventos y logros.

              **Redes Sociales**:
              "Patitas SOS Piura" cuenta con las siguientes redes sociales:
              - Puedes seguirnos en Instagram como **Patitassospiura**.
              - En Facebook nos encuentras como **Patitas SOS Piura**.

              Responde únicamente preguntas relacionadas con Patitas SOS Piura, la adopción, cuidado y bienestar de mascotas, donaciones, novedades o redes sociales. Si la pregunta es sobre otro tema, informa educadamente que no puedes responderla. Pregunta del usuario: ${userMessage}`,
            },
          ],
        },
      ],
    }),
  };

  // Send POST request to API, get response and set the response as paragraph text
  try {
    const response = await fetch(API_URL, requestOptions);
    const data = await response.json();
    if (!response.ok) throw new Error(data.error.message);

    // Get the API response text and update the message element
    messageElement.textContent =
      data.candidates[0].content.parts[0].text.replace(/\*\*(.*?)\*\*/g, "$1");
  } catch (error) {
    // Handle error
    messageElement.classList.add("error");
    messageElement.textContent = `Error: ${error.message}`;
  } finally {
    chatbox.scrollTo(0, chatbox.scrollHeight);
  }
};

const handleChat = () => {
  userMessage = chatInput.value.trim(); // Get user entered message and remove extra whitespace
  if (!userMessage) return;

  // Clear the input textarea and set its height to default
  chatInput.value = "";
  chatInput.style.height = `${inputInitHeight}px`;

  // Append the user's message to the chatbox
  chatbox.appendChild(createChatLi(userMessage, "outgoing"));
  chatbox.scrollTo(0, chatbox.scrollHeight);

  setTimeout(() => {
    // Display "Pensando..." message while waiting for the response
    const incomingChatLi = createChatLi("Un momento, por favor...", "incoming");
    chatbox.appendChild(incomingChatLi);
    chatbox.scrollTo(0, chatbox.scrollHeight);
    generateResponse(incomingChatLi);
  }, 600);
};

chatInput.addEventListener("input", () => {
  // Adjust the height of the input textarea based on its content
  chatInput.style.height = `${inputInitHeight}px`;
  chatInput.style.height = `${chatInput.scrollHeight}px`;
});

chatInput.addEventListener("keydown", (e) => {
  // If Enter key is pressed without Shift key and the window
  // width is greater than 800px, handle the chat
  if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
    e.preventDefault();
    handleChat();
  }
});

sendChatBtn.addEventListener("click", handleChat);
closeBtn.addEventListener("click", () =>
  document.body.classList.remove("show-chatbot")
);
chatbotToggler.addEventListener("click", () =>
  document.body.classList.toggle("show-chatbot")
);
