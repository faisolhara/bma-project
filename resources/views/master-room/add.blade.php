@extends('layouts.master')

@section('title', trans('menu.master-room'))

@section('header')
@parent
<style type="text/css">
    #table-lov-room-name tbody tr{
        cursor: pointer;
    }
    #table-lov-unit tbody tr{
        cursor: pointer;
    }
    #table-lov-tenant tbody tr{
        cursor: pointer;
    }
    #table-lov-landlord tbody tr{
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
	            <div class="panel-heading panel-heading-divider">{{ trans('common.add-or-edit') }}<span class="panel-subtitle">{{ trans('menu.master-room') }}</span></div>
	            <div class="panel-body">
                <form class="form-horizontal" action="{{ url('master-room/save') }}" method="POST" id="form-add">
                    {{ csrf_field() }}
                <input id="room_id" name="room_id" type="hidden" value="{{ count($errors) > 0 ? old('room_id') : -1 }}">
	                <div class="row xs-pt-15">
	                  <div class="col-xs-12">
	                    <p class="text-right">
	                      <a class="btn btn-space btn-warning" href="{{ url('/master-room') }}"><i class="icon mdi mdi-mail-reply"></i> {{ trans('common.clear-form') }}</a>
	                      <button type="submit" class="btn btn-space btn-primary" ><i class="icon mdi mdi-save"></i> {{ trans('common.save') }}</button>
	                    </p>
	                  </div>
	                </div>
                  <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('room_name') ? 'has-error' : '' }}">
                      <label for="room_name" class="col-sm-4 control-label">{{ trans('fields.room-name') }} *</label>
                        <div class="col-md-8">
                            <div data-min-view="2" class="input-group">
                              <input id="room_name" name="room_name" type="text" class="form-control input-sm" maxlength="20"><span data-toggle="modal" data-target="#modal-room-name" class="input-group-addon btn btn-primary" value="{{ count($errors) > 0 ? old('room_name') : '' }}"><i class="icon-th mdi mdi-search"></i></span>
                            </div>
                              @if($errors->has('room_name'))
                              <span class="help-block">{{ $errors->first('room_name') }}</span>
                              @endif
                         </div>
                    </div>
                    <div class="form-group {{ $errors->has('room_id_view') ? 'has-error' : '' }}">
                      <label for="room_id_view" class="col-sm-4 control-label">{{ trans('fields.room-id') }} *</label>
                      <div class="col-sm-8">
                        <input id="room_id_view" name="room_id_view" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('room_id_view') : '' }}" readonly>
                            @if($errors->has('room_id_view'))
                            <span class="help-block">{{ $errors->first('room_id_view') }}</span>
                            @endif
                      </div>
                    </div>
                    <div class="form-group {{ $errors->has('room_passwd') ? 'has-error' : '' }}">
                      <label for="room_passwd" class="col-sm-4 control-label">{{ trans('fields.password') }} *</label>
                      <div class="col-sm-8">
                        <input id="room_passwd" name="room_passwd" type="password" class="form-control input-sm" value="{{ count($errors) > 0 ? old('room_passwd') : '' }}" maxlength="80">
                            @if($errors->has('room_passwd'))
                            <span class="help-block">{{ $errors->first('room_passwd') }}</span>
                            @endif
                      </div>
                    </div>
                    <div class="form-group {{ $errors->has('unit_id') ? 'has-error' : '' }}">
                      <label for="unit_id" class="col-sm-4 control-label">{{ trans('fields.unit') }} *</label>
                        <div class="col-md-8">
                            <div data-min-view="2" class="input-group">
                              <input id="unit_id" name="unit_id" type="hidden" class="form-control input-sm" value="{{ count($errors) > 0 ? old('unit_id') : '' }}">
                              <input id="unit_type" name="unit_type" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('unit_type') : '' }}" readonly><span data-toggle="modal" data-target="#modal-unit" class="input-group-addon btn btn-primary" ><i class="icon-th mdi mdi-search"></i></span>
                            </div>
                              @if($errors->has('unit_id'))
                              <span class="help-block">{{ $errors->first('unit_id') }}</span>
                              @endif
                         </div>
                    </div>
              </div>
              <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('tenant_id') ? 'has-error' : '' }}">
                      <label for="tenant_id" class="col-sm-4 control-label">{{ trans('fields.tenant') }} *</label>
                        <div class="col-md-8">
                            <div data-min-view="2" class="input-group">
                              <input id="tenant_id" name="tenant_id" type="hidden" class="form-control input-sm" value="{{ count($errors) > 0 ? old('tenant_id') : '' }}">
                              <input id="tenant_name" name="tenant_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('tenant_name') : '' }}" readonly><span data-toggle="modal" data-target="#modal-tenant" class="input-group-addon btn btn-primary" ><i class="icon-th mdi mdi-search"></i></span>
                            </div>
                              @if($errors->has('tenant_id'))
                              <span class="help-block">{{ $errors->first('tenant_id') }}</span>
                              @endif
                         </div>
                    </div>
                    <div class="form-group {{ $errors->has('landlord_id') ? 'has-error' : '' }}">
                      <label for="landlord_id" class="col-sm-4 control-label">{{ trans('fields.landlord') }} *</label>
                        <div class="col-md-8">
                            <div data-min-view="2" class="input-group">
                              <input id="landlord_id" name="landlord_id" type="hidden" class="form-control input-sm" value="{{ count($errors) > 0 ? old('landlord_id') : '' }}">
                                <input id="landlord_name" name="landlord_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('landlord_name') : '' }}" readonly><span data-toggle="modal" data-target="#modal-landlord" class="input-group-addon btn btn-primary" ><i class="icon-th mdi mdi-search"></i></span>
                            </div>
                              @if($errors->has('landlord_id'))
                              <span class="help-block">{{ $errors->first('landlord_id') }}</span>
                              @endif
                         </div>
                    </div>
                    <div class="form-group {{ $errors->has('room_desc') ? 'has-error' : '' }}">
                        <label class="col-sm-4 control-label">{{ trans('fields.description') }}</label>
                        <div class="col-sm-8">
                          <textarea style="overflow:auto;resize:none; height: auto !important;" class="form-control input-sm" rows name="room_desc" id="room_desc" maxlength="4000">{{ count($errors) > 0 ? old('room_desc') : '' }}</textarea>
                          @if($errors->has('room_desc'))
                              <span class="help-block">{{ $errors->first('room_desc') }}</span>
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
<div id="modal-room-name" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.room-lov') }}</h3>
      </div>
      <div class="modal-body table-responsive">
        <div class="form-group">
          <label>{{ trans('common.search') }} {{ trans('menu.master-room') }}</label>
          <input type="text" id="searchRoom" name="searchRoom" class="form-control">
        </div>
        <table id="table-lov-room-name" class="table table-striped table-hover table-bordered table-fw-widget data-table">
            <thead>
              <tr>
                <th width="15%">{{ trans('fields.room-id') }}</th>
                <th width="20%">{{ trans('fields.room-name') }}</th>
                <th width="25%">{{ trans('fields.unit') }}</th>
                <th width="20%">{{ trans('fields.tenant') }}</th>
                <th width="20%">{{ trans('fields.landlord') }}</th>
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
<div id="modal-unit" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
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
        <table id="table-lov-unit" class="table table-striped table-hover table-bordered table-fw-widget data-table">
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
<div id="modal-tenant" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.tenant-lov') }}</h3>
      </div>
      <div class="modal-body table-responsive">
        <div class="form-group">
          <label>{{ trans('common.search') }} {{ trans('menu.master-tenant') }}</label>
          <input type="text" id="searchTenant" name="searchTenant" class="form-control">
        </div>
        <table id="table-lov-tenant" class="table table-striped table-hover table-bordered table-fw-widget data-table">
            <thead>
              <tr>
                <th>{{ trans('fields.first-name') }}</th>
                <th>{{ trans('fields.middle-name') }}</th>
                <th>{{ trans('fields.last-name') }}</th>
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

