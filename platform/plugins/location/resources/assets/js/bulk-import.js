$(() => {
    const $locationImport = $('.location-import')
    const $form = $locationImport.find('.form-import-data')

    const dropzone = new Dropzone('.location-dropzone', {
        url: $locationImport.data('upload-url'),
        method: 'post',
        headers: {
            'X-CSRF-TOKEN': $form.find('input[name=_token]').val(),
        },
        previewTemplate: $locationImport.find('#preview-template').html(),
        autoProcessQueue: false,
        chunking: true,
        chunkSize: 1048576,
        acceptedFiles: $locationImport.find('.location-dropzone').data('mimetypes'),
        maxFiles: 1,
        maxfilesexceeded: function (file) {
            this.removeFile(file)
        },
    })

    $(document).on('submit', '.form-import-data', function (event) {
        event.preventDefault()

        const $button = $form.find('button[type=submit]')

        let failedRows = []

        const validateData = (file, offset = 0, limit) => {
            $.ajax({
                url: $locationImport.data('validate-url'),
                type: 'POST',
                data: {
                    file,
                    offset,
                    limit,
                },
                beforeSend: () => {
                    if (offset === 0) {
                        $form.find('.status-text').text($button.data('validating-text'))
                        $button.prop('disabled', true).addClass('button-loading')
                        $('.main-form-message').hide()
                    }
                },
                success: ({ error, message, data }) => {
                    if (error) {
                        Botble.showError(message)

                        return
                    }

                    if (data && data.count > 0) {
                        $form.find('.status-text').text(message)
                        validateData(file, data.offset)
                        failedRows = [...failedRows, ...data.failed]
                    } else {
                        $button.prop('disabled', false).removeClass('button-loading')
                        if (failedRows.length > 0) {
                            const $listing = $('#imported-listing')
                            const $show = $('.show-errors')
                            const failureTemplate = $('#failure-template').html()

                            let result = ''
                            failedRows.forEach((val) => {
                                result += failureTemplate
                                    .replace('__row__', val.row)
                                    .replace('__errors__', val.errors.join(', '))
                            })

                            $show.show()

                            $('.main-form-message').show()
                            $listing.show().html(result)
                        } else {
                            importData(file)
                        }
                    }
                },
                error: (error) => {
                    Botble.handleError(error)
                },
            })
        }

        const importData = (file, offset = 0, limit) => {
            $.ajax({
                url: $locationImport.data('import-url'),
                type: 'POST',
                data: {
                    file,
                    offset,
                    limit,
                },
                beforeSend: () => {
                    if (offset === 0) {
                        $form.find('.status-text').text($button.data('importing-text'))
                        $button.prop('disabled', true).addClass('button-loading')
                    }
                },
                success: ({ error, message, data }) => {
                    if (error) {
                        Botble.showError(message)

                        return
                    }

                    if (data && data.count > 0) {
                        importData(file, data.offset)
                        $form.find('.status-text').text(message)
                    } else {
                        Botble.showSuccess(message)
                        $button.prop('disabled', false).removeClass('button-loading')
                        $form.find('.status-text').hide()
                        Botble.unblockUI($form.find('.upload-form'))

                        if (data.total_message) {
                            $locationImport.find('.main-form-message').show()
                            $locationImport.find('.success-message').show().text(data.total_message)
                            dropzone.removeAllFiles(true)
                        }
                    }
                },
                error: (error) => {
                    Botble.handleError(error)
                    Botble.unblockUI($form.find('.upload-form'))
                },
            })
        }

        if (dropzone.getQueuedFiles().length > 0) {
            dropzone.processQueue()
        }

        dropzone.on('sending', function () {
            Botble.blockUI({
                target: $form.find('.upload-form'),
                iconOnly: true,
                overlayColor: 'none',
            })

            $form.find('.status-text').show().text($button.data('uploading-text'))
            $button.prop('disabled', true).addClass('button-loading')
        })

        dropzone.on('error', function (file, message) {
            Botble.showError(message.message)
        })

        dropzone.on('success', function (file, { data }) {
            validateData(data.file_path)
        })
    })

    const alertWarning = $('.alert.alert-warning')
    if (alertWarning.length > 0) {
        alertWarning.forEach((el) => {
            let storageAlert = localStorage.getItem('storage-alerts')
            storageAlert = storageAlert ? JSON.parse(storageAlert) : {}

            if ($(el).data('alert-id')) {
                if (storageAlert[$(el).data('alert-id')]) {
                    $(el).alert('close')
                    return
                }
                $(el).removeClass('hidden')
            }
        })
    }

    alertWarning.on('closed.bs.alert', function (el) {
        const storage = $(el.target).data('alert-id')
        if (storage) {
            let storageAlert = localStorage.getItem('storage-alerts')
            storageAlert = storageAlert ? JSON.parse(storageAlert) : {}
            storageAlert[storage] = true
            localStorage.setItem('storage-alerts', JSON.stringify(storageAlert))
        }
    })

    let isDownloadingTemplate = false

    $(document).on('click', '.download-template', function (event) {
        event.preventDefault()
        if (isDownloadingTemplate) {
            return
        }
        const $this = $(event.currentTarget)
        const extension = $this.data('extension')
        const $content = $this.html()

        $.ajax({
            url: $this.data('url'),
            method: 'POST',
            data: {
                extension,
            },
            xhrFields: {
                responseType: 'blob',
            },
            beforeSend: () => {
                $this.html($this.data('downloading'))
                $this.addClass('text-secondary')
                isDownloadingTemplate = true
            },
            success: function (data) {
                let a = document.createElement('a')
                let url = window.URL.createObjectURL(data)
                a.href = url
                a.download = $this.data('filename')
                document.body.append(a)
                a.click()
                a.remove()
                window.URL.revokeObjectURL(url)
            },
            error: (data) => {
                Botble.handleError(data)
            },
            complete: () => {
                setTimeout(() => {
                    $this.html($content)
                    $this.removeClass('text-secondary')
                    isDownloadingTemplate = false
                }, 2000)
            },
        })
    })

    let $availableRemoteLocations = $('#available-remote-locations')

    if ($availableRemoteLocations.length) {
        let getRemoteLocations = () => {
            $.ajax({
                url: $availableRemoteLocations.data('url'),
                type: 'GET',
                success: ({ error, message, data }) => {
                    if (error) {
                        Botble.showError(message)
                    } else {
                        $availableRemoteLocations.html(data)
                    }
                },
                error: (error) => {
                    Botble.handleError(error)
                },
            })
        }

        getRemoteLocations()

        $(document).on('click', '.btn-import-location-data', function (event) {
            event.preventDefault()

            $('.button-confirm-import').data('url', $(this).data('url'))
            $('.modal-confirm-import').modal('show')
        })

        $('.button-confirm-import').on('click', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)

            _self.addClass('button-loading')

            let url = _self.data('url')

            $.ajax({
                url: url,
                type: 'POST',
                success: ({ error, message }) => {
                    if (error) {
                        Botble.showError(message)
                    } else {
                        Botble.showSuccess(message)
                        getRemoteLocations()
                    }

                    _self.closest('.modal').modal('hide')
                    _self.removeClass('button-loading')
                },
                error: (error) => {
                    Botble.handleError(error)
                    _self.removeClass('button-loading')
                },
            })
        })
    }
})
