@extends('layouts.master')

@section('title', trans('menu.master-subunit'))

@section('header')
@parent
<style type="text/css">
    #table-lov-subunit-type tbody tr{
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
              <div class="panel-heading panel-heading-divider">{{ trans('common.add-or-edit') }}<span class="panel-subtitle">{{ trans('menu.master-subunit') }}</span></div>
              <div class="panel-body">
                <form class="form-horizontal" action="{{ url('master-subunit/save') }}" method="POST" id="form-add">
                    {{ csrf_field() }}
                <input id="subunit_id" name="subunit_id" type="hidden" value="{{ count($errors) > 0 ? old('subunit_id') : -1 }}">
                  <div class="row xs-pt-15">
                    <div class="col-xs-12">
                      <p class="text-right">
                        <a class="btn btn-space btn-warning" href="{{ url('/master-subunit') }}"><i class="icon mdi mdi-mail-reply"></i> {{ trans('common.clear-form') }}</a>
                        <button type="submit" class="btn btn-space btn-primary"><i class="icon mdi mdi-save"></i> {{ trans('common.save') }}</button>
                      </p>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('subunit_name') ? 'has-error' : '' }}">
                      <label for="subunit_name" class="col-sm-4 control-label">{{ trans('fields.subunit-name') }} *</label>
                        <div class="col-md-8">
                            <div data-min-view="2" class="input-group">
                              <input id="subunit_name" name="subunit_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('subunit_name') : '' }}" maxlength="50"><span data-toggle="modal" data-target="#modal-subunit-type" class="input-group-addon btn btn-primary" id="btn-first-name"><i class="icon-th mdi mdi-search"></i></span>
                            </div>
                            @if($errors->has('subunit_name'))
                              <span class="help-block">{{ $errors->first('subunit_name') }}</span>
                              @endif
                         </div>
                    </div>
                      <div class="form-group {{ $errors->has('dept_id') ? 'has-error' : '' }}">
                        <label class="col-sm-4 control-label ">{{ trans('fields.department') }} *</label>
                        <div class="col-sm-8">
                          <?php $deptId = count($errors) > 0 ? old('dept_id') : null; ?>
                          <select class="form-control input-sm" name="dept_id" id="dept_id">
                            <option value="">{{ trans('common.please-select') }}</option>
                          @foreach($departmentOption as $option)
                            <option value="{{ $option['dept_id'] }}" {{ $deptId == $option['dept_id'] ? 'selected' : '' }}>{{ $option['dept_name'] }}</option>
                          @endforeach
                          </select>
                          @if($errors->has('dept_id'))
                              <span class="help-block">{{ $errors->first('dept_id') }}</span>
                          @endif
                        </div>
                      </div>
                      <div class="form-group {{ $errors->has('subunit_desc') ? 'has-error' : '' }}">
                        <label class="col-sm-4 control-label">{{ trans('fields.description') }} *</label>
                        <div class="col-sm-8">
                          <textarea style="overflow:auto;resize:none; height: auto !important;" rows="5" class="form-control input-sm" name="subunit_desc" id="subunit_desc" maxlength="1000">{{ count($errors) > 0 ? old('subunit_desc') : '' }}</textarea>
                          @if($errors->has('subunit_desc'))
                              <span class="help-block">{{ $errors->first('subunit_desc') }}</span>
                          @endif
                        </div>
                      </div>
                      <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                        <label class="col-sm-4 control-label"></label>
                        <div class="col-sm-8">
                          <?php $isActive = count($errors) > 0 ? old('is_active') : 'Y'; ?>
                          <div class="be-checkbox be-checkbox-color inline">
                            <input id="is_active" value="Y" name='is_active'  type="checkbox" {{ $isActive == 'Y' ? 'checked' : '' }}>
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
<div id="modal-subunit-type" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.subunit-lov') }}</h3>
      </div>
      <div class="modal-body table-responsive">
        <div class="form-group">
          <label>{{ trans('common.search') }} {{ trans('menu.master-subunit') }}</label>
          <input type="text" id="searchSubunit" name="searchSubunit" class="form-control">
        </div>
        <table id="table-lov-subunit-type" class="table table-striped table-hover table-bordered table-fw-widget data-table">
            <thead>
              <tr>
                <th width="35%">{{ trans('fields.subunit-name') }}</th>
                <th width="65%">{{ trans('fields.department') }}</th>
                <th width="65%">{{ trans('fields.description') }}</th>
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

    $dataTableSubunit = $("#table-lov-subunit-type").DataTable({
      "aaSorting": [],
      pageLength: 10,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
              "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });
 
  	$('#searchSubunit').on('keyup', loadLovUsername);
    $('#table-lov-subunit-type tbody').on('click', 'tr', selectUsername);

    loadLovUsername();
});

var xhrUsername;
var loadLovUsername = function(callback) {
    if(xhrUsername && xhrUsername.readyState != 4){
        xhrUsername.abort();
    }
    xhrUsername = $.ajax({
        url : '{{ url('/json/get-subunit') }}',
        type: "POST",
        data: {searchSubunit: $('#searchSubunit').val(), limit: 100, "_token": "{{ csrf_token() }}"},
        success: function(data) {
          $dataTableSubunit.clear().draw();
            data['data'].forEach(function(item) {
              var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                              <td>' + item.subunit_name + '</td>\
                              <td>' + item.dept_name + '</td>\
                              <td>' + item.subunit_desc + '</td>\
                          </tr>';

            $dataTableSubunit.row.add( $(htmlTr)[0] ).draw( false );
            });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var selectUsername = function() {
    var data = $(this).data('json');
    $('#subunit_id').val(data.subunit_id);
    $('#subunit_name').val(data.subunit_name);
    $('#subunit_desc').val(data.subunit_desc);
    $('#dept_id').val(data.dept_id);
    if(data.is_active == 'Y'){
      $('#is_active').prop('checked', true);
    }else{
      $('#is_active').prop('checked', false);
    }

    $('#modal-subunit-type').modal('hide');
    $('#searchSubunit').val('');
};

</script>
@endsection