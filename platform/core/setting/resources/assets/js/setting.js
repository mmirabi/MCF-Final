class SettingManagement {
    init() {
        this.handleMultipleAdminEmails()

        $('input[data-key=email-config-status-btn]').on('change', (event) => {
            let _self = $(event.currentTarget)
            let key = _self.prop('name')
            let url = _self.data('change-url')

            $httpClient
                .make()
                .post(url, { key: key, value: _self.prop('checked') ? 1 : 0 })
                .then(({ data }) => Botble.showSuccess(data.message))
        })

        $(document).on('change', '.setting-select-options', (event) => {
            $('.setting-wrapper').addClass('hidden')
            $('.setting-wrapper[data-type=' + $(event.currentTarget).val() + ']').removeClass('hidden')
        })

        $('.send-test-email-trigger-button').on('click', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)
            let defaultText = _self.text()
            let form = new FormData(_self.closest('form')[0])

            _self.text(_self.data('saving'))

            $httpClient
                .make()
                .postForm(route('settings.email.edit'), form)
                .then(({ data }) => {
                    Botble.showSuccess(data.message)
                    $('#send-test-email-modal').modal('show')
                })
                .finally(() => {
                    _self.text(defaultText)
                })
        })

        $('#send-test-email-btn').on('click', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)

            _self.addClass('button-loading')

            $httpClient
                .make()
                .post(route('setting.email.send.test'), {
                    email: _self.closest('.modal-content').find('input[name=email]').val(),
                })
                .then(({ data }) => {
                    Botble.showSuccess(data.message)
                    _self.closest('.modal').modal('hide')
                })
                .finally(() => {
                    _self.removeClass('button-loading')
                })
        })

        $('.generate-thumbnails-trigger-button').on('click', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)
            let defaultText = _self.text()

            _self.text(_self.data('saving'))

            $httpClient
                .make()
                .postForm(route('settings.media.post'), new FormData(_self.closest('form')[0]))
                .then(() => $('#generate-thumbnails-modal').modal('show'))
                .finally(() => {
                    _self.text(defaultText)
                })
        })

        $('#generate-thumbnails-button').on('click', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)

            _self.addClass('button-loading')

            $httpClient
                .make()
                .post(route('settings.media.generate-thumbnails'))
                .then(({ data }) => Botble.showSuccess(data.message))
                .finally(() => {
                    _self.removeClass('button-loading')
                    _self.closest('.modal').modal('hide')
                })
        })

        if (typeof CodeMirror !== 'undefined') {
            Botble.initCodeEditor('mail-template-editor')
        }

        $(document).on('click', '.btn-trigger-reset-to-default', (event) => {
            event.preventDefault()
            $('#reset-template-to-default-button').data('target', $(event.currentTarget).data('target'))
            $('#reset-template-to-default-modal').modal('show')
        })

        $(document).on('click', '.js-select-mail-variable', (event) => {
            event.preventDefault()
            let $this = $(event.currentTarget)

            let doc = $('.CodeMirror')[0].CodeMirror

            const key = '{{ ' + $this.data('key') + ' }}'

            // If there's a selection, replace the selection.
            if (doc.somethingSelected()) {
                doc.replaceSelection(key)
                return
            }

            // Otherwise, we insert at the cursor position.
            let cursor = doc.getCursor()
            let pos = {
                line: cursor.line,
                ch: cursor.ch,
            }
            doc.replaceRange(key, pos)
        })

        $(document).on('click', '.js-select-mail-function', (event) => {
            event.preventDefault()
            const $this = $(event.currentTarget)

            const CodeMirror = $('.CodeMirror')[0].CodeMirror

            const key = $this.data('sample')

            // If there's a selection, replace the selection.
            if (CodeMirror.somethingSelected()) {
                CodeMirror.replaceSelection(key)
                return
            }

            // Otherwise, we insert at the cursor position.
            const cursor = CodeMirror.getCursor()
            const position = {
                line: cursor.line,
                ch: cursor.ch,
            }
            CodeMirror.replaceRange(key, position)
        })

        $(document).on('click', '#reset-template-to-default-button', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)

            _self.addClass('button-loading')

            $httpClient
                .make()
                .post(_self.data('target'), {
                    email_subject_key: $('input[name=email_subject_key]').val(),
                    module: $('input[name=module]').val(),
                    template_file: $('input[name=template_file]').val(),
                })
                .then(({ data }) => {
                    Botble.showSuccess(data.message)

                    setTimeout(() => {
                        window.location.reload()
                    }, 1000)

                    $('#reset-template-to-default-modal').modal('hide')
                })
                .finally(() => {
                    _self.removeClass('button-loading')
                })
        })

        $(document).on('change', '.check-all', (event) => {
            let _self = $(event.currentTarget)
            let set = _self.attr('data-set')
            let checked = _self.prop('checked')
            $(set).each((index, el) => {
                if (checked) {
                    $(el).prop('checked', true)
                } else {
                    $(el).prop('checked', false)
                }
            })
        })

        $('input.setting-selection-option').each(function (index, el) {
            const $settingContentContainer = $($(el).data('target'))
            $(el).on('change', function () {
                if ($(el).val() == '1') {
                    $settingContentContainer.removeClass('d-none')
                    Botble.initResources()
                } else {
                    $settingContentContainer.addClass('d-none')
                }
            })
        })

        $(document).on('click', '.cronjob #copy-command', () => {
            this.copyCommand()
        })
    }

    handleMultipleAdminEmails() {
        let $wrapper = $('#admin_email_wrapper')

        if (!$wrapper.length) {
            return
        }

        let $addBtn = $wrapper.find('#add')
        let max = parseInt($wrapper.data('max'), 10)

        let emails = $wrapper.data('emails')

        if (emails.length === 0) {
            emails = ['']
        }

        const onAddEmail = () => {
            let count = $wrapper.find('input[type=email]').length

            if (count >= max) {
                $addBtn.addClass('disabled')
            } else {
                $addBtn.removeClass('disabled')
            }
        }

        const addEmail = (value = '') => {
            return $addBtn.before(`<div class="d-flex mt-2 more-email align-items-center">
                <input type="email" class="next-input" placeholder="${$addBtn.data(
                    'placeholder'
                )}" name="admin_email[]" value="${value ? value : ''}" />
                <a class="btn btn-link text-danger"><i class="fas fa-minus"></i></a>
            </div>`)
        }

        const render = () => {
            emails.forEach((email) => {
                addEmail(email)
            })
            onAddEmail()
        }

        $wrapper.on('click', '.more-email > a', function () {
            $(this).parent('.more-email').remove()
            onAddEmail()
        })

        $addBtn.on('click', (e) => {
            e.preventDefault()
            addEmail()
            onAddEmail()
        })

        render()
    }

    async copyCommand() {
        const input = $('.cronjob #command')

        const textToCopy = input.val()
        if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(textToCopy)

            Botble.showSuccess(input.data('copied'))
        } else {
            const textarea = document.createElement('textarea')
            textarea.value = textToCopy
            textarea.style.position = 'absolute'
            textarea.style.left = '-999999px'
            document.body.prepend(textarea)
            textarea.select()

            try {
                document.execCommand('copy')

                Botble.showSuccess(input.data('copied'))
            } catch (error) {
                console.error(error)
            } finally {
                textarea.remove()
            }
        }
    }
}

$(document).ready(() => {
    new SettingManagement().init()
})
