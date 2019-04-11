@extends('layouts.master')

@section('title', trans('menu.master-user'))

<?php 
use App\Constants;
?>

@section('header')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datatables/css/dataTables.bootstrap.min.css') }}"/>

<style type="text/css">
    #table-lov-username tbody tr{
        cursor: pointer;
    }
    #table-lov-supervised tbody tr{
        cursor: pointer;
    }
</style>

<?php

function displayPhotos($bytea_photo) {

	if(!empty($bytea_photo))
		$photo = "data:image/jpg;base64,".pg_unescape_bytea($bytea_photo);
	else
		$photo = "assets/img/avatar.png";
	return $photo;
}
?>
@endsection

@section('content')
<div class="be-content">
	<div class="main-content container-fluid">
	@parent
		<div class="row">
	        <div class="col-sm-12">
	          <div class="panel panel-default panel-border-color panel-border-color-primary">
	            <div class="panel-heading panel-heading-divider">{{ trans('common.add-or-edit') }}<span class="panel-subtitle">{{ trans('menu.master-user') }}</span></div>
	            <div class="panel-body">
	              <form class="form-horizontal" action="{{ url('master-user/save') }}" method="POST" id="form-add" enctype="multipart/form-data" >
                    {{ csrf_field() }}
		            <input id="employee_id" name="employee_id" type="hidden" value="{{ count($errors) > 0 ? old('employee_id') : -1 }}">
		            <input id="remove_photo" name="remove_photo" type="hidden" value="0">
	                <div class="row sm-pt-15">
	                    <div class="col-sm-12">
	                        <div class="text-right">
	                          <a class="btn btn-space btn-warning" href="{{ url('/master-user') }}"><i class="icon mdi mdi-undo"></i> {{ trans('common.clear-form') }}</a>
	                          <a data-toggle="modal" data-target="#modal-confirmation" class="btn btn-space btn-danger" id="btn-reset-password" style="display:none;"><i class="icon mdi mdi-key"></i> {{ trans('common.reset-password') }}</a>
	                          <button type="submit" class="btn btn-space btn-primary"><i class="icon mdi mdi-save"></i> {{ trans('common.save') }}</button>
	                        </div>
                     	</div>
	                  </div>
	        		<div class="col-sm-6">
		                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
		                  <label for="username" class="col-sm-4 control-label">{{ trans('fields.username') }} *</label>
		                  	<div class="col-md-8">
		                        <div data-min-view="2" class="input-group">
		                          <input id="username" name="username" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('username') : '' }}" maxlength="25"><span data-toggle="modal" data-target="#modal-username" class="input-group-addon btn btn-primary" ><i class="icon-th mdi mdi-search"></i></span>
		                        </div>
                            	@if($errors->has('username'))
	                            <span class="help-block">{{ $errors->first('username') }}</span>
	                            @endif
		                     </div>
		                </div>
		                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
		                  <label for="first_name" class="col-sm-4 control-label">{{ trans('fields.first-name') }} *</label>
		                  <div class="col-sm-8">
		                    <input id="first_name" name="first_name" type="first_name"  class="form-control input-sm" value="{{ count($errors) > 0 ? old('first_name') : '' }}" maxlength="50">
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
		                <div class="form-group {{ $errors->has('user_type') ? 'has-error' : '' }}">
	                      <label class="col-sm-4 control-label">{{ trans('fields.type') }} *</label>
	                      <div class="col-sm-8">
	                        <select class="form-control input-sm" name="user_type" id="user_type">
	                        <?php $userType = count($errors) > 0 ? old('user_type') : null; ?>
	                          <option value="">{{ trans('common.please-select') }}</option>
	                        @foreach($typeOption as $option)
	                          <option value="{{ $option }}" {{ $option == $userType ? 'selected' : '' }}>{{ $option }}</option>
	                        @endforeach
	                        </select>
	                        @if($errors->has('user_type'))
                            <span class="help-block">{{ $errors->first('user_type') }}</span>
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
		                    <input id="npwp_number" name="npwp_number" type="text" class="form-control input-sm number" value="{{ count($errors) > 0 ? old('npwp_number') : '' }}" maxlength="50">
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
	                        <textarea style="overflow:auto;resize:none; height: auto !important;" class="form-control input-sm" rows name="address" id="address" maxlength="200">{{ count($errors) > 0 ? old('address') : '' }}</textarea>
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
		                <div class="form-group  {{ $errors->has('district') ? 'has-error' : '' }}">
		                  <label for="district" class="col-sm-4 control-label">{{ trans('fields.district') }}</label>
		                  <div class="col-sm-8">
		                    <input id="district" name="district" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('district') : '' }}" maxlength="25">
		                    @if($errors->has('district'))
	                            <span class="help-block">{{ $errors->first('district') }}</span>
	                        @endif
		                  </div>
		                </div>
		                <div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}">
		                  <label for="email" class="col-sm-4 control-label">{{ trans('fields.email') }} *</label>
		                  <div class="col-sm-8">
		                    <input id="email" name="email" type="email" class="form-control input-sm" value="{{ count($errors) > 0 ? old('email') : '' }}" maxlength="50">
		                    @if($errors->has('email'))
	                            <span class="help-block">{{ $errors->first('email') }}</span>
	                        @endif
		                  </div>
		                </div>
		                <div class="form-group  {{ $errors->has('phone_number') ? 'has-error' : '' }}">
		                  <label for="phone_number" class="col-sm-4 control-label">{{ trans('fields.phone-number') }} *</label>
		                  <div class="col-sm-8">
		                    <input  data-parsley-type="number" id="phone_number"  name="phone_number" type="text" class="form-control input-sm number" value="{{ count($errors) > 0 ? old('phone_number') : '' }}" maxlength="50">
		                    @if($errors->has('phone_number'))
	                            <span class="help-block">{{ $errors->first('phone_number') }}</span>
	                        @endif
		                  </div>
		                </div>
		                <div class="form-group {{ $errors->has('supervised_id_employee') ? 'has-error' : '' }}">
		                  <label for="supervised_id_employee" class="col-sm-4 control-label">{{ trans('fields.supervised-employee') }}</label>
		                  	<div class="col-md-8">
		                        <div data-min-view="2" class="input-group">
		                        	<input id="supervised_id_employee" name="supervised_id_employee" type="hidden" class="form-control input-sm" value="{{ count($errors) > 0 ? old('supervised_id_employee') : '' }}">
		                          	<input id="supervised_employee_name" name="supervised_employee_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('supervised_employee_name') : '' }}" readonly><span id="btn-modal-supervised" class="input-group-addon btn btn-primary" ><i class="icon-th mdi mdi-search"></i></span>
		                        </div>
                            	@if($errors->has('supervised_id_employee'))
	                            <span class="help-block">{{ $errors->first('supervised_id_employee') }}</span>
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
	                    <div class="form-group">
                          <label class="col-sm-4 control-label">{{ trans('fields.photo-one') }}</label>
                          <div class="col-sm-8">
                            <input type="hidden" id="upload_id" name="upload_id" style="display:none">
                            <input type="file" id="bytea_upload" name="bytea_upload" accept="image/*" style="display:none">
                            <div class="row" style="margin-left: 0px">
                              <a class="btn btn-space btn-danger remove-photo" style="display:none;">
                                <i class="icon icon-left mdi mdi-delete"></i> {{ trans('fields.remove') }}
                              </a>
                            </div>
                            <div class="btn btn-photo well text-center" style="padding: 5px; margin: 0px;">
                              <img style="max-height:200px; max-width:200px;" hidden/>
                              <span>{{ trans('common.choose-file') }}</span>
                            </div>
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
<div id="modal-username" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.user-lov') }}</h3>
      </div>
      <div class="modal-body table-responsive">
        <div class="form-group">
          <label>{{ trans('common.search') }} {{ trans('menu.master-user') }}</label>
          <input type="text" id="searchEmployee" name="searchEmployee" class="form-control">
        </div>
        <table id="table-lov-username" class="table table-striped table-hover table-bordered table-fw-widget data-table">
	        <thead>
	          <tr>
	            <th width="15">{{ trans('fields.username') }}</th>
	            <th width="10">{{ trans('fields.first-name') }}</th>
	            <th width="10">{{ trans('fields.middle-name') }}</th>
	            <th width="10">{{ trans('fields.last-name') }}</th>
	            <th width="15">{{ trans('fields.user-type') }}</th>
	            <th width="20">{{ trans('fields.supervised') }}</th>
	            <th width="15">{{ trans('fields.dept-name') }}</th>
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

