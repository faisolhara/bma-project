@extends('layouts.master')

@section('title', trans('menu.dashboard'))

@section('script')
	@parent
	<script src="{{ asset('assets/lib/jquery-flot/jquery.flot.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/jquery-flot/jquery.flot.pie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/jquery-flot/jquery.flot.resize.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/jquery-flot/plugins/jquery.flot.orderBars.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/jquery-flot/plugins/curvedLines.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/jquery.sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/countup/countUp.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/jqvmap/jquery.vmap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/jqvmap/maps/jquery.vmap.world.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/app-dashboard.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	setInterval(function(){
	        getNotifications();
	    }, 10000);
	      	
        //initialize the javascript
        App.init();
        App.dashboard();

        var lastid;
        var templistid;
        var xhrDashboard;

        setInterval(function(){
	      if(xhrDashboard && xhrDashboard.readyState != 4){
		        xhrDashboard.abort();
		    }
		    xhrDashboard = $.ajax({
		        url : '{{ url('/json/get-hist-trans') }}',
		        type: "POST",
		        data: {lastid: lastid, "_token": "{{ csrf_token() }}"},
		        success: function(data) {
		        	if(!data){
		        		return;
		        	}
		            first = true;
		            data['data'].forEach(function(item) {
				        if(first){
					      	var audio = new Audio("{{ asset('assets/audio/tone1.mp3') }}");
					        audio.play();
						  	first = false;
			            }	
		 				if(item.complaint_hist_status == 'OPEN') {
		 					$message =  '[' + item.complaint_hist_status + '] : Kamar ' + item.room_name + ' atas nama ' + item.first_name_tenant + ' ' + item.last_name_tenant + ' dapat segera dikerjakan] \n';
		 					if(item.available_start_date && item.available_start_date){
		 						$message = '[' + item.complaint_hist_status + '] : Kamar ' + item.room_name + ' atas nama ' + item.first_name_tenant + ' ' + item.last_name_tenant + ' dapat dikerjakan antara ' + item.available_start_date + ' sampai ' + item.available_end_date + ' --> [' + item.creation_date + '] \n';
		 					}
							$('#logging').append(
			                	$message
			                );
						} else if(item.complaint_hist_status == 'INSPECTING') {
		 					$('#logging').append(
			                	'[' + item.complaint_hist_status + '] : Kamar ' + item.room_name + ' atas nama ' + item.first_name_tenant + ' ' + item.last_name_tenant + ' diinspeksi oleh ' + item.first_employee_name + ' ' + item.last_employee_name + ' --> [' + item.creation_date + '] \n'
			                );	 					
		 				} else if(item.complaint_hist_status == 'COSTING') {
		 					$message = '[' + item.complaint_hist_status + '] : Kamar ' + item.room_name + ' atas nama ' + item.first_name_tenant + ' ' + item.last_name_tenant + ' telah di periksa dan belum ada biaya tambahan --> [' + item.creation_date + '] \n';
		 					if(item.complaint_cost){
		 						$message = '[' + item.complaint_hist_status + '] : Kamar ' + item.room_name + ' atas nama ' + item.first_name_tenant + ' ' + item.last_name_tenant + ' dikenakan biaya sebesar Rp. ' + item.complaint_cost + ' --> [' + item.creation_date + '] \n';
		 					}
		 					$('#logging').append(
			                	$message
			                );
			            } else if(item.complaint_hist_status == 'WAITING APPROVAL') {
		 					$('#logging').append(
			                	'[' + item.complaint_hist_status + '] : Menunggu approval dari kamar ' + item.room_name + ' atas nama ' + item.first_name_tenant + ' ' + item.last_name_tenant + ' --> [' + item.creation_date + '] \n'
			                );
			            } else if(item.complaint_hist_status == 'APPROVED') {
		 					$('#logging').append(
			                	'[' + item.complaint_hist_status + '] : Telah Approved dari Kamar ' + item.room_name + ' atas nama ' + item.first_name_tenant + ' ' + item.last_name_tenant + ' --> [' + item.creation_date + '] \n'
			                );
			            } else if(item.complaint_hist_status == 'PROGRESS') {
		 					$('#logging').append(
			                	'[' + item.complaint_hist_status + '] : Kamar ' + item.room_name + ' atas nama ' + item.first_name_tenant + ' ' + item.last_name_tenant + ' dikerjakan oleh ' + item.first_employee_name + ' ' + item.last_employee_name + ' --> [' + item.creation_date + '] \n'
			                );
		 				}  else if(item.complaint_hist_status == 'DONE') {
		 					$complaint_rate = !item.complaint_rate ? 0 : item.complaint_rate; 
		 					$message = '[' + item.complaint_hist_status + '] : Kamar ' + item.room_name + ' atas nama ' + item.first_name_tenant + ' ' + item.last_name_tenant + ' selesai dikerjakan --> [' + item.creation_date + '] \n';
		 					if(item.complaint_rate){
		 						$message = '[' + item.complaint_hist_status + '] : Kamar ' + item.room_name + ' atas nama ' + item.first_name_tenant + ' ' + item.last_name_tenant + ' selesai dikerjakan dengan penilaian ' + $complaint_rate + ' bintang, note : ' + item.complaint_note + ' --> [' + item.creation_date + '] \n';
		 					}
		 					$('#logging').append(
			                	$message
			                );
		 				} else if(item.complaint_hist_status == 'CANCEL') {
		 					$('#logging').append(
			                	'[' + item.complaint_hist_status + '] : Kamar ' + item.room_name + ' atas nama ' + item.first_name_tenant + ' ' + item.last_name_tenant + ' di cancel karena  ' + item.cancel_note  + ' --> [' + item.creation_date + '] \n'
			                );
		 				} else if(item.complaint_hist_status == 'REJECT') {
		 					$('#logging').append(
			                	'[' + item.complaint_hist_status + '] : Kamar ' + item.room_name + ' atas nama ' + item.first_name_tenant + ' ' + item.last_name_tenant + ' di reject' + ' --> [' + item.creation_date + '] \n'
			                );
		 				}
		                lastid     = item.complaint_hist_id;

		                $('#logging').scrollTop($('#logging')[0].scrollHeight);   
		            });

		            if (typeof(callback) == 'function') {
		                callback();
		            }
		        }
		    });
			
			


	    },7000);  // run every 7 seconds


      });
    </script>
