import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: "#FF7A00",
                    50: "#FFF4EB",
                    100: "#FFE4CC",
                    200: "#FFD0A3",
                    300: "#FFB56B",
                    400: "#FF9733",
                    500: "#FF7A00",
                    600: "#D96500",
                    700: "#B35200",
                    800: "#8C4000",
                    900: "#663000",
                },

                secondary: {
                    DEFAULT: "#1A1A1A",
                    50: "#F5F5F5",
                    100: "#E5E5E5",
                    200: "#CCCCCC",
                    300: "#A3A3A3",
                    400: "#737373",
                    500: "#525252",
                    600: "#404040",
                    700: "#262626",
                    800: "#1A1A1A",
                    900: "#0A0A0A",
                },

                tertiary: "#F8F5F2",

                neutral: {
                    DEFAULT: "#71717A",
                    50: "#FAFAFA",
                    100: "#F4F4F5",
                    200: "#E4E4E7",
                    300: "#D4D4D8",
                    400: "#A1A1AA",
                    500: "#71717A",
                    600: "#52525B",
                    700: "#3F3F46",
                    800: "#27272A",
                    900: "#18181B",
                },
            },

            fontFamily: {
                sans: ["Plus Jakarta Sans", ...defaultTheme.fontFamily.sans],
                heading: ["Playfair Display", "serif"],
            },

            borderRadius: {
                xl: "1rem",
                "2xl": "1.5rem",
            },

            boxShadow: {
                soft: "0 4px 20px rgba(0, 0, 0, 0.08)",
            },
            footer: {
                bg: "#F4F2EF",
                muted: "#5F5E5A",
                subtle: "#888780",
                link: "#444441",
                border: "#D3D1C7",
                pill: "#ECEAE5",
            },
        },
    },

    plugins: [forms],
};