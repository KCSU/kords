const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    purge: [
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue"
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: {
                sans: ["Montserrat", ...defaultTheme.fontFamily.sans]
            },
            gridTemplateColumns: {
                "fill-56": "repeat(auto-fill, minmax(14rem, 1fr))"
            }
        }
    },
    variants: {
        extend: {}
    },
    plugins: []
};
