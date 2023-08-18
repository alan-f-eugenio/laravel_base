import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import flowbite from "flowbite/plugin";
const { addDynamicIconSelectors } = require("@iconify/tailwind");

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./Modules/**/Resources/views/**/*.blade.php",
    ],

    theme: {
        container: {
            center: true,
        },
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, flowbite, addDynamicIconSelectors()],
};
