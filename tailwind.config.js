/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'selector',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    borderRadius: {
      'none': '0',
      'sm': '0.125rem',
      DEFAULT: '0.25rem',
      DEFAULT: '4px',
      'md': '0.375rem',
      'lg': '0.5rem',
      'lg-1': '2rem',
      'full': '9999px',
      'large': '6.5rem',
    },
    extend: {
      boxShadow: {
        '3xl': '0px 0px 20px rgba(0, 0, 0, 0.2)',
      },
      fontFamily: {
        'inter': ['Inter', 'sans-serif'],
      },
    },
  },
  plugins: [],
}