const { getDb } = require("../../database.cjs");

function normalizePhone(waNumber) {
    let phone = waNumber.replace(/@c\.us$/, "");
    if (phone.startsWith("62")) phone = "0" + phone.slice(2);
    return phone;
}

function generateFunnyVoucherCode() {
    const adjectives = ["GAS", "SULTAN", "NONGKI", "SARAPAN", "MIAYAM", "NGOPI"];
    const suffix = Math.floor(Math.random() * 9000 + 1000); // random 4-digit
    const pick = adjectives[Math.floor(Math.random() * adjectives.length)];
    return `${pick}${suffix}`;
}

function isPromoTime() {
    const now = new Date();
    const hour = now.getHours();
    return hour >= 6 && hour < 9;
}

module.exports = async function infoCommand(chat, chatFrom) {
    const phone = normalizePhone(chatFrom);

    try {
        const db = await getDb();
        const [rows] = await db.execute("SELECT * FROM users WHERE phone_number = ?", [phone]);

        if (rows.length === 0) {
            await chat.reply("Data user tidak ditemukan.");
            return;
        }

        const user = rows[0];
        let detail = `👤 *Profil Anda:*\n`;
        detail += `• Nama: ${user.name || "-"}\n`;
        detail += `• Email: ${user.email || "-"}\n`;
        detail += `• No HP: ${user.phone_number || "-"}\n`;
        detail += `• Username: ${user.username || "-"}\n`;
        detail += `• Role: ${user.role || "-"}\n`;
        detail += `• Alamat: ${user.address || "-"}\n`;
        detail += `• Bio: ${user.bio || "-"}\n`;
        detail += `• Saldo: Rp ${user.balance ? user.balance.toLocaleString("id-ID") : "-"}`;

        if (isPromoTime()) {
            const voucher = generateFunnyVoucherCode();
            detail += `\n\n🎁 *Promo Pagi Spesial!*\nGunakan kode: *${voucher}*\nUntuk diskon *50%* dari jam 06:00 - 09:00 WIB.\nBuruan sebelum habis! 🌄`;
        }

        await chat.reply(detail);

    } catch (err) {
        console.error(err);
        await chat.reply("❌ Terjadi error saat mengambil data user.");
    }
};
