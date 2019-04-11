    <script>
      var playerId = 0;
      var OneSignal = window.OneSignal || [];
      OneSignal.push(["init", {
        appId: "4f1197a9-007a-4fd6-bdf0-e2763290d911",
        autoRegister: false,
        notifyButton: {
          enable: true, /* Set to false to hide */
          showCredit: false,
          text: {
            'tip.state.unsubscribed'      : '{{ trans("common.tip-state-unsubscribed") }}',
            'tip.state.subscribed'        : '{{ trans("common.tip-state-subscribed") }}',
            'tip.state.blocked'           : '{{ trans("common.tip-state-blocked") }}',
            'message.prenotify'           : '{{ trans("common.message-prenotify") }}',
            'message.action.subscribed'   : '{{ trans("common.message-action-subscribed") }}',
            'message.action.resubscribed' : '{{ trans("common.message-action-resubscribed") }}',
            'message.action.unsubscribed' : '{{ trans("common.message-action-unsubscribed") }}',
            'dialog.main.title'           : '{{ trans("common.dialog-main-title") }}',
            'dialog.main.button.subscribe': '{{ trans("common.dialog-main-button-subscribe") }}',
            'dialog.main.button.unsubscribe'    : '{{ trans("common.dialog-main-button-unsubscribe") }}',
            'dialog.blocked.title'        : '{{ trans("common.dialog-blocked-title") }}',
            'dialog.blocked.message'      : '{{ trans("common.dialog-blocked-message") }}'
          }
        }
      }]);

      OneSignal.push(function() {
        OneSignal.deleteTag("USER_TYPE");
        OneSignal.deleteTag("DEPT_ID");

        /* These examples are all valid */
        OneSignal.sendTag("USER_TYPE", "{{ \Session::get('user')['user_type'] }}");
        OneSignal.sendTag("DEPT_ID", "{{ \Session::get('user')['dept_id'] }}");
        
        if(OneSignal.isPushNotificationsEnabled() && '{{ Request::is("dashboard") }}'){
          OneSignal.getUserId(function(userId) {
            $.ajax({
                url: '{{ url('/set-player-id-employee') }}', 
                type: "POST",
                data: { player_id : userId, "_token": "{{ csrf_token() }}" }, 
                success: function(result){
                  console.log(result);
                },
            });
          });
        }
      });

    </script>