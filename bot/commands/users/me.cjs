const { getDb } = require("../../database.cjs");

function normalizePhone(waNumber) {
    let phone = waNumber.replace(/@c\.us$/, "");
    if (phone.startsWith("62")) phone = "0" + phone.slice(2);
    return phone;
}

module.exports = async function meCommand(chat, chatFrom) {
    const phone = normalizePhone(chatFrom);
    try {
        const db = await getDb();
        const [rows] = await db.execute("SELECT * FROM users WHERE phone_number = ?", [phone]);
        if (rows.length > 0) {
            const user = rows[0];
            let detail = `Profil Anda:\n`;
            detail += `Nama: ${user.name || "-"}\n`;
            detail += `Email: ${user.email || "-"}\n`;
            detail += `No HP: ${user.phone_number || "-"}\n`;
            detail += `Username: ${user.username || "-"}\n`;
            detail += `Role: ${user.role || "-"}\n`;
            detail += `Alamat: ${user.address || "-"}\n`;
            detail += `Bio: ${user.bio || "-"}\n`;
            detail += `Saldo: Rp ${user.balance ? user.balance.toLocaleString("id-ID") : "-"}`;
            await chat.reply(detail);
        } else {
            await chat.reply("Data user tidak ditemukan.");
        }
    } catch (err) {
        await chat.reply("Terjadi error saat mengambil data user.");
    }
};