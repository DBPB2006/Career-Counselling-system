
import { GoogleGenAI } from "@google/genai";

const businessInfo = `
You are the AI assistant for CopeUp, a career guidance platform.

About CopeUp:
CopeUp helps students and professionals discover their ideal career paths through personalized recommendations and educational guidance.

Key Features:
1. Career Exploration
- Subject-based career recommendations
- Interest-based career matching
- Skills assessment and development
- Industry trends and opportunities

2. Educational Guidance
- Course recommendations
- University selection assistance
- Study resources
- Exam preparation tips

3. Professional Development
- Resume building
- Interview preparation
- Skill development
- Career growth strategies

Tone Instructions:
- Be supportive and encouraging
- Use simple language
- Give clear and actionable advice
- Stay professional but friendly
- Help users make informed career decisions
`;

document.addEventListener("DOMContentLoaded", function () {

    const chatButton = document.querySelector(".chat-button");
    const chatWindow = document.querySelector(".chat-window");
    const closeButton = document.querySelector(".chat-window .close");
    const input = document.querySelector(".input-area input");
    const sendButton = document.querySelector(".input-area button");
    const chat = document.querySelector(".chat");

    // Gemini AI Client
    const ai = new GoogleGenAI({
        apiKey: "AIzaSyA7kUZsXGb9x2zvm899XjxJBEkN3s_lJnw"
    });

    // Toggle chat window
    chatButton.addEventListener("click", function (e) {
        e.preventDefault();
        document.body.classList.toggle("chat-open");

        if (document.body.classList.contains("chat-open")) {
            input.focus();
        }
    });

    // Close chat
    closeButton.addEventListener("click", function () {
        document.body.classList.remove("chat-open");
    });

    // Add message to chat
    function addMessage(message, isUser = false, isError = false) {

        const messageDiv = document.createElement("div");

        messageDiv.className = isUser
            ? "user"
            : isError
                ? "error"
                : "model";

        const formattedMessage = message
            .split("\n")
            .map(line => line.trim())
            .join("<br>");

        const p = document.createElement("p");
        p.innerHTML = formattedMessage;

        messageDiv.appendChild(p);
        chat.appendChild(messageDiv);

        chat.scrollTo({
            top: chat.scrollHeight,
            behavior: "smooth"
        });
    }

    // Typing indicator
    function showTypingIndicator() {
        const loader = document.createElement("div");
        loader.className = "loader";
        chat.appendChild(loader);
        return loader;
    }

    function removeTypingIndicator(loader) {
        if (loader) loader.remove();
    }

    // Handle user message
    async function handleUserMessage(message) {

        addMessage(message, true);

        const loader = showTypingIndicator();

        try {

            const prompt = `${businessInfo}

User Question:
${message}

Assistant Response:`;


            const response = await ai.models.generateContent({
                model: "gemini-2.0-flash",
                contents: prompt
            });

            const text = response.text;

            removeTypingIndicator(loader);

            const cleanedText = text.replace(/\*/g, "");

            addMessage(cleanedText);

        } catch (error) {

            console.error("Gemini Error:", error);

            removeTypingIndicator(loader);

            addMessage(
                "Sorry, something went wrong while generating a response. Please try again.",
                false,
                true
            );
        }
    }

    // Send message button
    sendButton.addEventListener("click", function () {

        const message = input.value.trim();

        if (!message) return;

        handleUserMessage(message);

        input.value = "";
    });

    // Send message with Enter key
    input.addEventListener("keypress", function (e) {

        if (e.key === "Enter") {

            const message = input.value.trim();

            if (!message) return;

            handleUserMessage(message);

            input.value = "";
        }
    });

    // Initial greeting
    addMessage("Hi! I'm your CopeUp career assistant. How can I help you today?");
});
