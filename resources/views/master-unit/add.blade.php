@extends('layouts.master')

@section('title', trans('menu.master-unit'))

@section('header')
@parent
<style type="text/css">
    #table-lov-unit-type tbody tr{
        cursor: pointer;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}"/>

@endsection

@section('content')
<div class="be-content">
  <div class="main-content container-fluid">
  @parent
    <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
              <div class="panel-heading panel-heading-divider">{{ trans('common.add-or-edit') }}<span class="panel-subtitle">{{ trans('menu.master-unit') }}</span></div>
              <div class="panel-body">
                <form class="form-horizontal" action="{{ url('master-unit/save') }}" method="POST" id="form-add">
                    {{ csrf_field() }}
                <input id="unit_id" name="unit_id" type="hidden" value="{{ count($errors) > 0 ? old('unit_id') : -1 }}">
	                <div class="row xs-pt-15">
	                  <div class="col-xs-12">
	                    <p class="text-right">
	                      <a class="btn btn-space btn-warning" href="{{ url('/master-unit') }}"><i class="icon mdi mdi-mail-reply"></i> {{ trans('common.clear-form') }}</a>
	                      <button type="submit" class="btn btn-space btn-primary"><i class="icon mdi mdi-save"></i> {{ trans('common.save') }}</button>
	                    </p>
	                  </div>
	                </div>
                  <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('unit_type') ? 'has-error' : '' }}">
                      <label for="unit_type" class="col-sm-4 control-label">{{ trans('fields.unit-type') }} *</label>
                        <div class="col-md-8">
                            <div data-min-view="2" class="input-group">
                              <input id="unit_type" name="unit_type" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('unit_type') : '' }}" maxlength="50"><span data-toggle="modal" data-target="#modal-unit-type" class="input-group-addon btn btn-primary" id="btn-first-name"><i class="icon-th mdi mdi-search"></i></span>
                            </div>
                            @if($errors->has('unit_type'))
                              <span class="help-block">{{ $errors->first('unit_type') }}</span>
                              @endif
                         </div>
                    </div>
                    <div class="form-group {{ $errors->has('subunit') ? 'has-error' : '' }}">
                      <label class="col-sm-4 control-label">{{ trans('fields.subunit') }} *</label>
                      <div class="col-sm-8">
                        <select multiple="" class="select2" name="subunit[]" id="subunit" >
                            <?php
                                $subunitId = count($errors) > 0 ? old('subunit', []) : [];
                            ?>
                            @foreach($subunitOption as $option)
                            <option value="{{ $option['subunit_id'] }}" {{ in_array($option['subunit_id'], $subunitId) ? 'selected' : '' }}>{{ $option['subunit_name'] }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('subunit'))
                            <span class="help-block">{{ $errors->first('subunit') }}</span>
                        @endif
                      </div>
                    </div>
                    <div class="form-group {{ $errors->has('unit_desc') ? 'has-error' : '' }}">
                      <label class="col-sm-4 control-label">{{ trans('fields.description') }} *</label>
                      <div class="col-sm-8">
                        <textarea style="overflow:auto;resize:none; height: auto !important;" rows="5" class="form-control input-sm" name="unit_desc" id="unit_desc" maxlength="1000">{{ count($errors) > 0 ? old('unit_desc') : '' }}</textarea>
                        @if($errors->has('unit_desc'))
                            <span class="help-block">{{ $errors->first('unit_desc') }}</span>
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
<div id="modal-unit-type" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.unit-lov') }}</h3>
      </div>
      <div class="modal-body table-responsive">
        <div class="form-group">
          <label>{{ trans('common.search') }} {{ trans('menu.master-unit') }}</label>
          <input type="text" id="searchUnit" name="searchUnit" class="form-control">
        </div>
        <table id="table-lov-unit-type" class="table table-striped table-hover table-bordered table-fw-widget data-table">
            <thead>
              <tr>
                <th width="35">{{ trans('fields.unit-type') }}</th>
                <th width="65">{{ trans('fields.description') }}</th>
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

    $dataTableUnit = $("#table-lov-unit-type").DataTable({
      "aaSorting": [],
      pageLength: 10,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
              "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

    loadLovUsername();

    $('#searchUnit').on('keyup', loadLovUsername);
    $('#table-lov-unit-type tbody').on('click', 'tr', selectUsername);

    loadLovUsername();
});

var xhrUsername;
var loadLovUsername = function(callback) {
    if(xhrUsername && xhrUsername.readyState != 4){
        xhrUsername.abort();
    }
    xhrUsername = $.ajax({
        url : '{{ url('/json/get-unit') }}',
        type: "POST",
        data: {searchUnit: $('#searchUnit').val(), limit: 100, "_token": "{{ csrf_token() }}"},
        success: function(data) {
          $dataTableUnit.clear().draw();
          data['data'].forEach(function(item) {
            var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                            <td>' + item.unit_type + '</td>\
                            <td>' + item.unit_desc + '</td>\
                        </tr>';

            $dataTableUnit.row.add( $(htmlTr)[0] ).draw( false );
          });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var selectUsername = function() {
    var data = $(this).data('json');
    $('#unit_id').val(data.unit_id);
    $('#unit_type').val(data.unit_type);
    $('#unit_desc').val(data.unit_desc);
    $('#unit_desc').val(data.unit_desc);

    var arr = [];
    $.each(data.detail, function( index, value ) {
      $.each(value, function( index2, value2 ) {
        if(index2 == 'subunit_id'){
          arr.push(value2);
        }
      });
    });

    $("#subunit").val(arr).trigger('change');

    if(data.is_active == 'Y'){
      $('#is_active').prop('checked', true);
    }else{
      $('#is_active').prop('checked', false);
    }

    $('#modal-unit-type').modal('hide');
    $('#searchUnit').val('');
};

</script>
@endsection