module.exports = {
  presets: [
    ['@babel/preset-env', {
      useBuiltIns: 'usage',
      corejs: 3,
      targets: {
        browsers: [
          'last 2 versions',
          '> 1%',
          'not ie 11'
        ],
        node: '18'
      }
    }]
  ],
  plugins: [
    '@babel/plugin-transform-runtime'
  ]
};