@endsection

@section('content')
<div class="be-content">
	<div class="main-content container-fluid">
	@parent
	  <div class="row">
	    <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="widget widget-tile">
              <div id="spark1" class="chart sparkline"></div>
              <div class="data-info">
                <div class="desc">{{ trans('fields.total-complaint-complete-today') }}</div>
                <div class="value"><span class="indicator indicator-equal mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="{{ $data['totalCompleteToday'] }}" class="number">0</span>
                </div>
              </div>
            </div>
	    </div>
	    <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="widget widget-tile">
              <div id="spark2" class="chart sparkline"></div>
              <div class="data-info">
                <div class="desc">{{ trans('fields.total-complaint-progress') }}</div>
                <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-up"></span><span data-toggle="counter" data-end="{{ $data['totalProgress'] }}" class="number">0</span>
                </div>
              </div>
            </div>
	    </div>
	    <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="widget widget-tile">
              <div id="spark3" class="chart sparkline"></div>
              <div class="data-info">
                <div class="desc">{{ trans('fields.total-complaint-outstanding') }}</div>
                <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-up"></span><span data-toggle="counter" data-end="{{ $data['totalOutstanding'] }}" class="number">0</span>
                </div>
              </div>
            </div>
	    </div>
	    <div class="col-xs-12 col-md-6 col-lg-3">
	        <div class="widget widget-tile">
	          <div id="spark4" class="chart sparkline"></div>
	          <div class="data-info">
	            <div class="desc">{{ trans('fields.total-unread-notification') }}</div>
	            <div class="value"><span class="indicator indicator-negative mdi mdi-chevron-down"></span><span data-toggle="counter" data-end="{{ $data['totalUnreadNotification'] }}" class="number">0</span>
	            </div>
	          </div>
	        </div>
	    </div>
	  </div>
	  <div class="row">
	  	<div class="col-xs-12 col-md-12">
	      <div class="panel panel-default">
	        <div class="panel-heading panel-heading-divider xs-pb-15">Activity Logs</div>
	        <div class="panel-body xs-pt-25">
	          <div class="row user-progress user-progress-small">
	            <div class="col-md-12"><span class="title"> <textarea class="form-control input-sm" name="logging" id="logging" style="resize:none; height: auto !important;" cols="550" rows="20" readonly></textarea></span></div>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</div>
@endsection