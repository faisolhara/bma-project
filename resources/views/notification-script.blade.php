<script type="text/javascript">
$(document).on('ready', function() {

    /** NOTIFICATIONS **/
    setInterval(function(){
        getNotifications();
    }, 10000);
});

var lastid;
var templastid;

var getNotifications = function() {
    $.ajax({
        url: '{{ URL('/notification/get-notification') }}',
        type: "POST",
        data: {lastid: lastid, "_token": "{{ csrf_token() }}"},
    }).done(function(data) {
        var count = data.count;
        var $count = $('.notification-badge').html(count > 0 ? count : '');
        var $ul = $('#list-notification');

        $count.html(count > 0 ? count : '');
        $ul.html('');
        first = true;
        data.notifications.forEach(function(notification) {
            if(first){
                lastid     = notification.notification_id;
                templastid = notification.templastid;
                first = false;
                if(templastid != 0 && lastid > templastid){
                    var audio = new Audio("{{ asset('assets/audio/tone1.mp3') }}");
                    audio.play();
                }
            }
            $ul.append(
                '<li class="notification notification-unread">\
                  <a href="{{ url("/notification/read/") }}'+ '/' + notification.complaint_id +'" style="color: #404953 !important;">\
                      <div class="text"><strong>'+ notification.notification_title + '</strong> <br>'+ notification.notification_desc + '</div><span class="date">'+ notification.creation_date + '</span>\
                  </a>\
                </li>'
            );
        });
    });
};
</script>