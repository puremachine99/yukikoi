import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    server: {
        host: "0.0.0.0", // Agar mendengarkan pada semua alamat IP
        port: 3000, // Port yang digunakan (ubah jika perlu)
        hmr: {
            host: "192.168.41.141", // Ganti dengan IP address dari komputer yang menjalankan server
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
});
