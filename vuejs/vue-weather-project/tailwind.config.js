/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx,vue}"],
  theme: {
    extend: {
      colors: {
        "weather-primary": "#FFD700",
        "weather-secondary": "#FFA500",
      },
    },
    fontFamily: {
      blackOps: ["Black Ops One", "sans-serif"],
    },
    container: {
      center: true,
      padding: "1rem",
    },
  },
  plugins: [],
};
