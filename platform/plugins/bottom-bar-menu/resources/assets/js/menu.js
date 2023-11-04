$(document).ready(function () {
    let navbarTrigger = $('.trigger-mobile-menu'),
        endTrigger = $('.mobile-menu-close'),
        container = $('.mobile-header-active'),
        wrapper4 = $('body');

    wrapper4.prepend('<div class="body-overlay-1"></div>');

    navbarTrigger.on('click', function (e) {
        e.preventDefault();
        container.addClass('sidebar-visible');
        wrapper4.addClass('mobile-menu-active');
    });

    endTrigger.on('click', function () {
        container.removeClass('sidebar-visible');
        wrapper4.removeClass('mobile-menu-active');
    });

    $('.body-overlay-1').on('click', function () {
        container.removeClass('sidebar-visible');
        wrapper4.removeClass('mobile-menu-active');
    });
});
