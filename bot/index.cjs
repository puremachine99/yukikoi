const express = require("express");
const qrcode = require("qrcode-terminal");
const axios = require("axios");
const { LocalAuth, Client } = require("whatsapp-web.js");
const { getDb } = require("./database.cjs");
const meCommand = require("./commands/users/me.cjs");

console.log("[INIT] Starting WhatsApp Bot initialization...");

const app = express();
const port = process.env.PORT || 3000;
console.log(`[EXPRESS] Express app created, will run on port ${port}`);

// Middleware setup
app.use(express.json());
console.log("[EXPRESS] JSON middleware enabled");

const client = new Client({
    authStrategy: new LocalAuth({ clientId: "yukikoi-bot" }),
});
console.log("[WHATSAPP] Client initialized with LocalAuth");

// Event handlers with detailed logging
client.on("qr", (qr) => {
    console.log("[WHATSAPP] QR code received, generating terminal display...");
    qrcode.generate(qr, { small: true });
});

client.on("authenticated", () => {
    console.log("[WHATSAPP] Authentication successful! QR code scanned.");
});

client.on("ready", () => {
    console.log("[WHATSAPP] Client is now ready to send/receive messages");
});

client.on("auth_failure", (msg) => {
    console.error(`[WHATSAPP] Authentication failed: ${msg}`);
});

client.on("disconnected", (reason) => {
    console.warn(`[WHATSAPP] Client disconnected: ${reason}`);
});

client.on("message", async (chat) => {
    console.log(`[MESSAGE] New message received from ${chat.from}`);
    console.log(`[MESSAGE] Content: "${chat.body}"`);

    const chatBody = chat.body.toLowerCase();
    const chatFrom = chat.from;

    if (chatBody === "me") {
        console.log("[COMMAND] Handling 'me' command...");
        await meCommand(chat, chatFrom);
        console.log("[COMMAND] 'me' command executed");
    }

    const chatId = chat.id._serialized;
    const chatType = chat.type;
    let botChat = "";

    if (chatBody === "ping") {
        botChat = "pong";
        console.log(`[RESPONSE] Replying to ping with "${botChat}"`);
        await chat.reply(botChat);
        console.log(`[CHAT LOG] ${chatFrom}: ${chatBody}`);
        console.log(`[CHAT LOG] bot: ${botChat}`);
    }
});

// Initialize the client
console.log("[WHATSAPP] Initializing WhatsApp client...");
client.initialize();

// API Endpoint with logging
app.post("/send-message", async (req, res) => {
    console.log("[BOT] Received request:", req.body); // Log masuk

    try {
        const phone = req.body.phone_number.replace(/\D/g, ""); // Bersihkan nomor
        const chatId = `${phone}@c.us`;

        console.log("[BOT] Trying to send to:", chatId);

        // Pastikan client ready
        if (!client.info) {
            throw new Error("WhatsApp client not ready");
        }

        // Kirim pesan
        const sent = await client.sendMessage(chatId, req.body.message);
        console.log("[BOT] Message sent:", sent.id.id);

        res.json({
            success: true,
            message_id: sent.id.id,
            timestamp: new Date().toISOString(),
        });
    } catch (error) {
        console.error("[BOT] Error:", error);
        res.status(500).json({
            success: false,
            error: error.message,
            stack: error.stack,
        });
    }
});

// Server startup
app.listen(port, () => {
    console.log(`[SERVER] WhatsApp bot server running on port ${port}`);
    console.log(
        `[SERVER] Endpoint available: http://localhost:${port}/send-otp`
    );
});

console.log("[INIT] Bot setup complete, waiting for events...");
