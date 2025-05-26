const { Client } = require("whasapi");
const { Events } = require("whasapi/lib/Constant");
const axios = require("axios");
require("dotenv").config();

const API_BASE_URL = process.env.API_BASE_URL || "http://localhost:8000";

const bot = new Client({
  name: "yukikoi-bot",
  prefix: "/",
  printQRInTerminal: true,
  readIncommingMsg: true
});

bot.command("me", async (sock) => {
  // Extract phone number from WhatsApp JID
  const waNumber = sock.sender.id.replace(/@s\.whatsapp\.net$/, "");
  try {
    const res = await axios.get(`${API_BASE_URL}/api/user/by-wa/${waNumber}`);
    const user = res.data;
    if (user && user.name) {
      await sock.reply(`User Info:\nName: ${user.name}\nPhone: ${user.phone_number}`);
    } else {
      await sock.reply("User not found in database.");
    }
  } catch (err) {
    await sock.reply("Failed to fetch user info from API.");
  }
});

bot.ev.once(Events.ClientReady, (m) => {
  console.log(`Bot is ready at ${m.user.id}`);
});

bot.launch();