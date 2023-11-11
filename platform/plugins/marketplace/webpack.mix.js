let mix = require('laravel-mix')

const path = require('path')
let directory = path.basename(path.resolve(__dirname))

const source = 'platform/plugins/' + directory
const dist = 'public/vendor/core/plugins/' + directory

mix
    .js(source + '/resources/assets/js/marketplace-product.js', dist + '/js')
    .js(source + '/resources/assets/js/marketplace-setting.js', dist + '/js')
    .js(source + '/resources/assets/js/store-revenue.js', dist + '/js')

    .js(source + '/resources/assets/js/vendor-dashboard/marketplace.js', dist + '/js')
    .js(source + '/resources/assets/js/vendor-dashboard/marketplace-vendor.js', dist + '/js')
    .js(source + '/resources/assets/js/vendor-dashboard/discount.js', dist + '/js')
    .vue()

    .sass(source + '/resources/assets/sass/vendor-dashboard/marketplace.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/vendor-dashboard/marketplace-rtl.scss', dist + '/css')

if (mix.inProduction()) {
    mix.copy(dist + '/js/marketplace.js', source + '/public/js')
        .copy(dist + '/js/marketplace-product.js', source + '/public/js')
        .copy(dist + '/js/marketplace-vendor.js', source + '/public/js')
        .copy(dist + '/js/marketplace-setting.js', source + '/public/js')
        .copy(dist + '/js/discount.js', source + '/public/js')
        .copy(dist + '/js/store-revenue.js', source + '/public/js')
        .copy(dist + '/css/marketplace.css', source + '/public/css')
        .copy(dist + '/css/marketplace-rtl.css', source + '/public/css')
}
