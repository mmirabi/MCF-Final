;(function($) {
    'use strict'

    function handleToggleDrawer() {
        $('.ps-drawer-toggle').on('click', function() {
            $('.ps-drawer--mobile').addClass('active')
            $('.ps-site-overlay').addClass('active')
        })

        $('.ps-drawer__close').on('click', function() {
            $('.ps-drawer--mobile').removeClass('active')
            $('.ps-site-overlay').removeClass('active')
        })

        $('body').on('click', function(e) {
            if ($(e.target).siblings('.ps-drawer--mobile').hasClass('active')) {
                $('.ps-drawer--mobile').removeClass('active')
                $('.ps-site-overlay').removeClass('active')
            }
        })
    }

    function tabs() {
        $('.ps-tab-list  li > a ').on('click', function(e) {
            e.preventDefault()
            const target = $(this).attr('href')
            $(this).closest('li').siblings('li').removeClass('active')
            $(this).closest('li').addClass('active')
            $(target).addClass('active')
            $(target).siblings('.ps-tab').removeClass('active')
        })
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader()
            reader.onload = function(e) {
                $(input).closest('.image-box').find('.preview_image').prop('src', e.target.result)
            }

            reader.readAsDataURL(input.files[0])
        }
    }

    $(function() {
        tabs()
        handleToggleDrawer()

        $('#shop-url')
            .on('keyup', function() {
                let displayURL = $(this).closest('.form-group').find('span small')
                displayURL.html(displayURL.data('base-url') + '/<strong>' + $(this).val().toLowerCase() + '</strong>')
            })
            .on('change', function() {
                $('.shop-url-wrapper').addClass('content-loading')
                $(this).closest('form').find('button[type=submit]').addClass('btn-disabled').prop('disabled', true)

                $.ajax({
                    url: $(this).data('url'),
                    type: 'POST',
                    data: {
                        url: $(this).val(),
                        reference_id: $('input[name=reference_id]').val(),
                    },
                    success: (res) => {
                        $('.shop-url-wrapper').removeClass('content-loading')
                        if (res.error) {
                            $('.shop-url-status').removeClass('text-success').addClass('text-danger').text(res.message)
                        } else {
                            $('.shop-url-status').removeClass('text-danger').addClass('text-success').text(res.message)
                            $(this)
                                .closest('form')
                                .find('button[type=submit]')
                                .prop('disabled', false)
                                .removeClass('btn-disabled')
                        }
                    },
                    error: () => {
                        $('.shop-url-wrapper').removeClass('content-loading')
                    },
                })
            })

        $('.custom-select-image').on('click', function(event) {
            event.preventDefault()
            $(this).closest('.image-box').find('.image_input').trigger('click')
        })

        $('.image_input').on('change', function() {
            readURL(this)
        })

        $(document).on('click', '.btn_remove_image', (event) => {
            event.preventDefault()
            let $img = $(event.currentTarget).closest('.image-box').find('.preview-image-wrapper .preview_image')
            $img.attr('src', $img.data('default-image'))
            $(event.currentTarget).closest('.image-box').find('.image-data').val('')
        })

        if (window.noticeMessages && window.noticeMessages.length) {
            noticeMessages.map((x) => {
                Botble.showNotice(x.type, x.message, '')
            })
        }
    })
})(jQuery)
