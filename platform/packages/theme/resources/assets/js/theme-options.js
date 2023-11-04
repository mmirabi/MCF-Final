$(document).ready(() => {
    if ($(document).find('.colorpicker-input').length > 0) {
        $(document).find('.colorpicker-input').colorpicker()
    }

    if ($(document).find('.iconpicker-input').length > 0) {
        $(document).find('.iconpicker-input').iconpicker({
            selected: true,
            hideOnSelect: true,
        })
    }

    $(document).ready(function () {
        $(document).on('click', '.button-save-theme-options', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)
            _self.addClass('button-loading')

            if (typeof tinymce != 'undefined') {
                for (let instance in tinymce.editors) {
                    if (tinymce.editors[instance].getContent) {
                        $('#' + instance).html(tinymce.editors[instance].getContent())
                    }
                }
            }

            const $form = _self.closest('form')

            $httpClient
                .make()
                .post($form.prop('action'), new FormData($form[0]))
                .then(({ data }) => {
                    Botble.showSuccess(data.message)
                    $form.removeClass('dirty')
                })
                .finally(() => {
                    _self.removeClass('button-loading')
                })
        })

        $('.theme-option-sidebar a[data-bs-toggle="tab"]').on('click', () => {
            Botble.initResources()

            if (typeof EditorManagement != 'undefined') {
                window.EDITOR = new EditorManagement().init()
                window.EditorManagement = window.EditorManagement || EditorManagement
            }
        })
    })
})
