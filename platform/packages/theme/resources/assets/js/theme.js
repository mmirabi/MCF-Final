class ThemeManagement {
    init() {
        $(document).on('click', '.btn-trigger-active-theme', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)
            _self.addClass('button-loading')

            $httpClient
                .make()
                .post(route('theme.active', { theme: _self.data('theme') }))
                .then(({ data }) => {
                    Botble.showSuccess(data.message)
                    window.location.reload()
                })
                .finally(() => {
                    _self.removeClass('button-loading')
                })
        })

        $(document).on('click', '.btn-trigger-remove-theme', (event) => {
            event.preventDefault()
            $('#confirm-remove-theme-button').data('theme', $(event.currentTarget).data('theme'))
            $('#remove-theme-modal').modal('show')
        })

        $(document).on('click', '#confirm-remove-theme-button', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)
            _self.addClass('button-loading')

            $httpClient
                .make()
                .post(route('theme.remove', { theme: _self.data('theme') }))
                .then(({ data }) => {
                    Botble.showSuccess(data.message)
                    window.location.reload()
                })
                .finally(() => {
                    _self.removeClass('button-loading')
                    $('#remove-theme-modal').modal('hide')
                })
        })
    }
}

$(document).ready(() => {
    new ThemeManagement().init()
})
