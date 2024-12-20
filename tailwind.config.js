module.exports = {
  content: [
    './templates/**/*.html.twig', // Pour que Tailwind purgera les classes non utilisées dans les templates Twig
    './assets/**/*.js'           // Si tu utilises JavaScript pour ajouter des classes dynamiquement
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};