<div id="modal-supervised" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.user-lov') }}</h3>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>{{ trans('common.search') }} {{ trans('fields.supervised-employee') }}</label>
          <input type="text" id="searchSupervised" name="searchSupervised" class="form-control">
        </div>
        <table id="table-lov-supervised" class="table table-striped table-hover table-bordered table-fw-widget data-table">
	        <thead>
	          <tr>
	            <th width="33%">{{ trans('fields.first-name') }}</th>
	            <th width="33%">{{ trans('fields.middle-name') }}</th>
	            <th width="33%">{{ trans('fields.last-name') }}</th>
	            <th width="33%">{{ trans('fields.user-type') }}</th>
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
<div id="modal-confirmation" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #fbbc05;">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('common.confirmation') }}</h3>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <span class="mdi mdi-alert-triangle text-center" style="font-size:30px; color: #fbbc05;"></span>
        </div>
        <h4 class="text-center">{{ trans('common.sure-reset-password') }}</h4>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-warning md-close">{{ trans('common.cancel') }}</button>
        <button type="button" class="btn btn-primary md-close" id="submit-action-confirmation">{{ trans('common.yes') }}</button>
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
  	/** NOTIFICATIONS **/
    setInterval(function(){
        getNotifications();
    }, 10000);
    
  	//initialize the javascript
  	App.init();
  	App.formElements();
  	// App.dataTables();

  	$('.btn-photo').on('click', function(){
        $(this).parent().find('input[type="file"]').click();
    });
  	$('#user_type').on('change', function(){
  		$('#supervised_id_employee').val('');
  		$('#supervised_employee_name').val('');
  	});

    $(".remove-photo").on('click', function () {
    	$('#remove_photo').val(1);
      var $input  = $(this).parent().parent().find('input[type="file"]');
      var $img    = $(this).parent().parent().find('img');
      var $span   = $(this).parent().parent().find('span');

      $(this).hide();
      $input.val('');
      $img.attr('src', '');
      $img.hide();
      $span.show();
    });

    $("#bytea_upload").on('change', function () {
    	$('#remove_photo').val(0);
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

    $('#btn-modal-supervised').on('click', function(){
      if($('#user_type').val() == ''){
        $('#modal-alert').find('.alert-message').html('{{ trans('common.choose-user-type-first') }}');
        $('#modal-alert').modal('show');
        return;
      }
      loadLovSupervised();
      $('#modal-supervised').modal('show');

    });

  	$('[data-target="#modal-username"]').on('click', function(){
  		$('#searchEmployee').focus();
  	});

    $dataTableEmployee = $("#table-lov-username").DataTable({
    	"aaSorting": [],
    	pageLength: 10,
	    dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
	            "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

    $dataTableSupervised = $("#table-lov-supervised").DataTable({
    	"aaSorting": [],
    	pageLength: 10,
	    dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
	            "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

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

  	$('#submit-action-confirmation').on('click', function(){

		$('#modal-confirmation').modal('hide');
  		if($('#email').val() == ''){
  			$('#modal-alert').find('.alert-message').html('{{ trans('common.email-required') }}');
	        $('#modal-alert').modal('show');
	        return;
  		}
  		
		$('#modal-spinner').modal('show');
		$('selector').click(function(){return false;});
  		$.ajax({
	    	url: '{{ url('/master-user/reset-password') }}', 
	        type: "POST",
	    	data: { employee_id : $('#employee_id').val(), email : $('#email').val(), "_token": "{{ csrf_token() }}" },
	    	success: function(result){
				$('#modal-spinner').modal('hide');
			    if(result == 'success'){
			    	$('#modal-alert-success').find('.alert-message').html('{{ trans('common.reset-password-success') }}');
			        $('#modal-alert-success').modal('show');
			        return;
			    }else{
			    	$('#modal-alert').find('.alert-message').html('{{ trans('common.reset-password-failed') }}');
			        $('#modal-alert').modal('show');
			        return;
			    }
	    	},
	    	error: function (textStatus, errorThrown) {
			  $('#modal-spinner').modal('hide');

			  $('#modal-alert').find('.alert-message').html('{{ trans('common.reset-password-failed') }}');
			  $('#modal-alert').modal('show');
            }
		});

  	});

  	$('#searchEmployee').on('keyup', loadLovUsername);
    $('#table-lov-username tbody').on('click', 'tr', selectUsername);
    loadLovUsername();

    $('#searchSupervised').on('keyup', loadLovSupervised);
    $('#table-lov-supervised tbody').on('click', 'tr', selectSupervised);
});

var xhrUsername;
var loadLovUsername = function(callback) {
    if(xhrUsername && xhrUsername.readyState != 4){
        xhrUsername.abort();
    }
    xhrUsername = $.ajax({
        url : '{{ url('/json/get-employee-index') }}',
        type: "POST",
        data: {searchEmployee: $('#searchEmployee').val(), limit: 200, "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $dataTableEmployee.clear().draw();
            data['data'].forEach(function(item) {
            	$middle_name = !item.middle_name ? '' : item.middle_name;
            	$last_name   = !item.last_name ? '' : item.last_name;
            	var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
		                        <td>' + item.username + '</td>\
		                        <td>' + item.first_name + '</td>\
		                        <td>' + $middle_name  + '</td>\
		                        <td>' + $last_name + '</td>\
		                        <td>' + item.user_type + '</td>\
		                        <td>' + item.supervised_name + '</td>\
		                        <td>' + item.dept_name + '</td>\
		                    </tr>';

		        $dataTableEmployee.row.add( $(htmlTr)[0] ).draw( false );
            });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var selectUsername = function() {
	
	$('#btn-reset-password').show();

    var data;
    var item = $(this).data('json');

    $.ajax({
    	url: '{{ url('/json/get-employee') }}', 
        type: "POST",
    	data: { employee_id : item.employee_id, "_token": "{{ csrf_token() }}" }, 
    	success: function(result){
		    result['data'].forEach(function(value) {
		    	data = value;
		    });
    	},
    	async: false
	});

    $('#employee_id').val(data.employee_id);
    $('#username').val(data.username);
    $('#first_name').val(data.first_name);
    $('#middle_name').val(data.middle_name);
    $('#last_name').val(data.last_name);
    $('#user_type').val(data.user_type);
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
    $('#dept_id').val(data.dept_id);
    $('#supervised_id_employee').val(data.supervised_id_employee);
    $('#supervised_employee_name').val(data.supervised_name);
    
    $('#upload_id').val(data.upload_id);


    if(data.upload_id != -1 && data.bytea_upload != ''){
	    var $img 	= $('.btn-photo').parent().find('img');
	    var $span 	= $('.btn-photo').parent().find('span');
	    var $remove = $('.btn-photo').parent().find('a');

	    $img.attr('src', 'data:image/png;base64,'+ data.bytea_upload +'');
	    $img.show();
	    $remove.show();
	    $span.hide();
    }else{
    	var $img 	= $('.btn-photo').parent().find('img');
	    var $span 	= $('.btn-photo').parent().find('span');
	    var $remove = $('.btn-photo').parent().find('a');

	    $img.hide();
	    $remove.hide();
	    $span.show();
    }

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

    $('#modal-username').modal('hide');
    $('#searchEmployee').val('');
};

var xhrSupervised;
var loadLovSupervised = function(callback) {
	if($('#user_type').val() == '{{ Constants::ADMIN }}' || $('#user_type').val() == '{{ Constants::SPV_TEKNISI }}'){
		$user_type = '{{ Constants::MANAGER }}';
	}else if($('#user_type').val() == '{{ Constants::TEKNISI }}'){
		$user_type = '{{ Constants::SPV_TEKNISI }}';
	}else{
		$user_type = 'NONAME';
	}
    if(xhrSupervised && xhrSupervised.readyState != 4){
        xhrSupervised.abort();
    }
    xhrSupervised = $.ajax({
        url : '{{ url('/json/get-employee') }}',
        type: "POST",
        data: {searchEmployee: $('#searchSupervised').val(), user_type: $user_type, is_active: 'Y', limit: 20, "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $dataTableSupervised.clear().draw();
            data['data'].forEach(function(item) {
            	$middle_name = !item.middle_name ? '' : item.middle_name;
            	$last_name   = !item.last_name ? '' : item.last_name;
            	var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
		                        <td>' + item.first_name + '</td>\
		                        <td>' + $middle_name + '</td>\
		                        <td>' + $last_name + '</td>\
		                        <td>' + item.user_type + '</td>\
		                    </tr>';

		        $dataTableSupervised.row.add( $(htmlTr)[0] ).draw( false );
            });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var selectSupervised = function() {
    var data = $(this).data('json');
    $('#supervised_id_employee').val(data.employee_id);
    $('#supervised_employee_name').val(data.first_name + ' ' + data.last_name);

    $('#modal-supervised').modal('hide');
    $('#searchSupervised').val('');
};

</script>
@endsection