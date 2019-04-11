@extends('layouts.master')

@section('title', trans('menu.view-suggest'))

@section('content')
<div class="be-content">
	<div class="main-content container-fluid">
	@parent
		<div class="row">
	        <div class="col-sm-12">
	          <div class="panel panel-default panel-border-color panel-border-color-primary">
	            <div class="panel-heading panel-heading-divider">{{ trans('common.view') }}<span class="panel-subtitle">{{ trans('menu.view-suggest') }}</span></div>
	            <div class="panel-body">
                <form class="form-horizontal" action="{{ url('view-suggest') }}" method="POST" id="form-add">
                  {{ csrf_field() }}
                  <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">{{ trans('common.start-date') }}</label>
                        <div class="col-md-8">
                          <div data-min-view="2" data-date-format="dd-M-yyyy" class="input-group date datetimepicker">
                            <input size="16" name="start_date" id="start_date" type="text" value="{{ $startDateFilter }}" class="form-control input-sm" readonly>
                            <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar" ></i></span>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">{{ trans('common.end-date') }}</label>
                        <div class="col-md-8">
                          <div data-min-view="2" data-date-format="dd-M-yyyy" class="input-group date datetimepicker">
                            <input size="16" name="end_date" id="end_date" type="text" value="{{ $endDateFilter }}" class="form-control input-sm" readonly>
                            <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar" ></i></span>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="row xs-pt-15">
                    <div class="col-xs-12">
                      <p class="text-right">
                        <button type="submit" class="btn btn-space btn-primary"><i class="icon mdi mdi-mail-save"></i> {{ trans('common.filter') }}</button>
                      </p>
                    </div>
                  </div>
                </form>
                <div class="col-sm-12">
                    <div class="form-group table-responsive">
                      <table id="table1" class="table table-striped table-hover table-fw-widget">
                          <thead>
                            <tr>
                              <th>{{ trans('common.suggest-date') }}</th>
                              <th>{{ trans('common.room') }}</th>
                              <th>{{ trans('common.full-name') }}</th>
                              <th>{{ trans('common.suggest') }}</th>
                              <th>{{ trans('common.description') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($dataSuggest as $option)
                              <tr>
                                <td>{{ $option['creation_date'] }}</td>
                                <td>{{ $option['room_name']}}</td>
                                <td>{{ $option['tenant_name']}}</td>
                                <td>{{ $option['suggest_name']}}</td>
                                <td>{{ $option['suggest_desc']}}</td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                  </div>
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


<script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/app-tables-datatables.js') }}" type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function(){
    setInterval(function(){
        getNotifications();
    }, 10000);
    
    App.init();
    App.formElements();
    App.dataTables();

    
});

</script>
@endsection