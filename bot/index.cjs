const express = require("express");
const qrcode = require("qrcode-terminal");
const axios = require("axios");
const { LocalAuth, Client } = require("whatsapp-web.js");
const { getDb } = require("./database.cjs");
const meCommand = require("./commands/users/me.cjs");
const BOT_CONFIG = {
    operationalHours: {
        start: "08:00", // format 24 jam, kosongkan jika tidak ingin membatasi
        end: "22:00", // format 24 jam, kosongkan jika tidak ingin membatasi
    },
    // adminNumbers: ["6281234567890"], // contoh: daftar admin
    signature: process.env.WA_SIGNATURE || "\n\n-- Yukikoi Bot",
    // Tambahkan config lain di sini sesuai kebutuhan
};

function isWithinOperationalHours() {
    const { start, end } = BOT_CONFIG.operationalHours;
    if (!start || !end || (start === "0:00" && end === "0:00")) {
        return true; // Tidak ada pembatasan jam
    }
    const now = new Date();
    const [startH, startM] = start.split(":").map(Number);
    const [endH, endM] = end.split(":").map(Number);
    const startTime = new Date(now);
    startTime.setHours(startH, startM, 0, 0);
    const endTime = new Date(now);
    endTime.setHours(endH, endM, 59, 999);
    return now >= startTime && now <= endTime;
}

// [hh:mm:ss]
function timestamp() {
    return new Date().toTimeString().split(" ")[0];
}

const log = (tag, msg) => {
    console.log(`[${tag.toUpperCase()}][${timestamp()}] ${msg}`);
};

log("SYS", "Inisialisasi sistem Yukikoi Bot dimulai...");

const app = express();
const port = process.env.PORT || 3000;
app.use(express.json());

log("SRV", `Server akan berjalan pada port ${port}`);

const client = new Client({
    authStrategy: new LocalAuth({ clientId: "yukikoi-bot" }),
});

log("XWA", "Persiapan koneksi ke WhatsApp Web dimulai");

// Event WhatsApp Client
client.on("qr", (qr) => {
    log("XWA", "Kode QR diterima. Silakan pindai untuk autentikasi.");
    qrcode.generate(qr, { small: true });
});

client.on("authenticated", () => {
    log("XWA", "Autentikasi berhasil. Klien siap digunakan.");
});

client.on("ready", () => {
    log("XWA", "YukiKoi Bot dan WhatsApp Web siap. Menunggu pesan masuk...");
});

client.on("auth_failure", (msg) => {
    log("ERR", `Gagal autentikasi: ${msg}`);
});

client.on("disconnected", (reason) => {
    log("XWA", `Koneksi terputus. Alasan: ${reason}`);
});

client.on("message", async (chat) => {
    if (!isWithinOperationalHours()) {
        await chat.reply(
            "⚠️ Bot hanya aktif pada jam operasional: " +
                BOT_CONFIG.operationalHours.start +
                " - " +
                BOT_CONFIG.operationalHours.end
        );
        return;
    }
    const chatBody = chat.body.toLowerCase();
    const chatFrom = chat.from;

    log("MSG", `Pesan diterima dari ${chatFrom} dengan isi: "${chatBody}"`);

    if (chatBody === "me") {
        log("CMD", "Menjalankan perintah: me");
        await meCommand(chat, chatFrom);
        log("CMD", "Perintah 'me' selesai dijalankan");
    }

    if (chatBody === "ping") {
        await chat.reply("pong");
        log("CMD", "Membalas ping dengan pong");
    }
});

// Inisialisasi WhatsApp client
log("XWA", "Menginisialisasi koneksi ke WhatsApp Web...");
client.initialize();

// Endpoint API kirim pesan
app.post("/send-message", async (req, res) => {
    const { phone_number, message } = req.body;
    log(
        "API",
        `Permintaan pengiriman pesan diterima: ${JSON.stringify(req.body)}`
    );

    try {
        const phone = phone_number.replace(/\D/g, "");
        const chatId = `${phone}@c.us`;

        if (!client.info) {
            throw new Error("Klien WhatsApp belum siap");
        }

        const sent = await client.sendMessage(chatId, message);
        log("API", `Pesan berhasil dikirim ke ${chatId}. ID: ${sent.id.id}`);

        res.json({
            success: true,
            message: "Pesan berhasil dikirim",
            message_id: sent.id.id,
            timestamp: new Date().toISOString(),
        });
    } catch (error) {
        log("ERR", `Gagal mengirim pesan: ${error.message}`);
        res.status(500).json({
            success: false,
            message: "Terjadi kesalahan saat mengirim pesan",
            error: error.message,
        });
    }
});

// Menyalakan server
app.listen(port, () => {
    log("SRV", `Server aktif di http://localhost:${port}/send-message`);
    log("SYS", "Menunggu Auth dari Whatsapp...");
});
