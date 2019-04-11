@extends('layouts.master')

@section('title', trans('menu.master-department'))

@section('header')
@parent
<style type="text/css">
    #table-lov-department-type tbody tr{
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="be-content">
  <div class="main-content container-fluid">
  @parent
    <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
              <div class="panel-heading panel-heading-divider">{{ trans('common.add-or-edit') }}<span class="panel-subtitle">{{ trans('menu.master-department') }}</span></div>
              <div class="panel-body">
                <form class="form-horizontal" action="{{ url('master-department/save') }}" method="POST" id="form-add">
                    {{ csrf_field() }}
                <input id="dept_id" name="dept_id" type="hidden" value="{{ count($errors) > 0 ? old('dept_id') : -1 }}">
	                <div class="row xs-pt-15">
	                  <div class="col-xs-12">
	                    <p class="text-right">
	                      <a class="btn btn-space btn-warning" href="{{ url('/master-department') }}"><i class="icon mdi mdi-mail-reply"></i> {{ trans('common.clear-form') }}</a>
	                      <button type="submit" class="btn btn-space btn-primary"><i class="icon mdi mdi-save"></i> {{ trans('common.save') }}</button>
	                    </p>
	                  </div>
	                </div>
                  <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('dept_name') ? 'has-error' : '' }}">
                      <label for="dept_name" class="col-sm-4 control-label">{{ trans('fields.department-name') }} *</label>
                        <div class="col-md-8">
                            <div data-min-view="2" class="input-group">
                              <input id="dept_name" name="dept_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('dept_name') : '' }}" maxlength="50"><span data-toggle="modal" data-target="#modal-dept-name" class="input-group-addon btn btn-primary" id="btn-first-name"><i class="icon-th mdi mdi-search"></i></span>
                            </div>
                            @if($errors->has('dept_name'))
                              <span class="help-block">{{ $errors->first('dept_name') }}</span>
                              @endif
                         </div>
                    </div>
                      <div class="form-group {{ $errors->has('dept_desc') ? 'has-error' : '' }}">
                        <label class="col-sm-4 control-label">{{ trans('fields.description') }} *</label>
                        <div class="col-sm-8">
                          <textarea style="overflow:auto;resize:none; height: auto !important;" rows="5" class="form-control input-sm" name="dept_desc" id="dept_desc" maxlength="100">{{ count($errors) > 0 ? old('dept_desc') : '' }}</textarea>
                          @if($errors->has('dept_desc'))
                              <span class="help-block">{{ $errors->first('dept_desc') }}</span>
                          @endif
                        </div>
                      </div>
                      <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                        <label class="col-sm-4 control-label"></label>
                        <div class="col-sm-8">
                          <?php $isActive = count($errors) > 0 ? old('is_active') : 'Y'; ?>
                          <div class="be-checkbox be-checkbox-color inline">
                            <input id="is_active" value="Y" name='is_active' type="checkbox" {{ $isActive == 'Y' ? 'checked' : '' }}>
                            <label for="is_active">{{ trans('fields.active') }}</label>
                          </div>
                          @if($errors->has('is_active'))
                              <span class="help-block">{{ $errors->first('is_active') }}</span>
                          @endif
                        </div>
                      </div>
                  </div>
	              </form>
	            </div>
	          </div>
	        </div>
      	</div>
	</div>
</div>
@endsection

@section('modal')
<!--Form Modals-->
<div id="modal-dept-name" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.department-lov') }}</h3>
      </div>
      <div class="modal-body table-responsive">
        <div class="form-group">
          <label>{{ trans('fields.unit-type') }}</label>
          <input type="text" id="searchDepartment" name="searchDepartment" class="form-control">
        </div>
        <table id="table-lov-department-type" class="table table-striped table-hover table-bordered table-fw-widget data-table">
            <thead>
              <tr>
                <th>{{ trans('fields.unit-type') }}</th>
                <th>{{ trans('fields.description') }}</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
        </table>
        </div>
      	<div class="modal-footer">
	        <button type="button" data-dismiss="modal" class="btn btn-warning md-close">{{ trans('common.cancel') }}</button>
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
    
  	//initialize the javascript
  	App.init();
  	App.formElements();
    
    $dataTableDepartment = $("#table-lov-department-type").DataTable({
      "aaSorting": [],
      pageLength: 10,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
              "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

  	$('#searchDepartment').on('keyup', loadLovDepartment);
    $('#table-lov-department-type tbody').on('click', 'tr', selectDepartment);

    loadLovDepartment();
});

var xhrUsername;
var loadLovDepartment = function(callback) {
    if(xhrUsername && xhrUsername.readyState != 4){
        xhrUsername.abort();
    }
    xhrUsername = $.ajax({
        url : '{{ url('/json/get-department') }}',
        type: "POST",
        data: {searchDepartment: $('#searchDepartment').val(), limit: 100, "_token": "{{ csrf_token() }}"},
        success: function(data) {
          $dataTableDepartment.clear().draw();
          data['data'].forEach(function(item) {
            $dept_name = !item.dept_name ? '' : item.dept_name;
            $dept_desc = !item.dept_desc ? '' : item.dept_desc;
            var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                            <td>' + $dept_name + '</td>\
                            <td>' + $dept_desc + '</td>\
                        </tr>';

            $dataTableDepartment.row.add( $(htmlTr)[0] ).draw( false );
          });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var selectDepartment = function() {
    var data = $(this).data('json');
    $('#dept_id').val(data.dept_id);
    $('#dept_name').val(data.dept_name);
    $('#dept_desc').val(data.dept_desc);

    if(data.is_active == 'Y'){
      $('#is_active').prop('checked', true);
    }else{
      $('#is_active').prop('checked', false);
    }

    $('#modal-dept-name').modal('hide');
    $('#searchDepartment').val('');
};

</script>
@endsection