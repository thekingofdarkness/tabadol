function fetchNotifications(id) {
    $.ajax({
        url: '{{ route("notifications.get") }}',
        method: 'GET',
        success: function(response) {
            $(id).html(response.html);
        },
        error: function(response) {
            console.error('Error:', response);
        }
    });
}
