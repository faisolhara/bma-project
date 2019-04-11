@extends('layouts.master')

@section('title', trans('menu.master-tenant'))

@section('header')
@parent
<style type="text/css">
    #table-lov-first-name tbody tr{
        cursor: pointer;
    }
    input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
	  -webkit-appearance: none; 
	  margin: 0; 
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
	            <div class="panel-heading panel-heading-divider">{{ trans('common.add-or-edit') }}<span class="panel-subtitle">{{ trans('menu.master-tenant') }}</span></div>
	            <div class="panel-body">
	              <form class="form-horizontal" action="{{ url('master-tenant/save') }}" method="POST" id="form-add">
                    {{ csrf_field() }}
		            <input id="tenant_id" name="tenant_id" type="hidden" value="{{ count($errors) > 0 ? old('tenant_id') : -1 }}">
	                <div class="row xs-pt-15">
	                  <div class="col-xs-12">
	                    <p class="text-right">
	                      <a class="btn btn-space btn-warning" href="{{ url('/master-tenant') }}"><i class="icon mdi mdi-mail-reply"></i> {{ trans('common.clear-form') }}</a>
	                      <button type="submit" class="btn btn-space btn-primary"><i class="icon mdi mdi-save"></i> {{ trans('common.save') }}</button>
	                    </p>
	                  </div>
	                </div>
	        		<div class="col-sm-6">
		                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
		                  <label for="first_name" class="col-sm-4 control-label">{{ trans('fields.first-name') }} *</label>
		                  	<div class="col-md-8">
		                        <div data-min-view="2" class="input-group">
		                          <input id="first_name" name="first_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('first_name') : '' }}" maxlength="50"><span data-toggle="modal" data-target="#modal-first-name" class="input-group-addon btn btn-primary" id="btn-first-name"><i class="icon-th mdi mdi-search"></i></span>
		                        </div>
		                        @if($errors->has('first_name'))
	                            <span class="help-block">{{ $errors->first('first_name') }}</span>
	                            @endif
		                     </div>
		                </div>
		                <div class="form-group {{ $errors->has('middle_name') ? 'has-error' : '' }}">
		                  <label for="middle_name" class="col-sm-4 control-label">{{ trans('fields.middle-name') }}</label>
		                  <div class="col-sm-8">
		                    <input id="middle_name" name="middle_name" type="middle_name" class="form-control input-sm" value="{{ count($errors) > 0 ? old('middle_name') : '' }}" maxlength="50">
		                    @if($errors->has('middle_name'))
	                            <span class="help-block">{{ $errors->first('middle_name') }}</span>
	                        @endif
		                  </div>
		                </div>
		                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
		                  <label for="last_name" class="col-sm-4 control-label">{{ trans('fields.last-name') }}</label>
		                  <div class="col-sm-8">
		                    <input id="last_name" name="last_name" type="last_name" class="form-control input-sm" value="{{ count($errors) > 0 ? old('last_name') : '' }}" maxlength="50">
		                    @if($errors->has('last_name'))
	                            <span class="help-block">{{ $errors->first('last_name') }}</span>
	                        @endif
		                  </div>
		                </div>
		                <div class="form-group {{ $errors->has('tenant_type') ? 'has-error' : '' }}">
	                      <label class="col-sm-4 control-label">{{ trans('fields.type') }} *</label>
	                      <div class="col-sm-8">
	                        <select class="form-control input-sm" name="tenant_type" id="tenant_type">
	                        <?php $tenantType = count($errors) > 0 ? old('tenant_type') : null; ?>
	                          <option value="">{{ trans('common.please-select') }}</option>
	                        @foreach($typeOption as $option)
	                          <option value="{{ $option }}" {{ $option == $tenantType ? 'selected' : '' }}>{{ $option }}</option>
	                        @endforeach
	                        </select>
	                        @if($errors->has('tenant_type'))
                            <span class="help-block">{{ $errors->first('tenant_type') }}</span>
                            @endif
	                      </div>
	                    </div>
		                <div class="form-group {{ $errors->has('sex') ? 'has-error' : '' }}">
	                      <label class="col-sm-4 control-label">{{ trans('fields.sex') }} *</label>
	                        <?php $sex = count($errors) > 0 ? old('sex') : null; ?>
	                      <div class="col-sm-8">
	                        <div class="be-radio inline">
	                          <input type="radio" checked="" name="sex" value="L" id="male" >
	                          <label for="male">{{ trans('fields.male') }}</label>
	                        </div>
	                        <div class="be-radio inline">
	                          <input type="radio"  name="sex" value="P" id="female" {{ $sex == 'P' ? 'checked' : '' }}>
	                          <label for="female">{{ trans('fields.female') }}</label>
	                        </div>
	                        @if($errors->has('sex'))
	                            <span class="help-block">{{ $errors->first('sex') }}</span>
	                        @endif
	                      </div>
	                    </div>
	                    <div class="form-group {{ $errors->has('citizenship') ? 'has-error' : '' }}">
	                      <label class="col-sm-4 control-label">{{ trans('fields.citizenship') }} *</label>
	                      <div class="col-sm-8">
	                        <?php $citizenship = count($errors) > 0 ? old('citizenship') : null; ?>
	                        <div class="be-radio inline">
	                          <input type="radio" checked="" name="citizenship" value="WNI" id="wni">
	                          <label for="wni">{{ trans('fields.wni') }}</label>
	                        </div>
	                        <div class="be-radio inline">
	                          <input type="radio" name="citizenship" value="WNA" id="wna" {{ $citizenship == 'WNA' ? 'checked' : '' }}>
	                          <label for="wna">{{ trans('fields.wna') }}</label>
	                        </div>
	                        @if($errors->has('citizenship'))
	                            <span class="help-block">{{ $errors->first('citizenship') }}</span>
	                        @endif
	                      </div>
	                    </div>
		                <div class="form-group {{ $errors->has('birth_date') ? 'has-error' : '' }}">
	                      <label class="col-sm-4 control-label">{{ trans('fields.birth-date') }}</label>
	                      <div class="col-md-8">
	                        <div data-min-view="2" data-date-format="dd-mm-yyyy" class="input-group date datetimepicker">
	                          <input size="16" name="birth_date" id="birth_date" type="text" value="{{ count($errors) > 0 ? old('birth_date') : '' }}" class="form-control input-sm" readonly>
	                          <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar" ></i></span>
	                        </div>
	                        @if($errors->has('birth_date'))
	                            <span class="help-block">{{ $errors->first('birth_date') }}</span>
	                        @endif
	                      </div>
	                    </div>
	                    <div class="form-group {{ $errors->has('birth_place') ? 'has-error' : '' }}">
		                  <label for="birth_place" class="col-sm-4 control-label">{{ trans('fields.birth-place') }}</label>
		                  <div class="col-sm-8">
		                    <input id="birth_place" name="birth_place" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('birth_place') : '' }}" maxlength="25">
		                    @if($errors->has('birth_place'))
	                            <span class="help-block">{{ $errors->first('birth_place') }}</span>
	                        @endif
		                  </div>
		                </div>
		            	<div class="form-group {{ $errors->has('identity_card') ? 'has-error' : '' }}">
	                      <label class="col-sm-4 control-label">{{ trans('fields.identity-card') }} *</label>
	                      <div class="col-sm-8">
	                        <?php $identityCard = count($errors) > 0 ? old('identity_card') : null; ?>
	                        <select class="form-control input-sm" name="identity_card" id="identity_card">
	                          <option value="">{{ trans('common.please-select') }}</option>
	                        @foreach($identityOption as $option)
	                          <option value="{{ $option }}" {{ $identityCard == $option ? 'selected' : '' }}>{{ $option }}</option>
	                        @endforeach
	                        </select>
	                        @if($errors->has('identity_card'))
                            <span class="help-block">{{ $errors->first('identity_card') }}</span>
                            @endif
	                      </div>
	                    </div>
		                <div class="form-group {{ $errors->has('identity_number') ? 'has-error' : '' }}">
		                  <label for="identity_number" class="col-sm-4 control-label">{{ trans('fields.identity-number') }} *</label>
		                  <div class="col-sm-8">
		                    <input id="identity_number" name="identity_number" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('identity_number') : '' }}" maxlength="25">
		                    @if($errors->has('identity_number'))
                            <span class="help-block">{{ $errors->first('identity_number') }}</span>
                            @endif
		                  </div>
		                </div>
		            </div>
		            <div class="col-sm-6">
		                <div class="form-group {{ $errors->has('npwp_number') ? 'has-error' : '' }}">
		                  <label for="npwp_number" class="col-sm-4 control-label">{{ trans('fields.npwp-number') }}</label>
		                  <div class="col-sm-8">
		                    <input id="npwp_number" name="npwp_number" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('npwp_number') : '' }}" maxlength="50">
		                    @if($errors->has('npwp_number'))
	                            <span class="help-block">{{ $errors->first('npwp_number') }}</span>
	                        @endif
		                  </div>
		                </div>
		                <div class="form-group {{ $errors->has('blood_type') ? 'has-error' : '' }}">
	                      <label class="col-sm-4 control-label">{{ trans('fields.blood-type') }}</label>
	                        <?php $bloodType = count($errors) > 0 ? old('blood_type') : null; ?>
	                      <div class="col-sm-8">
	                        <select class="form-control input-sm" name="blood_type" id="blood_type">
	                          <option value="">{{ trans('common.please-select') }}</option>
	                          <option value="A" {{ $bloodType == 'A' ? 'selected' : '' }}>A</option>
	                          <option value="B" {{ $bloodType == 'B' ? 'selected' : '' }}>B</option>
	                          <option value="AB" {{ $bloodType == 'AB' ? 'selected' : '' }}>AB</option>
	                          <option value="O" {{ $bloodType == 'O' ? 'selected' : '' }}>O</option>
	                        </select>
	                        @if($errors->has('blood_type'))
	                            <span class="help-block">{{ $errors->first('blood_type') }}</span>
	                        @endif
	                      </div>
	                    </div>
	                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
	                      <label class="col-sm-4 control-label">{{ trans('fields.address') }} *</label>
	                      <div class="col-sm-8">
	                        <textarea style="overflow:auto;resize:none; height: auto !important;" class="form-control input-sm" name="address" id="address" maxlength="200">{{ count($errors) > 0 ? old('address') : '' }}</textarea>
	                        @if($errors->has('address'))
	                            <span class="help-block">{{ $errors->first('address') }}</span>
	                        @endif
	                      </div>
	                    </div>
	                    <div class="form-group {{ $errors->has('administrative_village') ? 'has-error' : '' }}">
		                  <label for="administrative_village" class="col-sm-4 control-label">{{ trans('fields.administrative-village') }}</label>
		                  <div class="col-sm-8">
		                    <input id="administrative_village" name="administrative_village" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('administrative_village') : '' }}" maxlength="25">
		                    @if($errors->has('administrative_village'))
	                            <span class="help-block">{{ $errors->first('administrative_village') }}</span>
	                        @endif
		                  </div>
		                </div>
		                <div class="form-group {{ $errors->has('district') ? 'has-error' : '' }}">
		                  <label for="district" class="col-sm-4 control-label">{{ trans('fields.district') }}</label>
		                  <div class="col-sm-8">
		                    <input id="district" name="district" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('district') : '' }}" maxlength="25">
		                    @if($errors->has('district'))
	                            <span class="help-block">{{ $errors->first('district') }}</span>
	                        @endif
		                  </div>
		                </div>
		                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
		                  <label for="email" class="col-sm-4 control-label">{{ trans('fields.email') }} *</label>
		                  <div class="col-sm-8">
		                    <input id="email" name="email" type="email" class="form-control input-sm" value="{{ count($errors) > 0 ? old('email') : '' }}" maxlength="50">
		                    @if($errors->has('email'))
	                            <span class="help-block">{{ $errors->first('email') }}</span>
	                        @endif
		                  </div>
		                </div>
		                <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
		                  <label for="phone_number" class="col-sm-4 control-label">{{ trans('fields.phone-number') }} *</label>
		                  <div class="col-sm-8">
		                    <input id="phone_number" name="phone_number" type="text" class="form-control input-sm number" value="{{ count($errors) > 0 ? old('phone_number') : '' }}" maxlength="50">
		                    @if($errors->has('phone_number'))
	                            <span class="help-block">{{ $errors->first('phone_number') }}</span>
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
<div id="modal-first-name" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
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
        <table id="table-lov-first-name" class="table table-striped table-hover table-bordered table-fw-widget data-table">
            <thead>
              <tr>
                <th width="25%">{{ trans('fields.first-name') }}</th>
                <th width="25%">{{ trans('fields.middle-name') }}</th>
                <th width="25%">{{ trans('fields.last-name') }}</th>
                <th width="25%">{{ trans('fields.user-type') }}</th>
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

  	$(".number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
  	
  	$("#btn-first-name").click(function(){

  	});

  	$dataTableTenant = $("#table-lov-first-name").DataTable({
    	"aaSorting": [],
    	pageLength: 10,
	    dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
	            "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

  	$('#searchTenant').on('keyup', loadLovUsername);
    $('#table-lov-first-name tbody').on('click', 'tr', selectUsername);

    loadLovUsername();
});

var xhrUsername;
var loadLovUsername = function(callback) {
    if(xhrUsername && xhrUsername.readyState != 4){
        xhrUsername.abort();
    }
    xhrUsername = $.ajax({
        url : '{{ url('/json/get-tenant') }}',
        type: "POST",
        data: {searchTenant: $('#searchTenant').val(), limit: 100, "_token": "{{ csrf_token() }}" },
        success: function(data) {
        	$dataTableTenant.clear().draw();
            data['data'].forEach(function(item) {
            	$middle_name = !item.middle_name ? '' : item.middle_name;
            	$last_name = !item.last_name ? '' : item.last_name;
            	var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
			                    <td>' + item.first_name + '</td>\
			                    <td>' + $middle_name + '</td>\
			                    <td>' + $last_name + '</td>\
			                    <td>' + item.tenant_type + '</td>\
			                </tr>';

		        $dataTableTenant.row.add( $(htmlTr)[0] ).draw( false );
            });
            

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var selectUsername = function() {
    var data = $(this).data('json');
    $('#tenant_id').val(data.tenant_id);
    $('#username').val(data.username);
    $('#first_name').val(data.first_name);
    $('#middle_name').val(data.middle_name);
    $('#last_name').val(data.last_name);
    $('#tenant_type').val(data.tenant_type);
    $('#identity_card').val(data.identity_card);
    $('#identity_number').val(data.identity_number);
    $('#npwp_number').val(data.npwp_number);
    $('#birth_date').val(data.birth_date);
    $('#birth_place').val(data.birth_place);
    $('#blood_type').val(data.blood_type);
    $('#address').val(data.address);
    $('#administrative_village').val(data.administrative_village);
    $('#district').val(data.district);
    $('#email').val(data.email);
    $('#phone_number').val(data.phone_number);

    $('#phone_number').val(data.phone_number);
    if (data.sex == "L") {
    	$("#male").attr('checked', 'checked');
    }
    if (data.sex == "P") {
    	$("#female").attr('checked', 'checked');
    }

    if (data.citizenship == "WNI") {
    	$("#wni").attr('checked', 'checked');
    }
    if (data.citizenship == "WNA") {
    	$("#wna").attr('checked', 'checked');
    }
    if(data.is_active == 'Y'){
	    $('#is_active').prop('checked', true);
    }else{
	    $('#is_active').prop('checked', false);
    }

    $('#modal-first-name').modal('hide');
    $('#searchTenant').val('');
};

</script>
@endsection