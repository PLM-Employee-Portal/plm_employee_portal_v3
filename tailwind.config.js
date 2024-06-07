/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    screens: {
      sm: '480px',
      md: '768px',
      lg: '976px',
      xl: '1440px',
    },
    colors: {
      gray: colors.coolGray,
      blue: colors.lightBlue,
      red: colors.rose,
      pink: colors.fuchsia,
      amber: {
        50: '#fffbeb',
        100: '#fef3c7',
        200: '#fde68a',
        300: '#fcd34d',
        400: '#fbbf24',
        500: '#f59e0b',
        600: '#d97706',
        700: '#b45309',
        800: '#92400e',
        900: '#78350f',
      },
      indigo: {  // Add a new "indigo" property
        50: '#e8f4f8',
        100: '#d3e2e6',
        200: '#b3d7df',
        300: '#92cbda',
        400: '#71afd4',
        500: '#4f86c7',
        600: '#386094',
        700: '#204164',
        800: '#12263a',
        900: '#0a192a',
      },
    },
    fontFamily: {
      sans: ['Graphik', 'sans-serif'],
      serif: ['Merriweather', 'serif'],
    },
    extend: {
      spacing: {
        '128': '32rem',
        '144': '36rem',
      },
      borderRadius: {
        '4xl': '2rem',
      },
      // fontSize: {
      //   '4xl': ['2.25rem', { lineHeight: '2.5rem' }], 
      // },
      
    }
    
  },
  plugins: [
      require('flowbite/plugin')
  ],
}

