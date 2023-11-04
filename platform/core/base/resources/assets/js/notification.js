const AdminNotification = function () {
    const http = $httpClient.clone()

    const $loadingNotification = $('#loading-notification')
    const $sidebarNotification = $('#notification-sidebar')
    const $adminNotification = $('#admin-notification')
    const $backdropNotification = $('#sidebar-notification-backdrop')
    const $listNotification = $('.list-item-notification')

    http.beforeSend(() => $loadingNotification.show())

    http.completed(() => $loadingNotification.hide())

    $(document).on('click', '#open-notification', function (e) {
        e.preventDefault()
        $sidebarNotification.addClass('active')
        $adminNotification.find('.current-page').val(1)

        $backdropNotification.addClass('sidebar-backdrop')

        http.make()
            .get($(this).prop('href'))
            .then(({ data }) => {
                if ($(data).hasClass('no-data-notification')) {
                    $adminNotification.find('.action-notification').hide()
                    $adminNotification.find('.title-notification-heading').hide()
                }

                $backdropNotification.addClass('sidebar-backdrop')

                $listNotification.html(data)
            })
    })

    $(document).on('click', '#sidebar-notification-backdrop', function (e) {
        const notificationSidebar = document.getElementById('notification-sidebar')
        const openNotificationSidebar = document.getElementById('open-notification')
        const adminNotification = document.getElementById('admin-notification')

        let targetEl = e.target
        if (targetEl.parentNode !== openNotificationSidebar && targetEl.parentNode !== adminNotification) {
            do {
                if (targetEl === notificationSidebar) {
                    return
                }
                targetEl = targetEl.parentNode
            } while (targetEl)
            $backdropNotification.removeClass('sidebar-backdrop')
            $sidebarNotification.removeClass('active')
        }
    })

    $($adminNotification).on('click', '#close-notification', function (e) {
        e.preventDefault()

        $backdropNotification.removeClass('sidebar-backdrop')
        $sidebarNotification.removeClass('active')
    })

    $($adminNotification).on('click', '.mark-read-all', function (e) {
        e.preventDefault()

        http.make()
            .put($(this).prop('href'))
            .then(() => {
                $('.list-group-item').addClass('read')
                updateNotificationsCount()
            })
    })

    $($adminNotification).on('click', '.delete-all-notifications', function (e) {
        e.preventDefault()

        http.make()
            .delete($(this).attr('href'))
            .then(({ data }) => {
                $sidebarNotification.html(data)
                $adminNotification.find('.action-notification').hide()
                $adminNotification.find('.title-notification-heading').hide()
                updateNotificationsCount()
            })
    })

    $($adminNotification).on('click', '.view-more-notification', function (e) {
        e.preventDefault()

        const pageNow = $adminNotification.find('.current-page').val()
        let nextPage = parseInt(pageNow) + 1

        $(this).hide()

        http.make()
            .get($(this).prop('href'), { page: nextPage })
            .then(({ data }) => {
                $adminNotification.find('.current-page').val(nextPage++)
                $listNotification.append(data)
            })
    })

    $($adminNotification).on('click', '.btn-delete-notification', function (e) {
        e.preventDefault()

        http.make()
            .delete($(this).attr('href'))
            .then(({ data }) => {
                $(this).closest('li.list-group-item').fadeOut(500).remove()

                updateItems()

                updateNotificationsCount()

                if (data.view) {
                    $sidebarNotification.html(data.view)
                    $('p.action-notification').hide()
                    $('h2.title-notification-heading').hide()
                }
            })
    })

    $($adminNotification).on('click', '.show-more-description', function (e) {
        e.preventDefault()

        $(`.show-less-${$(this).data('id')}`).show()
        $(this).hide()
        $(`.${$(this).data('class')}`).text($(this).data('description'))
    })

    $($adminNotification).on('click', '.show-less-description', function (e) {
        e.preventDefault()

        $(`.show-more-${$(this).data('id')}`).show()
        $(this).hide()
        $(`.${$(this).data('class')}`).text($(this).data('description'))
    })

    function updateNotificationsCount() {
        const countNotifications = $('#open-notification')

        http.make()
            .get(countNotifications.data('href'))
            .then(({ data }) => {
                countNotifications.html(data)
            })
    }

    function updateItems() {
        const pageNow = $adminNotification.find('.current-page').val()

        http.make()
            .get($('#open-notification').prop('href'), { page: pageNow })
            .then(({ data }) => {
                $listNotification.html(data)
            })
    }
}

$(document).ready(function () {
    AdminNotification()
})
