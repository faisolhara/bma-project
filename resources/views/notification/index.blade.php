@extends('layouts.master')

@section('title', trans('menu.notification'))

@section('header')
@parent
<style type="text/css">
    tr.unread td { font-weight: bold; background-color: #eee; }
    #notifications tbody tr { cursor: pointer; }
</style>
@endsection

<?php 
	use App\Service\PaginatorService;
?>

@section('content')
<div class="be-content">
	<div class="main-content container-fluid">
	@parent
		<div class="row">
	        <div class="col-sm-12">
	          <div class="panel panel-default panel-border-color panel-border-color-primary">
	            <div class="panel-heading panel-heading-divider">{{ trans('common.view') }}<span class="panel-subtitle">{{ trans('menu.notification') }}</span></div>
	            <div class="panel-body">
	              <form class="form-horizontal" action="{{ url('notification') }}" method="POST" id="form-add" enctype="multipart/form-data" >
                    {{ csrf_field() }}
		            <input id="employee_id" name="employee_id" type="hidden" value="{{ count($errors) > 0 ? old('employee_id') : -1 }}">
	        		<div class="col-sm-6">
		                <div class="form-group {{ $errors->has('notification_title') ? 'has-error' : '' }}">
		                  <label for="notification_title" class="col-sm-4 control-label">{{ trans('fields.title') }} *</label>
		                  <div class="col-sm-8">
		                    <input id="notification_title" name="notification_title" type="text"  class="form-control input-sm" value="{{ !empty($filters['notification_title']) ? $filters['notification_title'] : '' }}" maxlength="50">
		                    @if($errors->has('notification_title'))
                            <span class="help-block">{{ $errors->first('notification_title') }}</span>
                            @endif
		                  </div>
		                </div>
		                <div class="form-group {{ $errors->has('notification_desc') ? 'has-error' : '' }}">
		                  <label for="notification_desc" class="col-sm-4 control-label">{{ trans('fields.message') }} *</label>
		                  <div class="col-sm-8">
		                    <input id="notification_desc" name="notification_desc" type="text"  class="form-control input-sm" value="{{ !empty($filters['notification_desc']) ? $filters['notification_desc'] : '' }}" maxlength="50">
		                    @if($errors->has('notification_desc'))
                            <span class="help-block">{{ $errors->first('notification_desc') }}</span>
                            @endif
		                  </div>
		                </div>
	        			<div class="form-group">
	                        <label class="col-sm-4 control-label">{{ trans('fields.date-from') }}</label>
	                        <div class="col-md-8">
	                          <div data-min-view="2" data-date-format="dd-mm-yyyy" class="input-group date datetimepicker">
	                            <input size="16" name="date_from" id="date_from" type="text" value="{{ !empty($filters['date_from']) ? $filters['date_from'] : '' }}" class="form-control input-sm" readonly>
	                            <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar" ></i></span>
	                          </div>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-4 control-label">{{ trans('fields.date-to') }}</label>
	                        <div class="col-md-8">
	                          <div data-min-view="2" data-date-format="dd-mm-yyyy" class="input-group date datetimepicker">
	                            <input size="16" name="date_to" id="date_to" type="text" value="{{ !empty($filters['date_to']) ? $filters['date_to'] : '' }}" class="form-control input-sm" readonly>
	                            <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar" ></i></span>
	                          </div>
	                        </div>
	                    </div>
		            </div>
	        		<div class="col-sm-6">
	        		</div>
	                <div class="row sm-pt-15">
	                    <div class="col-sm-12">
	                        <div class="text-right">
	                          <button type="submit" class="btn btn-space btn-primary"><i class="icon mdi mdi-search"></i> {{ trans('common.search') }}</button>
	                        </div>
	                 	</div>
	                </div>
	                <div class="row sm-pt-15">
	                	<table class="table table-condensed table-hover table-bordered" id="notifications">
		                    <thead>
		                      <tr>
		                        <th width="2%">{{ trans('fields.number') }}</th>
		                        <th width="15%">{{ trans('fields.title') }}</th>
		                        <th width="35%">{{ trans('fields.message') }}</th>
		                        <th width="33%">{{ trans('fields.description') }}</th>
		                        <th width="15%">{{ trans('fields.date') }}</th>
		                      </tr>
		                    </thead>
		                    <tbody>
                               <?php $no = ($notifications->currentPage() - 1) * $notifications->perPage() + 1; ?>
		                      @foreach($notifications as $notification)
		                      <tr class="{{ empty($notification['is_read'] == 'N') ? 'unread' : '' }}" data-id="{{ $notification['complaint_id'] }}">
		                        <td class="text-center">{{ $no++ }}</td>
		                        <td>{{ $notification['notification_title'] }}</td>
		                        <td>{{ $notification['notification_desc'] }}</td>
		                        <td>{{ trans('common.complaint-message', ['complaint_id' => $notification['complaint_id'], 'room_name' => $notification['room_name'], 'technician' => $notification['technician_name'] ]) }}</td>
		                        <td>{{ $notification['creation_date'] }}</td>
		                      </tr>
		                      @endforeach
		                    </tbody>
		                  </table>
	                </div>
	                {!! $notifications->withPath('notification')->links() !!}
	              </form>	
	            </div>
	          </div>
	        </div>
      	</div>
	</div>
</div>
@endsection


@section('script')
@parent
<script src="{{ asset('assets/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/app-form-elements.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>


<script type="text/javascript">
  $(document).ready(function(){
  	setInterval(function(){
        getNotifications();
    }, 10000);
  	
  	//initialize the javascript
  	App.init();
  	App.formElements();

  	$('#notifications tbody tr').on('click', function() {
        var id = $(this).data('id');
        window.location.href = '{{ URL('notification/read') }}/' + id;
    });
});

</script>
@endsection