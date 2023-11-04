$(document).ready(function () {
    let languageTable = $('.table-language')

    languageTable.on('click', '.delete-locale-button', (event) => {
        event.preventDefault()

        $('.delete-crud-entry').data('url', $(event.currentTarget).data('url'))
        $('.modal-confirm-delete').modal('show')
    })

    $(document).on('click', '.delete-crud-entry', (event) => {
        event.preventDefault()
        $('.modal-confirm-delete').modal('hide')

        let deleteURL = $(event.currentTarget).data('url')
        $(this).prop('disabled', true).addClass('button-loading')

        $httpClient
            .make()
            .delete(deleteURL)
            .then(({ data }) => {
                if (data.data) {
                    languageTable.find('i[data-locale=' + data.data + ']').unwrap()
                    $('.tooltip').remove()
                }

                languageTable.find(`a[data-url="${deleteURL}"]`).closest('tr').remove()

                Botble.showSuccess(data.message)
            })
            .finally(() => {
                $(this).prop('disabled', false).removeClass('button-loading')
            })
    })

    $(document).on('click', '.add-locale-form button[type=submit]', function (event) {
        event.preventDefault()
        event.stopPropagation()
        $(this).prop('disabled', true).addClass('button-loading')

        let formData = new FormData($(this).closest('form')[0])

        $httpClient
            .make()
            .postForm($(this).closest('form').prop('action'), formData)
            .then(({ data }) => {
                Botble.showSuccess(data.message)
                languageTable.load(window.location.href + ' .table-language > *')
            })
            .finally(() => {
                $(this).prop('disabled', false).removeClass('button-loading')
            })
    })

    let $availableRemoteLocales = $('#available-remote-locales')

    if ($availableRemoteLocales.length) {
        let getRemoteLocales = () => {
            $httpClient
                .make()
                .get($availableRemoteLocales.data('url'))
                .then(({ data }) => {
                    languageTable.load(window.location.href + ' .table-language > *')
                    $availableRemoteLocales.html(data.data)
                })
        }

        getRemoteLocales()

        $(document).on('click', '.btn-import-remote-locale', function (event) {
            event.preventDefault()

            $('.button-confirm-import-locale').data('url', $(this).data('url'))
            $('.modal-confirm-import-locale').modal('show')
        })

        $('.button-confirm-import-locale').on('click', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)

            _self.addClass('button-loading')

            let url = _self.data('url')

            $httpClient
                .make()
                .post(url)
                .then(({ data }) => {
                    Botble.showSuccess(data.message)
                    getRemoteLocales()
                })
                .finally(() => {
                    _self.closest('.modal').modal('hide')
                    _self.removeClass('button-loading')
                })
        })
    }
})
