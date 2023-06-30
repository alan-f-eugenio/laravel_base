import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import * as glob from "glob";
import path from "node:path";
import { fileURLToPath } from "node:url";

// const inputJS = Object.fromEntries(
//     glob
//         .sync("resources/js/*.js")
//         .map((file) => [
//             path.relative("resources/js", file),
//             fileURLToPath(new URL(file, import.meta.url)),
//         ])
// );
// const inputCSS = Object.fromEntries(
//     glob
//         .sync("resources/css/*.css")
//         .map((file) => [
//             path.relative("resources/css", file),
//             fileURLToPath(new URL(file, import.meta.url)),
//         ])
// );
const input = {
    "common.css": "resources/css/common.css",
    "common.js": "resources/js/common.js",
    "admin.css": "resources/css/admin.css",
    "admin.js": "resources/js/admin.js",
    "public.css": "resources/css/public.css",
    "public.js": "resources/js/public.js",
    // ...inputJS,
    // ...inputCSS,
};

export default defineConfig({
    plugins: [
        laravel({
            input,
            refresh: true,
        }),
    ],
});
