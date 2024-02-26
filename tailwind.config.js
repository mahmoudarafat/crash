/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./src/**/*.{html,js}",
        "./node_modules/tw-elements/dist/js/**/*.js",
    ],
    theme: {
        extend: {},
    },
    plugins: [require("tw-elements/dist/plugin")],
    darkMode: "class",
}
