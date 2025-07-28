module.exports = {
  plugins: {
    'postcss-import': {
      filter: (path) => path.endsWith('.css'), // Ignore JS files
    },
    tailwindcss: {},
    autoprefixer: {},
  }
}