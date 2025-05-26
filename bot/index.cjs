require("dotenv").config();
const { makeWASocket, useMultiFileAuthState } = require("@whiskeysockets/baileys");
const pino = require("pino");
const qrcode = require("qrcode-terminal");

async function startBot() {
    const { state, saveCreds } = await useMultiFileAuthState("auth_info");
    const sock = makeWASocket({
        auth: state,
        logger: pino({ level: "silent" }),
        printQRInTerminal: false,
    });

    sock.ev.on("connection.update", ({ connection, qr }) => {
        if (qr) {
            qrcode.generate(qr, { small: true });
            console.log("Scan QR code di atas dengan WhatsApp Anda");
        }
        if (connection === "open") {
            console.log("Bot siap!");
        }
    });

    sock.ev.on("creds.update", saveCreds);

    sock.ev.on("messages.upsert", async ({ messages }) => {
        const msg = messages[0];
        if (!msg.message || msg.key.fromMe) return;
        const text = msg.message.conversation || msg.message.extendedTextMessage?.text || "";
        if (text.trim().toLowerCase() === "ping") {
            await sock.sendMessage(msg.key.remoteJid, { text: "pong" });
        }
    });
}

startBot().catch((err) => console.log("Error starting bot:", err));