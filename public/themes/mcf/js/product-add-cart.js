$(document).ready(function () {
    $('.i-datepicker').each(function () {
        var $icon = $(this).find('.fi-rs-calendar');
        var $input = $(this).find('input');
        $input.datepicker({
            language: 'tr',
            dateFormat: 'yyyy/mm/dd',
            startDate: new Date(),
            minDate: new Date(),
            onSelect: function (fd, d, picker) {
                $('[data-date-value]').removeClass('active')
                $('[data-date-value=' + fd.replaceAll('/', '-') + ']').addClass('active')
                $("#shipping_date").val(fd.replaceAll('/', '-'))
                $('#add-cart-times').show();
            },
            onShow: function () {
                $icon.data('show', 1);
            },
            onHide: function () {
                $icon.data('show', 0);
            }
        });
        $icon.on('click', function() {
            if ($(this).data('show') !== 1)
                $input.data('datepicker').show() && $icon.data('show', 1);
            else
                $input.data('datepicker').hide() && $icon.data('show', 0);

        });
    })
    $('.date-item').on('click',function () {
        if (!$(this).hasClass('nochek')) {
            var val = $(this).data('date-value');
            $('[data-date-value]').removeClass('active')
            $('[data-date-value=' + val + ']').addClass('active')
            $("#shipping_date").val(val)
            $('#add-cart-times').show();
        }
    })
    $("[name=shipping_date]").on('change', function () {
        $('[data-date-value]').removeClass('active')
        $('[data-date-value=' + $(this).val() + ']').addClass('active')
    })
    $('.time-item').on('click',function () {
        if (!$(this).hasClass('nochek')) {
            var val = $(this).data('index');
            $('[data-index]').removeClass('active')
            $('[data-index=' + val + ']').addClass('active')
            $("[name=shipping_time]").val(val)
        }
    })

    $('#add-cart-dates').hide();
    $('#add-cart-times').hide();
    $('#shipping_location').change(function () {
        if ($(this).val()) {
            $('#add-cart-dates').show();
            if ($('#shipping_date').val()) {
                $('#add-cart-times').show();
            }else {
                $('#add-cart-times').hide();
            }
        }else {
            $('#add-cart-dates').hide();
            $('#add-cart-times').hide();
        }
    })
    $('#shipping_date').change(function () {
        if ($('#shipping_date').val()) {
            $('#add-cart-times').show();
        }else {
            $('#add-cart-times').hide();
        }
    })
    $('[data-using-select2=true]').each(function () {
        $(this).select2()
    })
})
