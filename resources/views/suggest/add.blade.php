@extends('layouts.master')

@section('title', trans('menu.suggest'))
<?php 
use App\Constants;
?>

@section('header')
@parent
<style type="text/css">
    #table-lov-suggest tbody tr{
        cursor: pointer;
    }
    #table-lov-room tbody tr{
        cursor: pointer;
    }
    #table-lov-facility tbody tr{
        cursor: pointer;
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
<style type="text/css">
@import url({{ asset("assets/font-awesome/font-awesome.css") }});

  fieldset, label { margin: 0; padding: 0; }
  body{ margin: 20px; }
  h1 { font-size: 1.5em; margin: 10px; }
</style>

@endsection

@section('content')
<div class="be-content">
  <div class="main-content container-fluid">
  @parent
    <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
              <div class="panel-heading panel-heading-divider">{{ trans('common.add-or-edit') }}<span class="panel-subtitle">{{ trans('menu.suggest') }}</span></div>
              <div class="panel-body">
                <form class="form-horizontal" action="{{ url('suggest/save') }}" method="POST" id="form-add" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <?php 
                    $suggestId = !empty($request->get('suggest_id')) ? $request->get('suggest_id') : -1; 
                    ?>
                    <input id="suggest_id" name="suggest_id" type="hidden" value="{{ count($errors) > 0 ? old('suggest_id') : $suggestId }}">
                    <div class="tab-container">
                      <ul class="nav nav-tabs">
                        <li class="active"><a href="#header" data-toggle="tab" aria-expanded="true"><span class="icon mdi mdi-phone-in-talk"></span>{{ trans('fields.suggest') }}</a></li>
                        <li class=""><a href="#photo" data-toggle="tab" aria-expanded="false"><span class="icon mdi mdi-image"></span>{{ trans('fields.photo') }}</a></li>
                      </ul>
                      <div class="row sm-pt-15">
                        <div class="col-sm-12">
                          <div class="text-right">
                            <a class="btn btn-space btn-warning" href="{{ url('/suggest') }}"><i class="icon mdi mdi-undo"></i> {{ trans('common.clear-form') }}</a>
                            <button type="submit" class="btn btn-space btn-primary" data-tipe="{{ Constants::OPEN }}" id="button-save"><i class="icon mdi mdi-save"></i> {{ trans('common.save') }}</button>
                          </div>
                        </div>
                      </div>
                      <div class="tab-content">
                        <div id="header" class="tab-pane cont active">
                          <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('suggest_id_view') ? 'has-error' : '' }}">
                              <label for="suggest_id_view" class="col-sm-4 control-label">{{ trans('fields.suggest-id') }} *</label>
                                <div class="col-md-8">
                                    <div data-min-view="2" class="input-group">
                                      <input id="suggest_id_view" name="suggest_id_view" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('suggest_id_view') : '' }}" readonly>
                                      <span data-toggle="modal" data-target="#modal-suggest" class="input-group-addon btn btn-primary" ><i class="icon-th mdi mdi-search"></i></span>
                                    </div>
                                    @if($errors->has('suggest_id_view'))
                                    <span class="help-block">{{ $errors->first('suggest_id_view') }}</span>
                                    @endif
                                 </div>
                            </div>
                            <div class="form-group {{ $errors->has('room_id') ? 'has-error' : '' }}">
                              <label for="room_id" class="col-sm-4 control-label">{{ trans('fields.room') }} *</label>
                                <div class="col-md-8">
                                    <div data-min-view="2" class="input-group">
                                      <input id="room_id" name="room_id" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('room_id') : '' }}" readonly>
                                      <span data-toggle="modal"  id="btn-modal-room" class="input-group-addon btn btn-primary" ><i class="icon-th mdi mdi-search"></i></span>
                                    </div>
                                    @if($errors->has('room_id'))
                                    <span class="help-block">{{ $errors->first('room_id') }}</span>
                                    @endif
                                 </div>
                            </div>
                            <div class="form-group {{ $errors->has('room_name') ? 'has-error' : '' }}">
                              <label for="room_name" class="col-sm-4 control-label">{{ trans('fields.room-name') }} </label>
                              <div class="col-sm-8">
                                <input id="room_name" name="room_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('room_name') : '' }}" readonly>
                                @if($errors->has('room_name'))
                                    <span class="help-block">{{ $errors->first('room_name') }}</span>
                                @endif
                              </div>
                            </div>
                            <div class="form-group {{ $errors->has('tenant_name') ? 'has-error' : '' }}">
                              <label for="tenant_name" class="col-sm-4 control-label">{{ trans('fields.tenant-name') }} </label>
                              <div class="col-sm-8">
                                <input id="tenant_name" name="tenant_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('tenant_name') : '' }}" readonly>
                                @if($errors->has('tenant_name'))
                                    <span class="help-block">{{ $errors->first('tenant_name') }}</span>
                                @endif
                              </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('facility_id') ? 'has-error' : '' }}">
                              <label for="facility_id" class="col-sm-4 control-label">{{ trans('fields.facility') }} *</label>
                              <div class="col-md-8">
                                  <div data-min-view="2" class="input-group">
                                    <input id="facility_id" name="facility_id" type="hidden" class="form-control input-sm" value="{{ count($errors) > 0 ? old('facility_id') : '' }}" readonly>
                                    <input id="facility_name" name="facility_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('facility_name') : '' }}" readonly>
                                    <span data-toggle="modal" id="btn-modal-facility" class="input-group-addon btn btn-primary" ><i class="icon-th mdi mdi-search"></i></span>
                                  </div>
                                  @if($errors->has('facility_id'))
                                  <span class="help-block">{{ $errors->first('facility_id') }}</span>
                                  @endif
                               </div>
                            </div>
                            <div class="form-group {{ $errors->has('suggest_name') ? 'has-error' : '' }}">
                              <label for="suggest_name" class="col-sm-4 control-label">{{ trans('fields.suggest-name') }} *</label>
                                <div class="col-md-8">
                                    <input id="suggest_name" name="suggest_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('suggest_name') : '' }}" maxlength="50">
                                    @if($errors->has('suggest_name'))
                                    <span class="help-block">{{ $errors->first('suggest_name') }}</span>
                                    @endif
                                 </div>
                            </div>
                            <div class="form-group {{ $errors->has('suggest_desc') ? 'has-error' : '' }}">
                              <label for="suggest_desc" class="col-sm-4 control-label">{{ trans('fields.description') }} *</label>
                                <div class="col-md-8">
                                    <textarea style="overflow:auto;resize:none; height: auto !important;" rows="5" class="form-control input-sm" name="suggest_desc" id="suggest_desc" maxlength="4000">{{ count($errors) > 0 ? old('suggest_desc') : '' }}</textarea>
                                    @if($errors->has('suggest_desc'))
                                    <span class="help-block">{{ $errors->first('suggest_desc') }}</span>
                                    @endif
                                 </div>
                            </div>
                        </div>
                        </div>
                        <div id="photo" class="tab-pane">
                          <div id="form-photo">
                            <div class="form-group">
                              <label class="col-sm-2 control-label">{{ trans('fields.photo-one') }}</label>
                              <div class="col-sm-10">
                                <input type="file" id="photo_one" name="photo[]" style="display:none">
                                <div class="row">
                                  <a class="btn btn-space btn-danger remove-photo" style="display:none">
                                    <i class="icon icon-left mdi mdi-delete"></i> {{ trans('fields.remove') }}
                                  </a>
                                </div>
                                <div class="btn btn-photo well text-center" style="padding: 5px; margin: 0px;">
                                  <img style="max-height:500px; max-width:300px;" hidden/>
                                  <span>{{ trans('common.choose-file') }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-2 control-label">{{ trans('fields.photo-two') }}</label>
                              <div class="col-sm-10">
                                <input type="file" id="photo_two" name="photo[]" style="display:none">
                                <div class="row">
                                  <a class="btn btn-space btn-danger remove-photo" style="display:none">
                                    <i class="icon icon-left mdi mdi-delete"></i> {{ trans('fields.remove') }}
                                  </a>
                                </div>
                                <div class="btn btn-photo well text-center" style="padding: 5px; margin: 0px;">
                                  <img style="max-height:500px; max-width:300px;" hidden/><span>{{ trans('common.choose-file') }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-2 control-label">{{ trans('fields.photo-three') }}</label>
                              <div class="col-sm-10">
                                <input type="file" id="photo_three" name="photo[]" style="display:none">
                                <div class="row">
                                  <a class="btn btn-space btn-danger remove-photo" style="display:none">
                                    <i class="icon icon-left mdi mdi-delete"></i> {{ trans('fields.remove') }}
                                  </a>
                                </div>
                                <div class="btn btn-photo well text-center" style="padding: 5px; margin: 0px;">
                                  <img style="max-height:500px; max-width:300px;" hidden/><span>{{ trans('common.choose-file') }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="show-photo">
                         
                          </div>
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
@parent
<!--Form Modals-->
<div id="modal-suggest" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.suggest-lov') }}</h3>
      </div>
      <div class="modal-body table-responsive">
        <div class="form-group" style="margin-bottom: 5px;">
          <label>{{ trans('fields.suggest') }}</label>
          <input type="text" id="searchSuggest" name="searchSuggest" class="form-control">
        </div>
        <div class="form-group" style="margin-bottom: 5px;">
          <div class="be-checkbox be-checkbox-color inline">
            <input id="not_limit" type="checkbox" >
            <label for="not_limit" style="cursor:pointer;">{{ trans('common.not-limit') }}</label>
          </div>
        </div>
        <table id="table-lov-suggest" class="table table-striped table-hover table-bordered table-fw-widget data-table">
            <thead>
              <tr>
                <th width="5%">{{ trans('fields.suggest-id') }}</th>
                <th width="10%">{{ trans('fields.room') }}</th>
                <th width="10%">{{ trans('fields.tenant') }}</th>
                <th width="30%">{{ trans('fields.suggest-name') }}</th>
                <th width="10%">{{ trans('fields.description') }}</th>
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

<div id="modal-room" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.room-lov') }}</h3>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>{{ trans('fields.room') }}</label>
          <input type="text" id="searchRoom" name="searchRoom" class="form-control">
        </div>
        <table id="table-lov-room" class="table table-striped table-hover table-bordered table-fw-widget data-table">
            <thead>
              <tr>
                <th width="30%">{{ trans('fields.room-id') }}</th>
                <th width="40%">{{ trans('fields.room-name') }}</th>
                <th width="30%">{{ trans('fields.tenant-name') }}</th>
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
<div id="modal-facility" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.facility-lov') }}</h3>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>{{ trans('fields.facility') }}</label>
          <input type="text" id="searchFacility" name="searchFacility" class="form-control">
        </div>
        <table id="table-lov-facility" class="table table-striped table-hover table-bordered table-fw-widget data-table">
            <thead>
              <tr>
                <th width="35%">{{ trans('fields.facility-name') }}</th>
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
    if($('#suggest_id').val() != -1){
      editSuggest();
    }
    
    $dataTableSuggest = $("#table-lov-suggest").DataTable({
      "aaSorting": [],
      pageLength: 10,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
              "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

    $dataTableRoom = $("#table-lov-room").DataTable({
      "aaSorting": [],
      pageLength: 10,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
              "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

    $dataTableFacility = $("#table-lov-facility").DataTable({
      "aaSorting": [],
      pageLength: 10,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
              "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

    $('.btn-photo').on('click', function(){
        $(this).parent().find('input[type="file"]').click();
    });

    $(".remove-photo").on('click', function () {
      var $input  = $(this).parent().parent().find('input[type="file"]');
      var $img    = $(this).parent().parent().find('img');
      var $span   = $(this).parent().parent().find('span');

      $(this).hide();
      $input.val('');
      $img.attr('src', '');
      $img.hide();
      $span.show();
    });

    $("#photo_one").on('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            var $img    = $(this).parent().find('img');
            var $span   = $(this).parent().find('span');
            var $remove = $(this).parent().find('a');
            reader.onload = function (e) {
                $img.attr('src', e.target.result);
                $img.show();
                $remove.show();
                $span.hide();
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#photo_two").on('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            var $img    = $(this).parent().find('img');
            var $span   = $(this).parent().find('span');
            var $remove = $(this).parent().find('a');
            reader.onload = function (e) {
                $img.attr('src', e.target.result);
                $img.show();
                $remove.show();
                $span.hide();
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#photo_three").on('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            var $img    = $(this).parent().find('img');
            var $span   = $(this).parent().find('span');
            var $remove = $(this).parent().find('a');
            reader.onload = function (e) {
                $img.attr('src', e.target.result);
                $img.show();
                $remove.show();
                $span.hide();
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#searchSuggest').on('keyup', loadLovSuggest);
    $('#not_limit').on('change', loadLovSuggest);
    $('#table-lov-suggest tbody').on('click', 'tr', selectSuggest);
    loadLovSuggest();

    $('#searchRoom').on('keyup', loadLovRoom);
    $('#table-lov-room tbody').on('click', 'tr', selectRoom);
    loadLovRoom();

    $('#searchFacility').on('keyup', loadLovFacility);
    $('#table-lov-facility tbody').on('click', 'tr', selectFacility);
    loadLovFacility();

    $('#btn-modal-room').on('click', function(){
      if($('#suggest_id').val() != -1){
        $('#modal-alert').find('.alert-message').html('{{ trans('common.cant-change-room') }}');
        $('#modal-alert').modal('show');
        return;
      }
      $('#modal-room').modal('show');
    });

    $('#btn-modal-facility').on('click', function(){
      if($('#suggest_id').val() != -1){
        $('#modal-alert').find('.alert-message').html('{{ trans('common.cant-change-facility') }}');
        $('#modal-alert').modal('show');
        return;
      }
      $('#modal-facility').modal('show');
    });
});

var xhrSuggest;
var loadLovSuggest = function(callback) {
    if($('#not_limit').is(':checked')){
      $limit = 0;
    }else{
      $limit = 200;
    }

    $('#table-lov-suggest tbody').html('');
    if(xhrSuggest && xhrSuggest.readyState != 4){
        xhrSuggest.abort();
    }
    xhrSuggest = $.ajax({
        url : '{{ url('/json/get-suggest-index') }}',
        type: "POST",
        data: {searchSuggest: $('#searchSuggest').val(), limit: $limit, "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $('#table-lov-suggest tbody').html('');
            $dataTableSuggest.clear().draw();
            data['data'].forEach(function(item) {
              $suggestDesc = item.suggest_desc.length < 100 ?  item.suggest_desc : item.suggest_desc.substring(0, 100) + '....';
              var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                              <td>' + item.suggest_id + '</td>\
                              <td>' + item.room_name + '</td>\
                              <td>' + item.tenant_name + '</td>\
                              <td>' + item.suggest_name + '</td>\
                              <td>' + $suggestDesc + '</td>\
                          </tr>';

              $dataTableSuggest.row.add( $(htmlTr)[0] ).draw( false );
            });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var editSuggest = function() {
  var data;
    $.ajax({
        url: '{{ url('/json/get-suggest') }}', 
          type: "POST",
        data: { suggest_id : $('#suggest_id').val(), "_token": "{{ csrf_token() }}" }, 
        success: function(result){
          result['data'].forEach(function(value) {
            data = value;
          });
        },
        async: false
    });

    if(!data){
      $('#suggest_id').val(-1);
      window.history.pushState("object or string", "Title", "/suggest");
      return;
    }

    setFormSuggest(data);
    
};

var selectSuggest = function() {
    var data;
    var item = $(this).data('json');

    $.ajax({
        url: '{{ url('/json/get-suggest') }}', 
          type: "POST",
        data: { suggest_id : item.suggest_id, "_token": "{{ csrf_token() }}" }, 
        success: function(result){
          result['data'].forEach(function(value) {
            data = value;
          });
        },
        async: false
    });
    setFormSuggest(data);
    
};

var setFormSuggest = function(data) {
    $('#button-save').hide();

    $('#suggest_id_view').val(data.suggest_id);
    $('#suggest_id').val(data.suggest_id);
    $('#suggest_name').val(data.suggest_name);
    $('#suggest_desc').val(data.suggest_desc);
    $('#room_id').val(data.room_id);
    $('#room_name').val(data.room_name);
    $('#tenant_name').val(data.tenant_name);
    $('#facility_id').val(data.facility_id);
    $('#facility_name').val(data.facility_name);

    $('#modal-suggest').modal('hide');
    $('#searchSuggest').val('');
    loadLovSuggest();
    changeModeEdit(data);
}

var xhrRoom;
var loadLovRoom = function(callback) {
    if(xhrRoom && xhrRoom.readyState != 4){
        xhrRoom.abort();
    }
    xhrRoom = $.ajax({
        url : '{{ url('/json/get-room') }}',
        type: "POST",
        data: {searchRoom: $('#searchRoom').val(), limit: 100, "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $dataTableRoom.clear().draw();
            data['data'].forEach(function(item) {
              var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                              <td>' + item.room_id + '</td>\
                              <td>' + item.room_name + '</td>\
                              <td>' + item.first_name_tenant +' '+ item.last_name_tenant + '</td>\
                          </tr>';

              $dataTableRoom.row.add( $(htmlTr)[0] ).draw( false );
            });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var selectRoom = function() {
    var data = $(this).data('json');
    $('#room_id').val(data.room_id);
    $('#room_name').val(data.room_name);
    $('#tenant_name').val(data.first_name_tenant+' '+ data.last_name_tenant);

    $('#modal-room').modal('hide');
    $('#searchRoom').val('');
};

var xhrFacility;
var loadLovFacility = function(callback) {
    if(xhrFacility && xhrFacility.readyState != 4){
        xhrFacility.abort();
    }
    xhrFacility = $.ajax({
        url : '{{ url('/json/get-facility') }}',
        type: "POST",
        data: {searchFacility : $('#searchFacility').val(), is_active: 'Y', limit: 100, "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $dataTableFacility.clear().draw();
            data['data'].forEach(function(item) {
              var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                              <td>' + item.facility_name + '</td>\
                              <td>' + item.facility_desc + '</td>\
                          </tr>';

              $dataTableFacility.row.add( $(htmlTr)[0] ).draw( false );
            });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};


var selectFacility = function() {
    var data = $(this).data('json');
    $('#facility_id').val(data.facility_id);
    $('#facility_name').val(data.facility_name);

    $('#modal-facility').modal('hide');
    $('#searchFacility').val('');
};

var changeModeEdit = function(data) {
    $('#suggest_desc').attr('readonly', true);
    $('#suggest_name').attr('readonly', true);
    
    $("#form-photo").hide();
    $("#show-photo").show();
    
    $('#show-photo').html('');
    $.each( data.suggest_uploads, function(key, value) {
      $('#show-photo').append(
          '<div class="col-xs-12">\
            <div class="bs-grid-block">\
              <div class="content">\
              <a target="_blank" href="data:image/png;base64,'+ value.bytea_upload +'">\
                <img style="max-height:400px; max-width:800px;" src="data:image/png;base64,'+ value.bytea_upload +'">\
              </a>\
              </div>\
            </div>\
          </div>'
      );
    });
};

</script>
@endsection