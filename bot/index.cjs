const express = require("express");
const qrcode = require("qrcode-terminal");
const axios = require("axios");
const { LocalAuth, Client } = require("whatsapp-web.js");
const { getDb } = require("./database.cjs");
const meCommand = require("./commands/users/me.cjs");

console.log("[BOOT] Yukikoi Bot mulai nyala... 🔌");
console.log("[BOOT] Tunggu sebentar ya, lagi siap-siap...");

const app = express();
const port = process.env.PORT || 3000;
console.log(`[SERVER] Aku jalan di port ${port} nih 🏃‍♂️`);

// Middleware setup
app.use(express.json());
console.log("[SERVER] Tambahan fitur JSON udah aktif ✔️");

const client = new Client({
    authStrategy: new LocalAuth({ clientId: "yukikoi-bot" }),
});
console.log("[WA] Aku siap connect ke WhatsApp...");

// Event handlers with Gojek-style logging
client.on("qr", (qr) => {
    console.log("[WA] QR code nih! 📱");
    console.log("[WA] Scan ini ya buat login...");
    qrcode.generate(qr, { small: true });
});

client.on("authenticated", () => {
    console.log("[WA] Yeay! Login berhasil 🎉");
    console.log("[WA] Sekarang aku bisa kirim pesan");
});

client.on("ready", () => {
    console.log("[WA] Aku udah siap banget nih!");
    console.log("[WA] Tinggal tunggu pesan masuk...");
});

client.on("auth_failure", (msg) => {
    console.log("[WA] Wah, gagal login nih");
    console.log(`[WA] Errornya: ${msg}`);
});

client.on("disconnected", (reason) => {
    console.log("[WA] Aduh, aku terputus");
    console.log(`[WA] Penyebabnya: ${reason}`);
});

client.on("message", async (chat) => {
    console.log(`[CHAT] Dapat pesan dari ${chat.from}`);
    console.log(`[CHAT] Isinya: "${chat.body}"`);

    const chatBody = chat.body.toLowerCase();
    const chatFrom = chat.from;

    if (chatBody === "me") {
        console.log("[CMD] Ada yang panggil 'me' nih...");
        await meCommand(chat, chatFrom);
        console.log("[CMD] Perintah 'me' selesai diproses");
    }

    if (chatBody === "ping") {
        console.log("[CHAT] Ada yang ping, aku balas pong deh 🏓");
        await chat.reply("pong");
        console.log("[CHAT] Pesan udah dibalas 👍");
    }
});

// Initialize the client
console.log("[WA] Mau connect ke WhatsApp dulu ya...");
client.initialize();

// API Endpoint with casual logging
app.post("/send-message", async (req, res) => {
    console.log("[API] Platform kirim pesan nih! 📨");
    console.log(`[API] Detailnya:`, req.body);

    try {
        const phone = req.body.phone_number.replace(/\D/g, "");
        const chatId = `${phone}@c.us`;

        console.log(`[API] Kirim ke: ${chatId}`);

        if (!client.info) {
            console.log("[API] Wah, aku belum siap ");
            throw new Error("WhatsApp client belum ready");
        }

        console.log("[API] Oke, kirim sekarang ");
        const sent = await client.sendMessage(chatId, req.body.message);
        console.log(`[API] Pesan terkirim 🚀 ID: ${sent.id.id}`);

        res.json({
            success: true,
            message: "Pesan udah jalan!",
            message_id: sent.id.id,
            timestamp: new Date().toISOString(),
        });
    } catch (error) {
        console.log("[API] Yah, error nih 😢");
        console.log(`[API] Errornya: ${error.message}`);
        res.status(500).json({
            success: false,
            message: "Aduh, gagal kirim pesan",
            error: error.message,
        });
    }
});

// Server startup
app.listen(port, () => {
    console.log(`[SERVER] Yukikoi Bot udah nyala! 🎊`);
    console.log(`[SERVER] Endpoint aktif: http://localhost:${port}/send-message`);
    console.log("[SERVER] Aku siap melayani 😊");
});

console.log("[BOOT] Semua setup selesai! Aku tunggu pekerjaan pertama...");