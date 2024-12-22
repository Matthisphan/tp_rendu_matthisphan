const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    // Entrée de l'application
    .addEntry('app', './assets/js/app.js')  // Assure-toi que ce fichier existe

    .enableSassLoader()
    .enablePostCssLoader()

    .enableSingleRuntimeChunk()

    .enableVersioning()
;

module.exports = Encore.getWebpackConfig();
