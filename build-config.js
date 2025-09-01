const domain = 'localhost:10084l'
const dest = './dist'

const host = `https://${domain}`

const entries = [
  './assets/admin.js',
  './assets/admin.scss',
  './assets/main.js',
  './assets/main.scss',
  './assets/print.scss',
  './assets/tinyMce.scss'
]

const watchFiles = [
  '*.php',
  'templates/**/*',
  'lib/**/*',
  'inc/**/*',
  './Components/**/*.{php,twig}'
]

module.exports = {
  dest,
  host,
  domain,
  entries,
  watchFiles
}
