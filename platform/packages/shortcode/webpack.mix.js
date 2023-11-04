let mix = require('laravel-mix')

const path = require('path')
let directory = path.basename(path.resolve(__dirname))

const source = 'platform/packages/' + directory
const dist = 'public/vendor/core/packages/' + directory

mix
    .js(source + '/resources/assets/js/shortcode-fields.js', dist + '/js')

if (mix.inProduction()) {
    mix
        .copy(dist + '/js/shortcode-fields.js', source + '/public/js')
}
