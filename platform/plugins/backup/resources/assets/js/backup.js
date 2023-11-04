class BackupManagement {
    init() {
        let backupTable = $('#table-backups')
        backupTable.on('click', '.deleteDialog', (event) => {
            event.preventDefault()

            $('.delete-crud-entry').data('section', $(event.currentTarget).data('section'))
            $('.modal-confirm-delete').modal('show')
        })

        backupTable.on('click', '.restoreBackup', (event) => {
            event.preventDefault()
            $('#restore-backup-button').data('section', $(event.currentTarget).data('section'))
            $('#restore-backup-modal').modal('show')
        })

        $('.delete-crud-entry').on('click', (event) => {
            event.preventDefault()
            $('.modal-confirm-delete').modal('hide')

            let deleteURL = $(event.currentTarget).data('section')

            $httpClient
                .make()
                .delete(deleteURL)
                .then(({ data }) => {
                    if (backupTable.find('tbody tr').length <= 1) {
                        backupTable.load(window.location.href + ' #table-backups > *')
                    }

                    backupTable
                        .find('a[data-section="' + deleteURL + '"]')
                        .closest('tr')
                        .remove()

                    Botble.showSuccess(data.message)
                })
        })

        $('#restore-backup-button').on('click', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)
            _self.addClass('button-loading')

            $httpClient
                .make()
                .get(_self.data('section'))
                .then(({ data }) => {
                    _self.closest('.modal').modal('hide')
                    Botble.showSuccess(data.message)
                    window.location.reload()
                })
                .finally(() => {
                    _self.removeClass('button-loading')
                })
        })

        $(document).on('click', '#generate_backup', (event) => {
            event.preventDefault()
            $('#name').val('')
            $('#description').val('')
            $('#create-backup-modal').modal('show')
        })

        $('#create-backup-modal').on('click', '#create-backup-button', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)
            _self.addClass('button-loading')

            let name = $('#name').val()
            let description = $('#description').val()
            let error = false
            if (name === '' || name === null) {
                error = true
                Botble.showError('Backup name is required!')
            }

            if (!error) {
                $httpClient
                    .make()
                    .post($('div[data-route-create]').data('route-create'), {
                        name: name,
                        description: description,
                    })
                    .then(({ data }) => {
                        backupTable.find('.no-backup-row').remove()
                        backupTable.find('tbody').append(data.data)
                        Botble.showSuccess(data.message)
                    })
                    .finally(() => {
                        _self.removeClass('button-loading')
                        _self.closest('.modal').modal('hide')
                    })
            } else {
                _self.removeClass('button-loading')
            }
        })
    }
}

$(document).ready(() => {
    new BackupManagement().init()
})
