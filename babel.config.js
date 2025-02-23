module.exports = {
  presets: [
    ['@babel/preset-env', {
      useBuiltIns: 'usage',
      corejs: 3,
      targets: {
        node: '18',
        browsers: [
          'defaults',
          'not IE 11'
        ]
      }
    }]
  ]
}