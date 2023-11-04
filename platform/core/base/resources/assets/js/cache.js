class CacheManagement {
    init() {
        $(document).on('click', '.btn-clear-cache', (event) => {
            event.preventDefault()

            let _self = $(event.currentTarget)

            _self.addClass('button-loading')

            $httpClient
                .make()
                .post(_self.data('url'), { type: _self.data('type') })
                .then(({ data }) => Botble.showSuccess(data.message))
                .finally(() => _self.removeClass('button-loading'))
        })
    }
}

$(document).ready(() => {
    new CacheManagement().init()
})
