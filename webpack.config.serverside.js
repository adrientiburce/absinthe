var Encore = require('@symfony/webpack-encore');

Encore
  // directory where all compiled assets will be stored
  .setOutputPath('var/webpack/')
  // what's the public path to this directory (relative to your project's document root dir)
  .setPublicPath('/')
  // empty the outputPath dir before each build
  .cleanupOutputBeforeBuild()
   
  // will output as app/Resources/webpack/server-bundle.js
  .addEntry('server-bundle','./assets/js/startup/registration.js')
  // Add react preset
  .enableReactPreset()

.configureBabel(function (babelConfig) {
    // add additional presets
    babelConfig.presets.push('es2015');
    babelConfig.presets.push('stage-0');

// no plugins are added by default, but you can add some
    // babelConfig.plugins.push('styled-jsx/babel');
  })

.enableSourceMaps(!Encore.isProduction())

;

// export the final configuration
module.exports = Encore.getWebpackConfig()