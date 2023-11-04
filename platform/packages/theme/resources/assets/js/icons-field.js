$(document).ready(function () {
    'use strict'

    const initIconsField = () => {
        const icons = window.themeIcons || []

        if (!icons) {
            return
        }

        $(document)
            .find('.icon-select')
            .each(function (index, el) {
                const $this = $(el)
                if ($this.data('check-initialized') && $this.hasClass('select2-hidden-accessible')) {
                    return
                }

                let value = $this.children('option:selected').val()

                let options = '<option value="">' + $this.data('empty-value') + '</option>'

                icons.forEach(function (value) {
                    options += '<option value="' + value + '">' + value + '</option>'
                })

                $this.html(options)
                $this.val(value)

                const templateCallback = (state) => {
                    if (!state.id) {
                        return state.text
                    }

                    return $(`<span><i class="${state.id}"></i></span> ${state.text}</span>`)
                }

                const select2Options = {
                    templateResult: (state) => templateCallback(state),
                    width: '100%',
                    templateSelection: (state) => templateCallback(state),
                }

                const parent = $this.closest('.modal')
                if (parent.length) {
                    select2Options.dropdownParent = parent
                }

                $this.select2(select2Options)
            })
    }

    initIconsField()

    document.addEventListener('core-init-resources', function () {
        initIconsField()
    })
})
