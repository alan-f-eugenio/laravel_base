import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import * as glob from "glob";
import path from "node:path";
import { fileURLToPath } from "node:url";

const inputJS = Object.fromEntries(
    glob
        .sync("resources/js/*.js")
        .map((file) => [
            path.relative("resources/js", file),
            fileURLToPath(new URL(file, import.meta.url)),
        ])
);
const inputCSS = Object.fromEntries(
    glob
        .sync("resources/css/*.css")
        .map((file) => [
            path.relative("resources/css", file),
            fileURLToPath(new URL(file, import.meta.url)),
        ])
);
const input = {
    ...inputJS,
    ...inputCSS,
};

export default defineConfig({
    server: {
        // respond to all network requests (same as '0.0.0.0')
        host: true,
        // we need a strict port to match on PHP side
        strictPort: true,
        port: 5173,
        hmr: {
            // TODO: Is this the best way to achieve that? 🤔
            // Force the Vite client to connect via SSL
            // This will also force a "https://" URL in the hot file
            protocol: "wss",
            // The host where the Vite dev server can be accessed
            // This will also force this host to be written to the hot file
            host: `${process.env.DDEV_HOSTNAME}`,
        },
    },
    plugins: [
        laravel({
            input,
            refresh: true,
        }),
    ],
});
