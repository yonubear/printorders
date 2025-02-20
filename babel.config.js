module.exports = {
  presets: [
    ['@babel/preset-react', { runtime: 'automatic' }]
  ],
  env: {
    production: {
      plugins: [
        ['transform-react-remove-prop-types', { removeImport: true }]
      ]
    }
  }
}