<div id="modal-landlord" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.landlord-lov') }}</h3>
      </div>
      <div class="modal-body table-responsive">
        <div class="form-group">
          <label>{{ trans('common.search') }} {{ trans('fields.landlord') }}</label>
          <input type="text" id="searchLandlord" name="searchLandlord" class="form-control">
        </div>
        <table id="table-lov-landlord" class="table table-striped table-hover table-bordered table-fw-widget data-table">
            <thead>
              <tr>
                <th>{{ trans('fields.first-name') }}</th>
                <th>{{ trans('fields.middle-name') }}</th>
                <th>{{ trans('fields.last-name') }}</th>
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

    $dataTableRoom = $("#table-lov-room-name").DataTable({
      "aaSorting": [],
      pageLength: 10,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
              "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

    $dataTableUnit = $("#table-lov-unit").DataTable({
      "aaSorting": [],
      pageLength: 10,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
              "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

    $dataTableTenant = $("#table-lov-tenant").DataTable({
      "aaSorting": [],
      pageLength: 10,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
              "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

    $dataTableLandlord = $("#table-lov-landlord").DataTable({
      "aaSorting": [],
      pageLength: 10,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
              "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

  	$('#searchRoom').on('keyup', loadLovRoomName);
    $('#table-lov-room-name tbody').on('click', 'tr', selectRoomName);

    $('#searchUnit').on('keyup', loadLovUnit);
    $('#table-lov-unit tbody').on('click', 'tr', selectUnit);

    $('#searchTenant').on('keyup', loadLovTenant);
    $('#table-lov-tenant tbody').on('click', 'tr', selectTenant);

    $('#searchLandlord').on('keyup', loadLovLandlord);
    $('#table-lov-landlord tbody').on('click', 'tr', selectLandlord);

    loadLovRoomName();
    loadLovUnit();
    loadLovTenant();
    loadLovLandlord();
});

var xhrRoomName;
var loadLovRoomName = function(callback) {
    if(xhrRoomName && xhrRoomName.readyState != 4){
        xhrRoomName.abort();
    }
    xhrRoomName = $.ajax({
        url : '{{ url('/json/get-room-index') }}',
        type: "POST",
        data: {searchRoom: $('#searchRoom').val(), limit: 50, "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $dataTableRoom.clear().draw();
            data['data'].forEach(function(item) {
              var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                              <td>' + item.room_id + '</td>\
                              <td>' + item.room_name + '</td>\
                              <td>' + item.unit_type + '</td>\
                              <td>' + item.tenant_name + '</td>\
                              <td>' + item.landlord_name + '</td>\
                          </tr>';

              $dataTableRoom.row.add( $(htmlTr)[0] ).draw( false );
            });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var selectRoomName = function() {
    var data = $(this).data('json');
    $('#room_id').val(data.room_id);
    $('#room_id_view').val(data.room_id);
    $('#room_name').val(data.room_name);
    $('#room_passwd').val(data.room_passwd);
    $('#room_desc').val(data.room_desc);
    $('#unit_id').val(data.unit_id);
    $('#unit_type').val(data.unit_type);
    $('#tenant_id').val(data.tenant_id);
    $('#tenant_name').val(data.tenant_name);
    $('#landlord_id').val(data.landlord_id);
    $('#landlord_name').val(data.landlord_name);

    if(data.is_active == 'Y'){
	    $('#is_active').prop('checked', true);
    }else{
	    $('#is_active').prop('checked', false);
    }

    $('#modal-room-name').modal('hide');
    $('#searchRoom').val('');
};

var xhrUnit;
var loadLovUnit = function(callback) {
    if(xhrUnit && xhrUnit.readyState != 4){
        xhrUnit.abort();
    }
    xhrUnit = $.ajax({
        url : '{{ url('/json/get-unit') }}',
        type: "POST",
        data: { searchUnit: $('#searchUnit').val(), is_active: 'Y', limit: 10, "_token": "{{ csrf_token() }}"},
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

var selectUnit = function() {
    var data = $(this).data('json');
    $('#unit_id').val(data.unit_id);
    $('#unit_type').val(data.unit_type);

    $('#modal-unit').modal('hide');
    $('#searchUnit').val('');
};

var xhrTenant;
var loadLovTenant = function(callback) {
    if(xhrTenant && xhrTenant.readyState != 4){
        xhrTenant.abort();
    }
    xhrTenant = $.ajax({
        url : '{{ url('/json/get-tenant') }}',
        type: "POST",
        data: { searchTenant: $('#searchTenant').val(), tenant_type: 'TENANT', is_active: 'Y', limit: 100, "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $dataTableTenant.clear().draw();
            data['data'].forEach(function(item) {
              $first_name  = !item.first_name ? '' : item.first_name;
              $middle_name = !item.middle_name ? '' : item.middle_name;
              $last_name   = !item.last_name ? '' : item.last_name;
              var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                              <td>' + $first_name + '</td>\
                              <td>' + $middle_name + '</td>\
                              <td>' + $last_name + '</td>\
                          </tr>';

              $dataTableTenant.row.add( $(htmlTr)[0] ).draw( false );
            });
            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var selectTenant = function() {
    var data = $(this).data('json');
    $('#tenant_id').val(data.tenant_id);
    $last_name = data.last_name ? data.last_name : '';
    $('#tenant_name').val(data.first_name + ' ' + $last_name);

    $('#modal-tenant').modal('hide');
    $('#searchTenant').val('');
};

var xhrLandlord;
var loadLovLandlord = function(callback) {
    if(xhrLandlord && xhrLandlord.readyState != 4){
        xhrLandlord.abort();
    }
    xhrLandlord = $.ajax({
        url : '{{ url('/json/get-tenant') }}',
        type: "POST",
        data: { searchTenant: $('#searchLandlord').val(), is_active: 'Y', limit: 100, tenant_type: 'LANDLORD', "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $dataTableLandlord.clear().draw();
            data['data'].forEach(function(item) {
              $first_name  = !item.first_name ? '' : item.first_name;
              $middle_name = !item.middle_name ? '' : item.middle_name;
              $last_name   = !item.last_name ? '' : item.last_name;
              var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                              <td>' + $first_name + '</td>\
                              <td>' + $middle_name + '</td>\
                              <td>' + $last_name + '</td>\
                          </tr>';

              $dataTableLandlord.row.add( $(htmlTr)[0] ).draw( false );
            });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var selectLandlord = function() {
    var data = $(this).data('json');
    $('#landlord_id').val(data.tenant_id);
    $last_name = data.last_name ? data.last_name : '';
    $('#landlord_name').val(data.first_name + ' ' + $last_name);

    $('#modal-landlord').modal('hide');
    $('#searchLandlord').val('');
};

</script>
@endsection