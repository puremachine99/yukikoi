const express = require("express");
const qrcode = require("qrcode-terminal");
const axios = require("axios");
const { LocalAuth, Client } = require("whatsapp-web.js");
const { getDb } = require("./database.cjs");
const meCommand = require("./commands/users/me.cjs");

const app = express();
const port = process.env.PORT || 3000;

const client = new Client({
    authStrategy: new LocalAuth({ clientId: "yukikoi-bot" }),
});

// cetak qr di terminal, login, report stat
client.on("qr", (qr) => qrcode.generate(qr, { small: true }));
client.on("authenticated", () => console.log("qr sudah discan"));
client.on("ready", () => console.log("Client is ready!"));

client.on("message", async (chat) => {
    const chatBody = chat.body.toLowerCase();
    const chatFrom = chat.from;
    if (chatBody === "me") {
        await meCommand(chat, chatFrom);
    }
    const chatId = chat.id._serialized;
    const chatType = chat.type;
    let botChat = "";
    if (chatBody === "ping") {
        botChat = "pong";
        chat.reply(botChat);
        console.log(chatFrom + ":" + chatBody);
        console.log("bot : " + botChat);
    } 
});

// Initialize the client
client.initialize();
// start bot e
app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});
