(function($) {
    'use strict'

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    })

    let showError = message => {
        window.showAlert('alert-danger', message)
    }

    let showSuccess = message => {
        window.showAlert('alert-success', message)
    }

    let handleError = data => {
        if (typeof (data.errors) !== 'undefined' && data.errors.length) {
            handleValidationError(data.errors)
        } else if (typeof (data.responseJSON) !== 'undefined') {
            if (typeof (data.responseJSON.errors) !== 'undefined') {
                if (data.status === 422) {
                    handleValidationError(data.responseJSON.errors)
                }
            } else if (typeof (data.responseJSON.message) !== 'undefined') {
                showError(data.responseJSON.message)
            } else {
                $.each(data.responseJSON, (index, el) => {
                    $.each(el, (key, item) => {
                        showError(item)
                    })
                })
            }
        } else {
            showError(data.statusText)
        }
    }

    let handleValidationError = errors => {
        let message = ''

        $.each(errors, (index, item) => {
            if (message !== '') {
                message += '<br />'
            }
            message += item
        })

        showError(message)
    }

    window.showAlert = (messageType, message) => {
        if (messageType && message !== '') {
            let alertId = Math.floor(Math.random() * 1000)

            let html = `<div class='alert ${messageType} alert-dismissible' id='${alertId}'>
                <span class='btn-close' data-bs-dismiss='alert' aria-label='close'></span>
                <i class='fi-rs-` + (messageType === 'alert-success' ? 'check' : 'cross') + ` message-icon'></i>
                ${message}
            </div>`

            $('#alert-container').append(html).ready(() => {
                window.setTimeout(() => {
                    $(`#alert-container #${alertId}`).remove()
                }, 6000)
            })
        }
    }

    function parseParamsSearch(query, includeArray = false) {
        let pairs = query || window.location.search.substring(1)
        let re = /([^&=]+)=?([^&]*)/g
        let decodeRE = /\+/g  // Regex for replacing addition symbol with a space
        let decode = function(str) {
            return decodeURIComponent(str.replace(decodeRE, ' '))
        }

        let params = {}, e
        while (e = re.exec(pairs)) {
            let k = decode(e[1]), v = decode(e[2])
            if (k.substring(k.length - 2) == '[]') {
                if (includeArray) {
                    k = k.substring(0, k.length - 2)
                }
                (params[k] || (params[k] = [])).push(v)
            } else {
                params[k] = v
            }
        }

        return params
    }

    function setCookie(cname, cvalue, exdays) {
        let d = new Date()
        let siteUrl = window.siteUrl

        if (!siteUrl.includes(window.location.protocol)) {
            siteUrl = window.location.protocol + siteUrl
        }

        let url = new URL(siteUrl)
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000))
        let expires = 'expires=' + d.toUTCString()
        document.cookie = cname + '=' + cvalue + '; ' + expires + '; path=/' + '; domain=' + url.hostname
    }

    function getCookie(cname) {
        let name = cname + '='
        let ca = document.cookie.split(';')
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i]
            while (c.charAt(0) == ' ') {
                c = c.substring(1)
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length)
            }
        }
        return ''
    }

    let isRTL = $('body').prop('dir') === 'rtl'

    $(document).ready(function() {
        if (jQuery().mCustomScrollbar) {
            $('.ps-custom-scrollbar').mCustomScrollbar({
                theme: 'dark',
                scrollInertia: 0,
            })
        }

        window.onBeforeChangeSwatches = function(data) {
            $('.add-to-cart-form .error-message').hide()
            $('.add-to-cart-form .success-message').hide()
            $('.number-items-available').html('').addClass('d-none')

            if (data && data.attributes) {
                $('.add-to-cart-form button[type=submit]').prop('disabled', true).addClass('btn-disabled')
            }
        }

        window.onChangeSwatchesSuccess = function(res) {
            $('.add-to-cart-form .error-message').hide()
            $('.add-to-cart-form .success-message').hide()

            if (res) {
                let buttonSubmit = $('.add-to-cart-form button[type=submit]')
                if (response.error) {
                    buttonSubmit.prop('disabled', true).addClass('btn-disabled')
                    $('.number-items-available').html('<span class="text-danger">(' + response.message + ')</span>').removeClass('d-none')
                    $('.hidden-product-id').val('')
                } else {
                    $('.add-to-cart-form').find('.error-message').hide()
                    $('.product-price span.current-price').text(response.data.display_sale_price)
                    if (response.data.sale_price !== response.data.price) {
                        $('.product-price span.old-price').text(response.data.display_price).removeClass('d-none')
                        $('.product-price span.save-price .percentage-off').text(response.data.sale_percentage)
                        $('.product-price span.save-price').removeClass('d-none')
                    } else {
                        $('.product-price span.old-price').addClass('d-none')
                        $('.product-price span.save-price').addClass('d-none')
                    }

                    if (response.data.sku) {
                        $('#product-sku').removeClass('d-none')
                        $('#product-sku .sku-text').text(response.data.sku)
                    } else {
                        $('#product-sku').addClass('d-none')
                    }

                    $('.hidden-product-id').val(response.data.id)

                    buttonSubmit.prop('disabled', false).removeClass('btn-disabled')

                    if (response.data.error_message) {
                        buttonSubmit.prop('disabled', true).addClass('btn-disabled')
                        $('.number-items-available').html('<span class="text-danger">' + response.data.error_message + '</span>').removeClass('d-none')
                    } else if (response.data.success_message) {
                        console.log(response.data.success_message)
                        $('.number-items-available').html(response.data.success_message).addClass('text-success').removeClass('d-none')
                    } else {
                        $('.number-items-available').html('').addClass('d-none')
                    }

                    const unavailableAttributeIds = response.data.unavailable_attribute_ids || []
                    $('.attribute-swatch-item').removeClass('pe-none')
                    $('.product-filter-item option').prop('disabled', false)
                    if (unavailableAttributeIds && unavailableAttributeIds.length) {
                        unavailableAttributeIds.map(function(id) {
                            let $item = $('.attribute-swatch-item[data-id="' + id + '"]')
                            if ($item.length) {
                                $item.addClass('pe-none')
                                $item.find('input').prop('checked', false)
                            } else {
                                $item = $('.product-filter-item option[data-id="' + id + '"]')
                                if ($item.length) {
                                    $item.prop('disabled', 'disabled').prop('selected', false)
                                }
                            }
                        })
                    }

                    let slider = $('.product-image-slider')

                    slider.slick('unslick')

                    let imageHtml = ''
                    response.data.image_with_sizes.origin.forEach(function(item) {
                        imageHtml += '<figure class="border-radius-10"><a href="' + item + '"><img src="' + item + '" alt="image"/></a></figure>'
                    })

                    slider.html(imageHtml)

                    slider.slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        rtl: isRTL,
                        arrows: false,
                        fade: false,
                        asNavFor: '.slider-nav-thumbnails',
                    })

                    let sliderThumbnail = $('.slider-nav-thumbnails')

                    sliderThumbnail.slick('unslick')

                    let thumbHtml = ''
                    response.data.image_with_sizes.thumb.forEach(function(item) {
                        thumbHtml += '<div class="item"><img src="' + item + '" alt="image"/></div>'
                    })

                    sliderThumbnail.html(thumbHtml)

                    sliderThumbnail.slick({
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        rtl: isRTL,
                        asNavFor: '.product-image-slider',
                        dots: false,
                        focusOnSelect: true,
                        prevArrow: '<button type="button" class="slick-prev"><i class="fi-rs-arrow-small-left"></i></button>',
                        nextArrow: '<button type="button" class="slick-next"><i class="fi-rs-arrow-small-right"></i></button>',
                    })

                    // Remove active class from all thumbnail slides
                    sliderThumbnail.find('.slick-slide').removeClass('slick-active')

                    // Set active class to first thumbnail slides
                    sliderThumbnail.find('.slick-slide').eq(0).addClass('slick-active')

                    // On before slide change match active thumbnail to current slide
                    slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                        let mySlideNumber = nextSlide
                        sliderThumbnail.find('.slick-slide').removeClass('slick-active')
                        sliderThumbnail.find('.slick-slide').eq(mySlideNumber).addClass('slick-active')
                    })

                    slider.magnificPopup({
                        delegate: '.slick-slide:not(.slick-cloned) a', // the selector for gallery item
                        type: 'image',
                        gallery: {
                            enabled: true,
                        },
                    })
                }
            }
        }

        $(document).on('click', '.newsletter-form button[type=submit]', function(event) {
            event.preventDefault()
            event.stopPropagation()

            let _self = $(this)

            _self.addClass('button-loading')

            $.ajax({
                type: 'POST',
                cache: false,
                url: _self.closest('form').prop('action'),
                data: new FormData(_self.closest('form')[0]),
                contentType: false,
                processData: false,
                success: (response) => {
                    if (typeof refreshRecaptcha !== 'undefined') {
                        refreshRecaptcha()
                    }

                    if (!response.error) {
                        _self.closest('form').find('input[type=email]').val('')
                        showSuccess(response.message)
                    } else {
                        showError(response.message)
                    }
                },
                error: (response) => {
                    if (typeof refreshRecaptcha !== 'undefined') {
                        refreshRecaptcha()
                    }
                    handleError(res)
                },
                complete: function() {
                    _self.removeClass('button-loading')
                },
            })
        })

        $(document).on('change', '.switch-currency', function() {
            $(this).closest('form').submit()
        })

        $(document).on('click', '.js-add-to-wishlist-button', function(event) {
            event.preventDefault()
            let _self = $(this)
            _self.addClass('button-loading')

            $.ajax({
                url: _self.data('url'),
                method: 'POST',
                success: (response) => {
                    if (response.error) {
                        window.showAlert('alert-danger', response.message)
                        return false
                    }

                    window.showAlert('alert-success', response.message)
                    $('.wishlist-count').text(response.data.count)
                    _self.toggleClass('wis_added')
                    _self.removeClass('button-loading')
                        .removeClass('js-add-to-wishlist-button')
                        .addClass('js-remove-from-wishlist-button')
                },
                error: (response) => {
                    window.showAlert('alert-danger', response.message)
                },
                complete: function() {
                    _self.removeClass('button-loading')
                },
            })
        })

        $(document).on('click', '.js-remove-from-wishlist-button', function(event) {
            event.preventDefault()
            let _self = $(this)

            _self.addClass('button-loading')

            $.ajax({
                url: _self.data('url'),
                method: 'DELETE',
                success: (response) => {
                    if (response.error) {
                        window.showAlert('alert-danger', response.message)
                        return false
                    }

                    window.showAlert('alert-success', response.message)
                    $('.wishlist-count').text(response.data.count)
                    _self.closest('tr').remove()
                    _self.removeClass('js-remove-from-wishlist-button')
                        .addClass('js-add-to-wishlist-button')
                },
                error: (response) => {
                    window.showAlert('alert-danger', response.message)
                },
                complete: function() {
                    _self.removeClass('button-loading')
                },
            })
        })

        $(document).on('click', '.js-add-to-compare-button', function(event) {
            event.preventDefault()
            let _self = $(this)

            _self.addClass('button-loading')

            $.ajax({
                url: _self.data('url'),
                method: 'POST',
                success: (response) => {
                    if (response.error) {
                        window.showAlert('alert-danger', response.message)
                        return false
                    }

                    $('.compare-count').text(response.data.count)
                    window.showAlert('alert-success', response.message)
                },
                error: (response) => {
                    window.showAlert('alert-danger', response.message)
                },
                complete: function() {
                    _self.removeClass('button-loading')
                },
            })
        })

        $(document).on('click', '.js-remove-from-compare-button', function(event) {
            event.preventDefault()
            let _self = $(this)
            let buttonHtml = _self.html()

            _self.html(buttonHtml + '...')

            $.ajax({
                url: _self.data('url'),
                method: 'DELETE',
                success: (response) => {

                    if (response.error) {
                        _self.text(buttonHtml)
                        window.showAlert('alert-danger', response.message)
                        return false
                    }

                    $('.compare-count').text(response.data.count)

                    $('.table__compare').load(window.location.href + ' .table__compare > *', function() {
                        window.showAlert('alert-success', response.message)

                        _self.html(buttonHtml)
                    })
                },
                error: (response) => {
                    _self.removeClass('button-loading')
                    window.showAlert('alert-danger', response.message)
                },
            })
        })

        $(document).on('click', '.add-to-cart-button', function(event) {
            event.preventDefault()
            let _self = $(this)

            _self.prop('disabled', true).addClass('button-loading')

            $.ajax({
                url: _self.data('url'),
                method: 'POST',
                data: {
                    id: _self.data('id'),
                },
                dataType: 'json',
                success: (response) => {
                    _self.prop('disabled', false).removeClass('button-loading').addClass('active')

                    if (response.error) {
                        window.showAlert('alert-danger', response.message)

                        if (response.data.next_url !== undefined) {
                            window.location.href = response.data.next_url
                        }

                        return false
                    }

                    window.showAlert('alert-success', response.message)

                    if (response.data.next_url !== undefined) {
                        window.location.href = response.data.next_url
                    } else {
                        if (response.additional) {
                            $('.cart-dropdown-panel').html(response.additional.html)
                        }

                        $('.mini-cart-icon span').text(response.data.count)
                    }
                },
                error: (response) => {
                    _self.prop('disabled', false).removeClass('button-loading')
                    window.showAlert('alert-danger', response.message)
                },
            })
        })

        $(document).on('click', '.add-to-cart-form button[type=submit]', function(event) {
            event.preventDefault()
            event.stopPropagation()

            let _self = $(this)

            if (!$('.hidden-product-id').val()) {
                _self.prop('disabled', true).addClass('btn-disabled')
                return
            }

            _self.prop('disabled', true).addClass('btn-disabled').addClass('button-loading')

            let $form = _self.closest('form')
            let data = $form.serializeArray()
            data.push({ name: 'checkout', value: _self.prop('name') === 'checkout' ? 1 : 0 })

            $.ajax({
                type: 'POST',
                url: $form.prop('action'),
                data: $.param(data),
                success: (response) => {
                    _self.prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading')

                    if (response.error) {
                        _self.removeClass('button-loading')
                        window.showAlert('alert-danger', response.message)

                        if (response.data.next_url !== undefined) {
                            window.location.href = response.data.next_url
                        }

                        return false
                    }

                    window.showAlert('alert-success', response.message)

                    if (response.data.next_url !== undefined) {
                        window.location.href = response.data.next_url
                    } else {
                        if (response.additional) {
                            $('.cart-dropdown-panel').html(response.additional.html)
                        }

                        $('.mini-cart-icon span').text(response.data.count)
                    }
                },
                error: (response) => {
                    _self.prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading')
                    handleError(res, _self.closest('form'))
                },
            })
        })

        $(document).on('click', '.remove-cart-item', function(event) {
            event.preventDefault()
            let _self = $(this)

            _self.closest('li').addClass('content-loading')

            $.ajax({
                url: _self.data('url'),
                method: 'POST',
                data: {
                    _method: 'DELETE',
                },
                success: (response) => {
                    _self.closest('li').removeClass('content-loading')

                    if (response.error) {
                        window.showAlert('alert-danger', response.message)
                        return false
                    }

                    $('.mini-cart-icon span').text(response.data.count)

                    if (response.additional) {
                        $('.cart-dropdown-panel').html(response.additional.html)
                        if (response.additional.cart_content) {
                            $('.section--shopping-cart').html(response.additional.cart_content)
                        }
                    }
                },
                error: (response) => {
                    _self.closest('li').removeClass('content-loading')
                    window.showAlert('alert-danger', response.message)
                },
            })
        })

        $(document).on('click', '.remove-cart-button', function(event) {
            event.preventDefault()
            let _self = $(this)

            _self.closest('.table--cart').addClass('content-loading')

            $.ajax({
                url: _self.data('url'),
                method: 'POST',
                data: {
                    _method: 'DELETE',
                },
                success: (response) => {

                    if (response.error) {
                        window.showAlert('alert-danger', response.message)
                        _self.closest('.table--cart').removeClass('content-loading')
                        return false
                    }

                    $('.mini-cart-icon span').text(response.data.count)

                    if (response.additional) {
                        $('.cart-dropdown-panel').html(response.additional.html)
                        if (response.additional.cart_content) {
                            $('.section--shopping-cart').html(response.additional.cart_content)
                        }
                    }
                },
                error: (response) => {
                    _self.closest('.table--cart').removeClass('content-loading')
                    window.showAlert('alert-danger', response.message)
                },
            })
        })

        $(document).on('change', '.submit-form-on-change', function() {
            $(this).closest('form').submit()
        })

        let imagesReviewBuffer = []
        let setImagesFormReview = function(input) {
            const dT = new ClipboardEvent('').clipboardData || // Firefox < 62 workaround exploiting https://bugzilla.mozilla.org/show_bug.cgi?id=1422655
                new DataTransfer() // specs compliant (as of March 2018 only Chrome)
            for (let file of imagesReviewBuffer) {
                dT.items.add(file)
            }
            input.files = dT.files
            loadPreviewImage(input)
        }

        let loadPreviewImage = function(input) {
            let $uploadText = $('.image-upload__text')
            const maxFiles = $(input).data('max-files')
            let filesAmount = input.files.length

            if (maxFiles) {
                if (filesAmount >= maxFiles) {
                    $uploadText.closest('.image-upload__uploader-container').addClass('d-none')
                } else {
                    $uploadText.closest('.image-upload__uploader-container').removeClass('d-none')
                }
                $uploadText.text(filesAmount + '/' + maxFiles)
            } else {
                $uploadText.text(filesAmount)
            }
            const viewerList = $('.image-viewer__list')
            const $template = $('#review-image-template').html()

            viewerList.addClass('is-loading')
            viewerList.find('.image-viewer__item').remove()

            if (filesAmount) {
                for (let i = filesAmount - 1; i >= 0; i--) {
                    viewerList.prepend($template.replace('__id__', i))
                }
                for (let j = filesAmount - 1; j >= 0; j--) {
                    let reader = new FileReader()
                    reader.onload = function(event) {
                        viewerList
                            .find('.image-viewer__item[data-id=' + j + ']')
                            .find('img')
                            .attr('src', event.target.result)
                    }
                    reader.readAsDataURL(input.files[j])
                }
            }
            viewerList.removeClass('is-loading')
        }

        $(document).on('change', '.form-review-product input[type=file]', function(event) {
            event.preventDefault()
            let input = this
            let $input = $(input)
            let maxSize = $input.data('max-size')
            Object.keys(input.files).map(function(i) {
                if (maxSize && (input.files[i].size / 1024) > maxSize) {
                    let message = $input.data('max-size-message')
                        .replace('__attribute__', input.files[i].name)
                        .replace('__max__', maxSize)
                    window.showAlert('alert-danger', message)
                } else {
                    imagesReviewBuffer.push(input.files[i])
                }
            })

            let filesAmount = imagesReviewBuffer.length
            const maxFiles = $input.data('max-files')
            if (maxFiles && filesAmount > maxFiles) {
                imagesReviewBuffer.splice(filesAmount - maxFiles - 1, filesAmount - maxFiles)
            }

            setImagesFormReview(input)
        })

        $(document).on('click', '.form-review-product .image-viewer__icon-remove', function(event) {
            event.preventDefault()
            const $this = $(event.currentTarget)
            let id = $this.closest('.image-viewer__item').data('id')
            imagesReviewBuffer.splice(id, 1)

            let input = $('.form-review-product input[type=file]')[0]
            setImagesFormReview(input)
        })

        if (sessionStorage.reloadReviewsTab) {
            $('.nav-tabs li a[href="#Reviews"]').tab('show')
            sessionStorage.reloadReviewsTab = false
        }

        $(document).on('click', '.form-review-product button[type=submit]', function(event) {
            event.preventDefault()
            event.stopPropagation()
            $(this).prop('disabled', true).addClass('btn-disabled').addClass('button-loading')

            const $form = $(this).closest('form')
            $.ajax({
                type: 'POST',
                cache: false,
                url: $form.prop('action'),
                data: new FormData($form[0]),
                contentType: false,
                processData: false,
                success: (response) => {
                    if (!response.error) {
                        $form.find('select').val(0)
                        $form.find('textarea').val('')

                        showSuccess(response.message)

                        setTimeout(function() {
                            sessionStorage.reloadReviewsTab = true
                            window.location.reload()
                        }, 1500)
                    } else {
                        showError(response.message)
                    }

                    $(this).prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading')
                },
                error: (response) => {
                    $(this).prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading')
                    handleError(res, $form)
                },
            })
        })

        $('.form-coupon-wrapper .coupon-code').keypress(event => {
            if (event.keyCode === 13) {
                $('.apply-coupon-code').trigger('click')
                event.preventDefault()
                event.stopPropagation()
                return false
            }
        })

        /**
         * Update Cart
         */
        $(document).on('click', '.detail-qty .qty-up', function(event) {
            event.preventDefault()
            event.stopPropagation()
            let $qtyInput = $(this).closest('.detail-qty').find('.qty-val')
            let qtyValue = parseInt($qtyInput.val() ? $qtyInput.val() : 1, 10)
            qtyValue = qtyValue + 1

            $qtyInput.val(qtyValue)

            if ($(this).closest('.section--shopping-cart').length) {
                ajaxUpdateCart($(this))
            }
        })

        $(document).on('click', '.detail-qty .qty-down', function(event) {
            event.preventDefault()
            event.stopPropagation()
            let $qtyInput = $(this).closest('.detail-qty').find('.qty-val')
            let qtyValue = parseInt($qtyInput.val() ? $qtyInput.val() : 1, 10)

            qtyValue = qtyValue - 1
            if (qtyValue > 1) {
            } else {
                qtyValue = 1
            }

            $(this).closest('.detail-qty').find('input').val(qtyValue)

            if (qtyValue >= 0 && $(this).closest('.section--shopping-cart').length) {
                ajaxUpdateCart($(this))
            }
        })

        $(document).on('change', '.section--shopping-cart .detail-qty .qty-val', function() {
            ajaxUpdateCart($(this))
        })

        function ajaxUpdateCart(_self) {

            _self.closest('.table--cart').addClass('content-loading')

            $.ajax({
                type: 'POST',
                cache: false,
                url: _self.closest('form').prop('action'),
                data: new FormData(_self.closest('form')[0]),
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response.error) {
                        window.showAlert('alert-danger', response.message)
                        _self.closest('.detail-qty').find('.qty-val').text(response.data.count)
                        return false
                    }

                    $('.mini-cart-icon span').text(response.data.count)

                    if (response.additional) {
                        $('.cart-dropdown-panel').html(response.additional.html)
                        if (response.additional.cart_content) {
                            $('.section--shopping-cart').html(response.additional.cart_content)
                        }
                    }

                    window.showAlert('alert-success', response.message)
                },
                complete: function() {
                    _self.closest('.table--cart').removeClass('content-loading')
                },
                error: (response) => {
                    window.showAlert('alert-danger', response.message)
                },
            })
        }

        $(document).on('click', '.btn-apply-coupon-code', event => {
            event.preventDefault()
            let _self = $(event.currentTarget)
            _self.prop('disabled', true).addClass('btn-disabled').addClass('button-loading')

            $.ajax({
                url: _self.data('url'),
                type: 'POST',
                data: {
                    coupon_code: _self.closest('.form-coupon-wrapper').find('.coupon-code').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: (response) => {
                    if (!response.error) {
                        $('.section--shopping-cart').load(window.location.href + '?applied_coupon=1 .section--shopping-cart > *', function() {
                            _self.prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading')
                            window.showAlert('alert-success', response.message)
                        })
                    } else {
                        window.showAlert('alert-danger', response.message)
                        _self.prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading')
                    }
                },
                error: data => {
                    if (typeof (data.responseJSON) !== 'undefined') {
                        if (data.responseJSON.errors !== 'undefined') {
                            $.each(data.responseJSON.errors, (index, el) => {
                                $.each(el, (key, item) => {
                                    window.showAlert('alert-danger', item)
                                })
                            })
                        } else if (typeof (data.responseJSON.message) !== 'undefined') {
                            window.showAlert('alert-danger', data.responseJSON.message)
                        }
                    } else {
                        window.showAlert('alert-danger', data.status.text)
                    }
                    _self.prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading')
                },
            })
        })

        $(document).on('click', '.btn-remove-coupon-code', event => {
            event.preventDefault()
            let _self = $(event.currentTarget)
            let buttonText = _self.text()
            _self.text(_self.data('processing-text'))

            $.ajax({
                url: _self.data('url'),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: (response) => {
                    if (!response.error) {
                        $('.section--shopping-cart').load(window.location.href + ' .section--shopping-cart > *', function() {
                            _self.text(buttonText)
                        })
                    } else {
                        window.showAlert('alert-danger', response.message)
                        _self.text(buttonText)
                    }
                },
                error: data => {
                    if (typeof (data.responseJSON) !== 'undefined') {
                        if (data.responseJSON.errors !== 'undefined') {
                            $.each(data.responseJSON.errors, (index, el) => {
                                $.each(el, (key, item) => {
                                    window.showAlert('alert-danger', item)
                                })
                            })
                        } else if (typeof (data.responseJSON.message) !== 'undefined') {
                            window.showAlert('alert-danger', data.responseJSON.message)
                        }
                    } else {
                        window.showAlert('alert-danger', data.status.text)
                    }
                    _self.text(buttonText)
                },
            })
        })

        $(document).on('click', '.js-remove-from-wishlist-button-wishlist', function(event) {
            event.preventDefault()
            let _self = $(this)

            _self.addClass('button-loading')

            $.ajax({
                url: _self.data('url'),
                method: 'DELETE',
                success: (response) => {

                    if (response.error) {
                        _self.removeClass('button-loading')
                        window.showAlert('alert-danger', response.message)
                        return false
                    }

                    window.showAlert('alert-success', response.message)

                    $('.wishlist-count').text(response.data.count)
                    _self.removeClass('button-loading')

                    _self.closest('tr').remove()
                },
                error: (response) => {
                    _self.removeClass('button-loading')
                    window.showAlert('alert-danger', response.message)
                },
            })
        })

        $(document).ready(function() {
            let $modal = $('#flash-sale-modal')
            if ($modal.length && !getCookie($modal.data('id'))) {
                setTimeout(function() {
                    $modal.modal('show')
                    setCookie($modal.data('id'), 1, 1)
                }, 5000)
            }
        })

        $(document).on('click', '.js-quick-view-button', event => {
            event.preventDefault()

            let $modal = $('#quick-view-modal')

            $modal.find('.quick-view-content').html('')
            $modal.find('.modal-body').addClass('modal-empty')
            $modal.find('.loading-spinner').show()
            $modal.modal('show')

            $.ajax({
                url: $(event.currentTarget).data('url'),
                type: 'GET',
                success: (response) => {
                    if (!response.error) {
                        $modal.find('.loading-spinner').hide()
                        $modal.find('.modal-body').removeClass('modal-empty')
                        let $quickViewContent = $modal.find('.quick-view-content')
                        $quickViewContent.html(response.data)

                        $modal.find('.product-image-slider').slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            rtl: isRTL,
                            arrows: false,
                            fade: false,
                            asNavFor: '.slider-nav-thumbnails',
                        })

                        $modal.find('.slider-nav-thumbnails').slick({
                            slidesToShow: 5,
                            slidesToScroll: 1,
                            rtl: isRTL,
                            asNavFor: '.product-image-slider',
                            dots: false,
                            focusOnSelect: true,
                            prevArrow: '<button type="button" class="slick-prev"><i class="fi-rs-arrow-small-left"></i></button>',
                            nextArrow: '<button type="button" class="slick-next"><i class="fi-rs-arrow-small-right"></i></button>',
                        })

                        // Remove active class from all thumbnail slides
                        $modal.find('.slider-nav-thumbnails .slick-slide').removeClass('slick-active')

                        // Set active class to first thumbnail slides
                        $modal.find('.slider-nav-thumbnails .slick-slide').eq(0).addClass('slick-active')

                        // On before slide change match active thumbnail to current slide
                        $modal.find('.product-image-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                            let mySlideNumber = nextSlide
                            $modal.find('.slider-nav-thumbnails .slick-slide').removeClass('slick-active')
                            $modal.find('.slider-nav-thumbnails .slick-slide').eq(mySlideNumber).addClass('slick-active')
                        })

                        $modal.find('.product-image-slider').magnificPopup({
                            delegate: '.slick-slide:not(.slick-cloned) a', // the selector for gallery item
                            type: 'image',
                            gallery: {
                                enabled: true,
                            },
                        })

                        $(window).trigger('resize')

                        //Filter color/Size
                        $('.list-filter').each(function() {
                            $(this).find('a').on('click', function(event) {
                                event.preventDefault()
                                $(this).parent().siblings().removeClass('active')
                                $(this).parent().toggleClass('active')
                                $(this).parents('.attr-detail').find('.current-size').text($(this).text())
                                $(this).parents('.attr-detail').find('.current-color').text($(this).attr('data-color'))
                            })
                        })
                    } else {
                        window.showAlert('alert-danger', response.message)
                        $modal.modal('hide')
                    }
                },
                error: () => {
                    $modal.modal('hide')
                },
            })
        })

        $(document).on('click', 'input[name=is_vendor]', function() {
            if ($(this).val() == 1) {
                $('.show-if-vendor').slideDown().show()
            } else {
                $('.show-if-vendor').slideUp()
                setTimeout(function() {
                    $('.show-if-vendor').hide()
                }, 500)
            }
        })

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
                    },
                    success: (response) => {
                        $('.shop-url-wrapper').removeClass('content-loading')
                        if (response.error) {
                            $('.shop-url-status').removeClass('text-success').addClass('text-danger').text(response.message)

                        } else {
                            $('.shop-url-status').removeClass('text-danger').addClass('text-success').text(response.message)
                            $(this).closest('form').find('button[type=submit]').prop('disabled', false).removeClass('btn-disabled')
                        }
                    },
                    error: () => {
                        $('.shop-url-wrapper').removeClass('content-loading')
                    },
                })
            })

        // Products filter ajax
        const $formSearch = $('#products-filter-ajax')
        const $productListing = $('.products-listing')

        function changeInputInSearchForm(parseParams) {
            $formSearch.find('input, select, textarea').each(function(e, i) {
                const $el = $(i)
                const name = $el.attr('name')
                let value = parseParams[name] || null
                const type = $el.attr('type')
                switch (type) {
                    case 'checkbox':
                        $el.prop('checked', false)
                        if (Array.isArray(value)) {
                            $el.prop('checked', value.includes($el.val()))
                        } else {
                            $el.prop('checked', !!value)
                        }
                        break
                    default:
                        if ($el.is('[name=max_price]')) {
                            $el.val(value || $el.data('max'))
                        } else if ($el.is('[name=min_price]')) {
                            $el.val(value || $el.data('min'))
                        } else if ($el.val() != value) {
                            $el.val(value)
                        }
                        break
                }

                $el.trigger('change')
            })
        }

        $(document).on('click', '.clear_filter.clear_all_filter', function(e) {
            e.preventDefault()
            changeInputInSearchForm([])
            $formSearch.trigger('submit')
        })

        $(document).on('click', '.clear_filter.bf_icons', function(e) {
            e.preventDefault()
            const $this = $(e.currentTarget)
            let name = $this.data('name')
            let value = $this.data('value')
            let $input
            if (name.substring(name.length - 2) == '[]') {
                $input = $formSearch.find('[name="' + name + '"][value="' + value + '"]')
                switch ($input.attr('type')) {
                    case 'checkbox':
                        $input.prop('checked', false)
                        break
                    default:
                        $input.val(null)
                        break
                }
            } else {
                $input = $formSearch.find('[name="' + name + '"]')
                switch ($input.attr('name')) {
                    case 'min_price':
                        $input.val($input.data('min'))
                        break
                    case 'max_price':
                        $input.val($input.data('max'))
                        break
                    default:
                        $input.val(null)
                        break
                }
            }

            if ($input) {
                $input.trigger('change')
            }

            $formSearch.trigger('submit')
        })

        $(document).on('change', '.product-category-select', function() {
            $('.product-cat-label').text($.trim($(this).find('option:selected').text()))
        })

        $('.product-cat-label').text($.trim($('.product-category-select option:selected').text()))

        $(document).on('click', '.show-advanced-filters', function(event) {
            event.preventDefault()
            event.stopPropagation()

            $(this).toggleClass('active')

            $('.advanced-search-widgets').slideToggle(500)
        })

        function checkHasAnyFilter(formData) {
            if (!formData) {
                formData = $formSearch.serializeArray()
            }
            let filtered = convertFromDataToArray(formData)
            let isFiltering = false
            if (filtered && filtered.length) {
                filtered.map((x) => {
                    let findBy
                    if (x.name.substring(x.name.length - 2) == '[]') {
                        findBy = '[name="' + x.name + '"][value="' + x.value + '"]'
                    } else {
                        findBy = '[name="' + x.name + '"]'
                    }
                    let $input = $formSearch.find(findBy)
                    if ($input.length) {
                        isFiltering = true
                    }
                })
            }

            if ($('.shop-filter-toggle').length) {
                if (isFiltering) {
                    $('.shop-filter-toggle').addClass('is-filtering')
                } else {
                    $('.shop-filter-toggle').removeClass('is-filtering')
                }
            }
        }

        checkHasAnyFilter()

        function convertFromDataToArray(formData) {
            let data = []
            formData.forEach(function(obj) {
                if (obj.value) {
                    // break with price
                    if (['min_price', 'max_price'].includes(obj.name)) {
                        const dataValue = $formSearch.find('input[name=' + obj.name + ']').data(obj.name.substring(0, 3))
                        if (dataValue == parseInt(obj.value)) {
                            return
                        }
                    }
                    data.push(obj)
                }
            })

            return data
        }

        if ($formSearch.length) {
            $(document).on('submit', '#products-filter-ajax', function(event) {
                event.preventDefault()
                const $form = $(event.currentTarget)
                const formData = $form.serializeArray()
                let data = convertFromDataToArray(formData)
                let uriData = []

                const $inputs = $productListing.find('input')
                $inputs.map(function(i, el) {
                    const $input = $(el)
                    if ($input.val()) {
                        const found = data.some(el => el.name === $input.attr('name'))
                        if (!found) {
                            data.push({
                                name: $input.attr('name'),
                                value: $input.val(),
                            })
                        }
                    }
                })

                // Without "_" param
                data.map(function(obj) {
                    uriData.push(encodeURIComponent(obj.name) + '=' + obj.value)
                })

                const nextHref = $form.attr('action') + (uriData && uriData.length ? ('?' + uriData.join('&')) : '')

                // add to params get to popstate not show json
                data.push({ name: '_', value: new Date().getTime() })

                $.ajax({
                    url: $form.attr('action'),
                    type: 'GET',
                    data: data,
                    beforeSend: function() {
                        // Show loading before sending
                        $productListing.find('.list-content-loading').show()
                        if (window.closeShopFilterSection) {
                            window.closeShopFilterSection()
                        }
                        // Animation scroll to filter button
                        let scrollTop = $formSearch.offset().top
                        let $scrollTo = $formSearch.data('scroll-to')
                        if ($scrollTo && $($scrollTo).length) {
                            scrollTop = $($scrollTo).offset().top
                        }

                        if (typeof $formSearch.data('with-header') === 'undefined' || $formSearch.data('with-header')) {
                            scrollTop = scrollTop - $('header').height()
                        }

                        $('html, body').animate({ scrollTop }, 500)
                    },
                    success: (response) => {
                        if (response.error == false) {
                            $productListing.html(response.data)

                            if (response.additional?.filters_html) {
                                if (jQuery().mCustomScrollbar) {
                                    $(document).find('.ps-custom-scrollbar').mCustomScrollbar('destroy')
                                }

                                const $categoriesFilter = $formSearch.find('.product-categories-filter-widget').clone()

                                $formSearch.html(response.additional.filters_html)

                                $formSearch.find('.product-categories-filter-widget').replaceWith($categoriesFilter)

                                if (jQuery().mCustomScrollbar) {
                                    $(document).find('.ps-custom-scrollbar').mCustomScrollbar({
                                        theme: 'dark',
                                        scrollInertia: 0,
                                    })
                                }

                                if ($('.slider-range').length) {
                                    $('.slider-range').map(function(i, el) {
                                        const $this = $(el)
                                        const $parent = $this.closest('.range')
                                        const $min = $parent.find('input.min-range')
                                        const $max = $parent.find('input.max-range')
                                        $this.slider({
                                            range: true,
                                            min: $min.data('min') || 0,
                                            max: $max.data('max') || 500,
                                            values: [$min.val() || 0, $max.val() || 500],
                                            slide: function(event, ui) {
                                                setInputRange($parent, ui.values[0], ui.values[1])
                                            },
                                            change: function(event, ui) {
                                                setInputRange($parent, ui.values[0], ui.values[1])
                                            },
                                        })
                                        setInputRange($parent, $this.slider('values', 0), $this.slider('values', 1))
                                    })
                                }
                            }

                            if (nextHref != window.location.href) {
                                window.history.pushState(data, response.message, nextHref)
                            }
                            checkHasAnyFilter(formData)
                        } else {
                            showError(response.message || 'Opp!')
                        }
                    },
                    error: function(res) {
                        handleError(res)
                    },
                    complete: function() {
                        $productListing.find('.list-content-loading').hide()
                    },
                })
            })

            function setInputRange($parent, min, max) {
                let $filter = $parent.closest('.widget-filter-item')
                let minFormatted = min
                let maxFormatted = max
                if ($filter.length && $filter.data('type') === 'price') {
                    minFormatted = minFormatted.format_price()
                    maxFormatted = maxFormatted.format_price()
                }
                const $from = $parent.find('.from')
                const $to = $parent.find('.to')
                $parent.find('input.min-range').val(min)
                $parent.find('input.max-range').val(max)
                $from.text(minFormatted)
                $to.text(maxFormatted)
            }

            window.addEventListener('popstate', function() {
                let url = window.location.origin + window.location.pathname
                if ($formSearch.attr('action') == url) {
                    const parseParams = parseParamsSearch()
                    changeInputInSearchForm(parseParams)
                    $formSearch.trigger('submit')
                } else {
                    history.back()
                }
            }, false)

            $(document).on('click', '.products-listing .pagination-page a', function(e) {
                e.preventDefault()
                let aLink = $(e.currentTarget).attr('href')

                if (!aLink.includes(window.location.protocol)) {
                    aLink = window.location.protocol + aLink
                }

                let url = new URL(aLink)
                let page = url.searchParams.get('page')
                $productListing.find('input[name=page]').val(page)
                $formSearch.trigger('submit')
            })

            $(document).on('click', '.products_sortby .products_ajaxsortby a', function(e) {
                e.preventDefault()
                const $this = $(e.currentTarget)
                const href = $this.attr('href')
                const $parent = $this.closest('.products_ajaxsortby')
                $parent.find('a.selected').removeClass('selected')
                $this.addClass('selected')
                if (href.indexOf('?') >= 0) {
                    const queryString = href.substring(href.indexOf('?') + 1)
                    if (queryString) {
                        const parse = parseParamsSearch(queryString)
                        $productListing.find('input[name="' + $parent.data('name') + '"]').val(parse[$parent.data('name')])
                    }
                }
                $formSearch.trigger('submit')
            })

            $(document).on('change', '.category-filter-input', event => {

                let _self = $(event.currentTarget)

                let checked = _self.prop('checked')
                $(document).find('.category-filter-input[data-parent-id="' + _self.attr('data-id') + '"]').each((index, el) => {
                    if (checked) {
                        $(el).prop('checked', true)
                    } else {
                        $(el).prop('checked', false)
                    }
                })

                if (parseInt(_self.attr('data-parent-id')) !== 0) {
                    let ids = []
                    let children = $(document).find('.category-filter-input[data-parent-id="' + _self.attr('data-parent-id') + '"]')

                    children.each((i, el) => {
                        if ($(el).is(':checked')) {
                            ids.push($(el).val())
                        }
                    })

                    $(document).find('.category-filter-input[data-id="' + _self.attr('data-parent-id') + '"]').prop('checked', ids.length === children.length)
                }
            })
        }

        const quickSearchProducts = function() {
            const quickSearch = '.form--quick-search'
            const $quickSearch = $('.form--quick-search')
            $('body').on('click', function(e) {
                if (!$(e.target).closest(quickSearch).length) {
                    $('.panel--search-result').removeClass('active')
                }
            })

            let currentRequest = null
            $quickSearch.on('keyup', '.input-search-product', function() {
                const $form = $(this).closest('form')
                ajaxSearchProduct($form)
            })

            $quickSearch.on('change', '.product-category-select', function() {
                const $form = $(this).closest('form')
                ajaxSearchProduct($form)
            })

            $quickSearch.on('click', '.loadmore', function(e) {
                e.preventDefault()
                const $form = $(this).closest('form')
                $(this).addClass('loading')
                ajaxSearchProduct($form, $(this).attr('href'))
            })

            function ajaxSearchProduct($form, url = null) {
                const $panel = $form.find('.panel--search-result')
                const k = $form.find('.input-search-product').val()
                if (!k) {
                    $panel.html('').removeClass('active')
                    return
                }

                $quickSearch.find('.input-search-product').val(k) // update all inputs

                const $button = $form.find('button[type=submit]')
                currentRequest = $.ajax({
                    type: 'GET',
                    url: url || $form.data('ajax-url'),
                    dataType: 'json',
                    data: url ? [] : $form.serialize(),
                    beforeSend: function() {
                        $button.addClass('loading')

                        if (currentRequest != null) {
                            currentRequest.abort()
                        }
                    },
                    success: (response) => {
                        if (!response.error) {
                            if (url) {
                                const $content = $('<div>' + response.data + '</div>')
                                $panel.find('.panel__content').find('.loadmore-container').remove()
                                $panel.find('.panel__content').append($content.find('.panel__content').contents())
                            } else {
                                $panel.html(response.data).addClass('active')
                            }
                        } else {
                            $panel.html('').removeClass('active')
                        }
                    },
                    error: () => {
                    },
                    complete: () => {
                        $button.removeClass('loading')
                    },
                })
            }
        }
        quickSearchProducts()

        const reviewList = function() {
            const $body = $('body')

            let $reviewListWrapper = $body.find('.comment-list')
            const $loadingSpinner = $body.find('.loading-spinner')

            $loadingSpinner.addClass('d-none')

            const fetchData = (url, hasAnimation = false) => {
                $.ajax({
                    url: url,
                    type: 'GET',
                    beforeSend: function() {
                        $loadingSpinner.removeClass('d-none')

                        if (hasAnimation) {
                            $('html, body').animate(
                                {
                                    scrollTop: `${$('.product-reviews-container').offset().top}px`,
                                },
                                1500,
                            )
                        }
                    },
                    success: (response) => {
                        $reviewListWrapper.html(response.data)
                        $('.product-reviews-container .product-reviews-header').html(response.message)

                        let $galleries = $('.product-reviews-container .review-images')
                        if ($galleries.length) {
                            $galleries.map((index, value) => {
                                if (!$(value).data('lightGallery')) {
                                    $(value).lightGallery({
                                        selector: 'a',
                                        thumbnail: true,
                                        share: false,
                                        fullScreen: false,
                                        autoplay: false,
                                        autoplayControls: false,
                                        actualSize: false,
                                    })
                                }
                            })
                        }
                    },
                    complete: function() {
                        $loadingSpinner.addClass('d-none')
                    },
                })
            }

            if ($reviewListWrapper.length < 1) {
                return
            }

            fetchData($reviewListWrapper.data('url'))

            $reviewListWrapper.on('click', '.pagination ul li.page-item a', function(e) {
                e.preventDefault()

                const href = $(this).prop('href')

                if (href === '#') {
                    return
                }

                fetchData(href, true)
            })
        }

        $(document).ready(function() {
            reviewList()

            $(document).on('click', '.product-tabs .nav-item .nav-link:not(.active)', function(e) {
                e.preventDefault()
                const _self = $(e.currentTarget)

                const $tabContent = _self.closest('.product-tabs')

                $tabContent.find('.nav-item .nav-link').removeClass('active')

                _self.addClass('active')

                const $loading = $tabContent.find('.loading-spinner')

                const $productList = $tabContent.find('.tab-content .tab-pane .row')

                $productList.html('')

                $loading.removeClass('d-none')

                $.ajax({
                    url: _self.data('url'),
                    method: 'GET',
                    success: (response) => {

                        if (response.error) {
                            window.showAlert('alert-danger', response.message)
                            return false
                        }

                        $productList.html(response.data)

                        $loading.addClass('d-none')
                    },
                    error: (response) => {
                        window.showAlert('alert-danger', response.message)
                    },
                })
            })

            $(document).on('change', '#products-filter-ajax select, input', () => {
                $('#products-filter-ajax').trigger('submit')
            })
        })
    })

})(jQuery)
