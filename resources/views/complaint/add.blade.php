@extends('layouts.master')

@section('title', trans('menu.complaint'))
<?php 
use App\Constants;
?>

@section('header')
@parent
<style type="text/css">
    #table-lov-complaint tbody tr{
        cursor: pointer;
    }
    #table-lov-room tbody tr{
        cursor: pointer;
    }
    #table-lov-facility tbody tr{
        cursor: pointer;
    }
    #table-lov-employee tbody tr{
        cursor: pointer;
    }
    #table-lov-subunit tbody tr{
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

  /****** Style Star Rating Widget *****/

  .rating { 
    border: none;
    float: left;
  }

  .rating > input { display: none; } 
  .rating > label:before { 
    margin: 5px;
    font-size: 1.25em;
    font-family: FontAwesome;
    display: inline-block;
    content: "\f005";
  }

  .rating > .half:before { 
    content: "\f089";
    position: absolute;
  }

  .rating > label { 
    color: #ddd; 
   float: right; 
  }

  /***** CSS Magic to Highlight Stars on Hover *****/

  .rating > input:checked ~ label, /* show gold star when clicked */
  .rating:not(:checked) > label:hover, /* hover current star */
  .rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

  .rating > input:checked + label:hover, /* hover current star when changing rating */
  .rating > input:checked ~ label:hover,
  .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
  .rating > input:checked ~ label:hover ~ label { color: #FFED85;  } 
</style>

@endsection

@section('content')
<div class="be-content">
  <div class="main-content container-fluid">
  @parent
    <div class="row">

          <div class="col-sm-12">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
              <div class="panel-heading panel-heading-divider">{{ trans('common.add-or-edit') }}<span class="panel-subtitle">{{ trans('menu.complaint') }}</span></div>
              <div class="panel-body">
                <form class="form-horizontal" action="{{ url('complaint/save') }}" method="POST" id="form-add" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <?php 
                    $complaintId = !empty($request->get('complaint_id')) ? $request->get('complaint_id') : -1; 
                    ?>
                    <input id="complaint_id" name="complaint_id" type="hidden" value="{{ count($errors) > 0 ? old('complaint_id') : $complaintId }}">
                    <input id="complaint_status" name="complaint_status" type="hidden" value="{{ count($errors) > 0 ? old('complaint_status_view') : Constants::OPEN }}">
                    <input id="employee_player_id" name="employee_player_id" type="hidden" value="{{ count($errors) > 0 ? old('employee_player_id') : '' }}">
                    <input id="room_player_id" name="room_player_id" type="hidden" value="{{ count($errors) > 0 ? old('room_player_id') : '' }}">
                    <input id="is_save" name="is_save" type="hidden" value="{{ count($errors) > 0 ? old('is_save') : 0 }}">
                    <div class="tab-container">
                      <ul class="nav nav-tabs">
                        <li class="active"><a href="#header" data-toggle="tab" aria-expanded="true"><span class="icon mdi mdi-phone-in-talk"></span>{{ trans('fields.complaint') }}</a></li>
                        <li class=""><a href="#photo" data-toggle="tab" aria-expanded="false"><span class="icon mdi mdi-image"></span>{{ trans('fields.photo') }}</a></li>
                        <li class=""><a href="#costing" data-toggle="tab" aria-expanded="false"><span class="icon mdi mdi-money-box"></span>{{ trans('fields.costing') }}</a></li>
                        <li class=""><a href="#rating" data-toggle="tab" aria-expanded="false"><span class="icon mdi mdi-star-half"></span>{{ trans('fields.rating') }}</a></li>
                        <li class=""><a href="#note" data-toggle="tab" aria-expanded="false"><span class="icon mdi mdi-comment-alt-text"></span>{{ trans('fields.note') }}</a></li>
                      </ul>
                      <div class="row sm-pt-15">
                        <div class="col-sm-12">
                          <div class="col-sm-8">
                            <div class="text-left">
                              <a data-toggle="modal" data-target="#modal-confirmation" id="btn-reject" data-tipe="{{ Constants::OPEN }}" data-label="{{ trans('common.reject') }}" class="btn btn-space btn-danger button-action-confirmation" style="display:none;"><i class="icon mdi mdi-eject"></i> {{ trans('common.reject') }}</a>
                              <a data-toggle="modal" data-target="#modal-action" id="btn-cancel" data-tipe="{{ Constants::CANCEL }}" data-label="{{ trans('common.cancel') }}" class="btn btn-space btn-danger button-action-reason" style="display:none;"><i class="icon mdi mdi-delete"></i> {{ trans('common.cancel') }}</a>
                              <a data-toggle="modal" data-target="#modal-confirmation" id="btn-inspecting" data-tipe="{{ Constants::INSPECTING }}" data-label="{{ trans('common.inspecting') }}" class="btn btn-space btn-success button-action-confirmation" style="display:none;"><i class="icon mdi mdi-search"></i> {{ trans('common.inspecting') }}</a>
                              <a data-toggle="modal" data-target="#modal-confirmation" id="btn-costing" data-tipe="{{ Constants::COSTING }}" data-label="{{ trans('common.costing') }}" class="btn btn-space btn-success button-action-confirmation" style="display:none;"><i class="icon mdi mdi-money"></i> {{ trans('common.costing') }}</a>
                              <a data-toggle="modal" data-target="#modal-confirmation" id="btn-waiting" data-tipe="{{ Constants::WAITING_APPROVAL }}" data-label="{{ trans('common.waiting-approval') }}" class="btn btn-space btn-success button-action-confirmation" style="display:none;"><i class="icon mdi mdi-spinner"></i> {{ trans('common.waiting-approval') }}</a>
                              <a data-toggle="modal" data-target="#modal-action" id="btn-approve" data-tipe="{{ Constants::APPROVED }}" data-label="{{ trans('common.approve') }}" class="btn btn-space btn-success button-action-reason" style="display:none;"><i class="icon mdi mdi-redo"></i> {{ trans('common.approve') }}</a>
                              <a data-toggle="modal" data-target="#modal-confirmation" id="btn-progress" data-tipe="{{ Constants::PROGRESS }}" data-label="{{ trans('common.progress') }}" class="btn btn-space btn-success button-action-confirmation" style="display:none;"><i class="icon mdi mdi-play-for-work"></i> {{ trans('common.progress') }}</a>
                              <a data-toggle="modal" data-target="#modal-action" id="btn-done" data-tipe="{{ Constants::DONE }}" data-label="{{ trans('common.done') }}" class="btn btn-space btn-success button-action-reason" style="display:none;"><i class="icon mdi mdi-play-for-work"></i> {{ trans('common.done') }}</a>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="text-right">
                              <a class="btn btn-space btn-warning" href="{{ url('/complaint') }}"><i class="icon mdi mdi-undo"></i> {{ trans('common.clear-form') }}</a>
                              <button type="submit" class="btn btn-space btn-primary" data-tipe="{{ Constants::OPEN }}" id="button-save"><i class="icon mdi mdi-save"></i> {{ trans('common.save') }}</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-content">
                        <div id="header" class="tab-pane cont active">
                          <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('complaint_id_view') ? 'has-error' : '' }}">
                              <label for="complaint_id_view" class="col-sm-4 control-label">{{ trans('fields.complaint-id') }} *</label>
                                <div class="col-md-8">
                                    <div data-min-view="2" class="input-group">
                                      <input id="complaint_id_view" name="complaint_id_view" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('complaint_id_view') : '' }}" readonly>
                                      <span data-toggle="modal" data-target="#modal-complaint" class="input-group-addon btn btn-primary" ><i class="icon-th mdi mdi-search"></i></span>
                                    </div>
                                    @if($errors->has('complaint_id_view'))
                                    <span class="help-block">{{ $errors->first('complaint_id_view') }}</span>
                                    @endif
                                 </div>
                            </div>
                            <div class="form-group {{ $errors->has('complaint_desc') ? 'has-error' : '' }}">
                              <label for="complaint_desc" class="col-sm-4 control-label">{{ trans('fields.complaint') }} *</label>
                                <div class="col-md-8">
                                    <textarea style="overflow:auto;resize:none; height: auto !important;" rows="5" class="form-control input-sm" name="complaint_desc" id="complaint_desc" maxlength="4000">{{ count($errors) > 0 ? old('complaint_desc') : '' }}</textarea>
                                    @if($errors->has('complaint_desc'))
                                    <span class="help-block">{{ $errors->first('complaint_desc') }}</span>
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
                            <div class="form-group {{ $errors->has('complaint_status_view') ? 'has-error' : '' }}">
                              <label for="complaint_status_view" class="col-sm-4 control-label">{{ trans('fields.complaint-status') }} </label>
                              <div class="col-sm-8">
                                <input id="complaint_status_view" name="complaint_status_view" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('complaint_status_view') : Constants::OPEN }}" readonly>
                                @if($errors->has('complaint_status_view'))
                                    <span class="help-block">{{ $errors->first('complaint_status_view') }}</span>
                                @endif
                              </div>
                            </div>
                            <div class="form-group {{ $errors->has('available_start_date') ? 'has-error' : '' }}">
                              <label class="col-sm-4 control-label">{{ trans('fields.available-start-date') }}</label>
                              <div class="col-sm-8">
                                <div data-min-view="2" class="input-group">
                                  <input type="text" data-date-format="dd-mm-yyyy hh:ii" name="available_start_date" id="available_start_date" class="form-control datetimepicker" style="padding-left:10px; cursor:pointer; font-size: 13px;" value="{{ count($errors) > 0 ? old('available_start_date') : '' }}" readonly>
                                  <span id="span_available_date" style="cursor:auto;" class="input-group-addon btn btn-primary" ><i class="icon-th mdi mdi-calendar"></i></span>
                                </div>
                                @if($errors->has('available_start_date'))
                                    <span class="help-block">{{ $errors->first('available_start_date') }}</span>
                                @endif
                              </div>
                            </div>
                            <div class="form-group {{ $errors->has('available_end_date') ? 'has-error' : '' }}">
                              <label class="col-sm-4 control-label">{{ trans('fields.available-start-date') }}</label>
                              <div class="col-sm-8">
                                <div data-min-view="2" class="input-group">
                                  <input type="text" data-date-format="dd-mm-yyyy hh:ii" name="available_end_date" id="available_end_date" class="form-control datetimepicker" style="padding-left:10px; cursor:pointer; font-size: 13px;" value="{{ count($errors) > 0 ? old('available_end_date') : '' }}" readonly>
                                  <span id="span_available_date" style="cursor:auto;" class="input-group-addon btn btn-primary" ><i class="icon-th mdi mdi-calendar"></i></span>
                                </div>
                                @if($errors->has('available_end_date'))
                                    <span class="help-block">{{ $errors->first('available_end_date') }}</span>
                                @endif
                              </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('detail_unit_id') ? 'has-error' : '' }}">
                              <label for="detail_unit_id" class="col-sm-4 control-label">{{ trans('fields.subunit-name') }} *</label>
                              <div class="col-md-8">
                                  <div data-min-view="2" class="input-group">
                                    <input id="complaint_line_id" name="complaint_line_id" type="hidden" class="form-control input-sm" value="{{ count($errors) > 0 ? old('complaint_line_id') : -1 }}" readonly>
                                    <input id="detail_unit_id" name="detail_unit_id" type="hidden" class="form-control input-sm" value="{{ count($errors) > 0 ? old('detail_unit_id') : '' }}" readonly>
                                    <input id="subunit_name" name="subunit_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('subunit_name') : '' }}" readonly>
                                    <span data-toggle="modal" data-target="" class="input-group-addon btn btn-primary" id="btn-modal-subunit"><i class="icon-th mdi mdi-search"></i></span>
                                  </div>
                                  @if($errors->has('detail_unit_id'))
                                  <span class="help-block">{{ $errors->first('detail_unit_id') }}</span>
                                  @endif
                               </div>
                            </div>
                             <div class="form-group {{ $errors->has('unit_type') ? 'has-error' : '' }}">
                              <label for="unit_type" class="col-sm-4 control-label">{{ trans('fields.unit-type') }}</label>
                              <div class="col-sm-8">
                                <input id="unit_type" name="unit_type" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('unit_type') : '' }}" readonly>
                                @if($errors->has('unit_type'))
                                    <span class="help-block">{{ $errors->first('unit_type') }}</span>
                                @endif
                              </div>
                            </div>
                            <div class="form-group {{ $errors->has('dept_name') ? 'has-error' : '' }}">
                              <label for="dept_name" class="col-sm-4 control-label">{{ trans('fields.dept-name') }} </label>
                              <div class="col-sm-8">
                                <input id="dept_name" name="dept_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('dept_name') : '' }}" readonly>
                                @if($errors->has('dept_name'))
                                    <span class="help-block">{{ $errors->first('dept_name') }}</span>
                                @endif
                              </div>
                            </div>
                            <div class="form-group {{ $errors->has('available_contact_number') ? 'has-error' : '' }}">
                              <label for="available_contact_number" class="col-sm-4 control-label">{{ trans('fields.available-contact') }} </label>
                              <div class="col-sm-8">
                                <input id="available_contact_number" name="available_contact_number" type="text" class="form-control input-sm number" value="{{ count($errors) > 0 ? old('available_contact_number') : '' }}">
                                @if($errors->has('available_contact_number'))
                                    <span class="help-block">{{ $errors->first('available_contact_number') }}</span>
                                @endif
                              </div>
                            </div>
                            <div class="form-group {{ $errors->has('complaint_reference') ? 'has-error' : '' }}">
                              <label class="col-sm-4 control-label">{{ trans('fields.complaint-reference') }}</label>
                              <div class="col-sm-8">
                                <textarea rows="5" class="form-control input-sm" style="overflow:auto;resize:none; height: auto !important;" name="complaint_reference" id="complaint_reference" maxlength="255">{{ count($errors) > 0 ? old('complaint_reference') : '' }}</textarea>
                                @if($errors->has('complaint_reference'))
                                    <span class="help-block">{{ $errors->first('complaint_reference') }}</span>
                                @endif
                              </div>
                            </div>
                            <div class="form-group {{ $errors->has('employee_id') ? 'has-error' : '' }}">
                              <label for="employee_id" class="col-sm-4 control-label">{{ trans('fields.technician') }} </label>
                              <div class="col-md-8">
                                  <div data-min-view="2" class="input-group">
                                    <input id="employee_id" name="employee_id" type="hidden" class="form-control input-sm" value="{{ count($errors) > 0 ? old('employee_id') : null }}" readonly>
                                    <input id="employee_name" name="employee_name" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('employee_name') : '' }}" readonly>
                                    <span data-toggle="modal" id="btn-modal-employee" class="input-group-addon btn btn-primary" ><i class="icon-th mdi mdi-search"></i></span>
                                  </div>
                                  @if($errors->has('employee_id'))
                                  <span class="help-block">{{ $errors->first('employee_id') }}</span>
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
                                <input type="file" id="photo_one" accept="image/*" name="photo[]" style="display:none">
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
                                <input type="file" id="photo_two" accept="image/*" name="photo[]" style="display:none">
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
                                <input type="file" id="photo_three" accept="image/*" name="photo[]" style="display:none">
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
                        <div id="costing" class="tab-pane">
                          <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('complaint_inspect_result') ? 'has-error' : '' }}">
                              <label class="col-sm-4 control-label">{{ trans('fields.inspect-result') }}</label>
                              <div class="col-sm-8">
                                <textarea rows="5" style="overflow:auto; resize:none; height: auto !important;" class="form-control input-sm" name="complaint_inspect_result" id="complaint_inspect_result" maxlength="4000">{{ count($errors) > 0 ? old('complaint_inspect_result') : '' }}</textarea>
                                @if($errors->has('complaint_inspect_result'))
                                    <span class="help-block">{{ $errors->first('complaint_inspect_result') }}</span>
                                @endif
                              </div>
                            </div>
                            <div class="form-group {{ $errors->has('complaint_cost') ? 'has-error' : '' }}">
                              <label for="complaint_cost" class="col-sm-4 control-label">{{ trans('fields.complaint-cost') }} </label>
                              <div class="col-sm-8">
                                <input id="complaint_cost" name="complaint_cost" type="text" class="form-control input-sm text-right currency number" value="{{ count($errors) > 0 ? old('complaint_cost') : '' }}">
                                @if($errors->has('complaint_cost'))
                                    <span class="help-block">{{ $errors->first('complaint_cost') }}</span>
                                @endif
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-4 control-label">{{ trans('fields.cost-photo') }}</label>
                              <div class="col-sm-8">
                                <input type="file" id="complaint_cost_detail" accept="image/*, application/pdf" name="complaint_cost_detail" style="display:none">
                                <div class="btn btn-cost-photo well text-center" style="padding: 5px; margin: 0px;">
                                  <img style="max-height: 150px; max-width: 350px;" hidden id="img_complaint_cost_detail"/><span id="span_complaint_cost_detail">{{ trans('common.choose-file') }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="rating" class="tab-pane">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="employee_name_view" class="col-sm-4 control-label">{{ trans('fields.technician') }} </label>
                              <div class="col-md-8">
                                <input id="employee_name_view" name="employee_name_view" type="text" class="form-control input-sm" value="{{ count($errors) > 0 ? old('employee_name_view') : '' }}" readonly>
                               </div>
                            </div>
                            <div class="form-group">
                              <label for="employee_photo" class="col-sm-4 control-label">{{ trans('fields.photo') }} </label>
                              <div class="col-md-8">
                                  <div data-min-view="2" class="input-group">
                                    <div class="btn btn-cost-photo well text-center" style="padding: 5px; margin: 0px;">
                                      <img style="max-height: 150px; max-width: 350px;" hidden id="img_employee_photo"/>
                                    </div>
                                  </div>
                               </div>
                            </div>
                            <div class="form-group {{ $errors->has('complaint_rate') ? 'has-error' : '' }}">
                              <label class="col-sm-4 control-label">{{ trans('fields.rate') }}</label>
                              <div class="col-sm-8">
                                <fieldset class="rating">
                                  <input type="radio" id="star5" name="complaint_rate" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                  <input type="radio" id="star4half" name="complaint_rate" value="4.5" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                  <input type="radio" id="star4" name="complaint_rate" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                  <input type="radio" id="star3half" name="complaint_rate" value="3.5" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                  <input type="radio" id="star3" name="complaint_rate" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                  <input type="radio" id="star2half" name="complaint_rate" value="2.5" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                  <input type="radio" id="star2" name="complaint_rate" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                  <input type="radio" id="star1half" name="complaint_rate" value="1.5" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                  <input type="radio" id="star1" name="complaint_rate" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                  <input type="radio" id="starhalf" name="complaint_rate" value="0.5" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                              </fieldset>
                              @if($errors->has('complaint_rate'))
                                  <span class="help-block">{{ $errors->first('complaint_rate') }}</span>
                              @endif
                              </div>
                            </div>
                            <div class="form-group {{ $errors->has('complaint_note') ? 'has-error' : '' }}">
                              <label class="col-sm-4 control-label">{{ trans('fields.note') }}</label>
                              <div class="col-sm-8">
                                <textarea rows="5" style="overflow:auto;resize:none; height: auto !important;" class="form-control input-sm" name="complaint_note" id="complaint_note" maxlength="1000">{{ count($errors) > 0 ? old('complaint_note') : '' }}</textarea>
                                @if($errors->has('complaint_note'))
                                    <span class="help-block">{{ $errors->first('complaint_note') }}</span>
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="note" class="tab-pane">
                          <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('cancel_note') ? 'has-error' : '' }}">
                              <label class="col-sm-4 control-label">{{ trans('fields.cancel-note') }}</label>
                              <div class="col-sm-8">
                                <textarea rows="5" style="overflow:auto;resize:none; height: auto !important;" class="form-control input-sm" name="cancel_note" rows="5" id="cancel_note" readonly>{{ count($errors) > 0 ? old('cancel_note') : '' }}</textarea>
                                @if($errors->has('cancel_note'))
                                    <span class="help-block">{{ $errors->first('cancel_note') }}</span>
                                @endif
                              </div>
                            </div>
                            <div class="form-group {{ $errors->has('additional_note') ? 'has-error' : '' }}">
                              <label class="col-sm-4 control-label">{{ trans('fields.approve-note') }}</label>
                              <div class="col-sm-8">
                                <textarea rows="5" style="overflow:auto;resize:none; height: auto !important;" class="form-control input-sm" name="additional_note" rows="5" id="additional_note" readonly>{{ count($errors) > 0 ? old('additional_note') : '' }}</textarea>
                                @if($errors->has('additional_note'))
                                    <span class="help-block">{{ $errors->first('additional_note') }}</span>
                                @endif
                              </div>
                            </div>
                            <div class="form-group {{ $errors->has('complaint_progress_result') ? 'has-error' : '' }}">
                              <label class="col-sm-4 control-label">{{ trans('fields.progress-result') }}</label>
                              <div class="col-sm-8">
                                <textarea rows="5" style="overflow:auto;resize:none; height: auto !important;" class="form-control input-sm" name="complaint_progress_result" rows="5" id="complaint_progress_result" readonly>{{ count($errors) > 0 ? old('complaint_progress_result') : '' }}</textarea>
                                @if($errors->has('complaint_progress_result'))
                                    <span class="help-block">{{ $errors->first('complaint_progress_result') }}</span>
                                @endif
                              </div>
                            </div>
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
<div id="modal-complaint" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.complaint-lov') }}</h3>
      </div>
      <div class="modal-body table-responsive">
        <div class="form-group" style="margin-bottom: 5px;">
          <label>{{ trans('fields.complaint') }}</label>
          <input type="text" id="searchComplaint" name="searchComplaint" class="form-control">
        </div>
        <div class="form-group" style="margin-bottom: 5px;">
          <div class="be-checkbox be-checkbox-color inline">
            <input id="not_limit" type="checkbox" >
            <label for="not_limit" style="cursor:pointer;">{{ trans('common.not-limit') }}</label>
          </div>
        </div>
        <table id="table-lov-complaint" class="table table-striped table-hover table-bordered table-fw-widget data-table">
          <thead>
            <tr>
              <th width="5%">{{ trans('fields.complaint-id') }}</th>
              <th width="30%">{{ trans('fields.complaint') }}</th>
              <th width="5%">{{ trans('fields.room-id') }}</th>
              <th width="10%">{{ trans('fields.room-name') }}</th>
              <th width="10%">{{ trans('fields.tenant-name') }}</th>
              <th width="10%">{{ trans('fields.status') }}</th>
              <th width="10%">{{ trans('fields.available-start-date') }}</th>
              <th width="10%">{{ trans('fields.available-end-date') }}</th>
              <th width="10%">{{ trans('fields.technician') }}</th>
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

<div id="modal-action" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title"></h3>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <h4 id="cancel-text"></h4>
                <form id="form-cancel" role="form" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <h4 for="reason" class="col-sm-3 control-label">{{ trans('common.reason') }} <span class="required">*</span></h4>
                      <div class="col-sm-9">
                          <textarea style="overflow:auto;resize:none; height: auto !important;" rows="5" name="reason" id="reason" class="form-control" rows="4" maxlength="1000"></textarea>
                          <span class="help-block text-left"></span>
                      </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-warning md-close">{{ trans('common.cancel') }}</button>
        <button type="button" class="btn btn-primary md-close" id="submit-action-reason">{{ trans('common.yes') }}</button>
      </div>
    </div>
  </div>
</div>
<div id="modal-confirmation" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #fbbc05;">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title"></h3>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <span class="mdi mdi-alert-triangle text-center" style="font-size:30px; color: #fbbc05;"></span>
        </div>
        <h4 class="text-center"><div class="modal-message text-danger"></div>{{ trans('common.confirmation-change-status') }}</h4>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-warning md-close">{{ trans('common.cancel') }}</button>
        <button type="button" class="btn btn-primary md-close" id="submit-action-confirmation">{{ trans('common.yes') }}</button>
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
                <th width="30%">{{ trans('fields.phone-number') }}</th>
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
<div id="modal-employee" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.technician-lov') }}</h3>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>{{ trans('fields.technician') }}</label>
          <input type="text" id="searchEmployee" name="searchEmployee" class="form-control">
        </div>
        <table id="table-lov-employee" class="table table-striped table-hover table-bordered table-fw-widget data-table">
            <thead>
              <tr>
                <th width="33%">{{ trans('fields.first-name') }}</th>
                <th width="33%">{{ trans('fields.middle-name') }}</th>
                <th width="33%">{{ trans('fields.last-name') }}</th>
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
<div id="modal-subunit" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
  <div class="modal-dialog custom-width modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
        <h3 class="modal-title">{{ trans('fields.subunit-lov') }}</h3>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>{{ trans('fields.subunit') }}</label>
          <input type="text" id="searchSubunit" name="searchSubunit" class="form-control">
        </div>
        <table id="table-lov-subunit" class="table table-striped table-hover table-bordered table-fw-widget data-table">
            <thead>
              <tr>
                <th>{{ trans('fields.subunit-name') }}</th>
                <th>{{ trans('fields.subunit-desc') }}</th>
                <th>{{ trans('fields.unit-type') }}</th>
                <th>{{ trans('fields.dept-name') }}</th>
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

    if($('#complaint_id').val()){
      editComplaint();
    }

    changeButton($('#complaint_status').val());

    $('#button-save').on('click', function(event){
      $('#is_save').val(1);
      event.preventDefault();
      $('#form-add').submit();
    });
    
    $('.button-action-reason').on('click', function(){
      $('#modal-action').find('.modal-title').html($(this).data('label'));
      $('#complaint_status').val($(this).data('tipe'));

      if($('#modal-action').find('.modal-title').html() == '{{ trans("common.cancel")}}'){
        $("#reason").val($('#cancel_note').val());
      }else if($('#modal-action').find('.modal-title').html() == '{{ trans("common.approve")}}'){
        $("#reason").val($('#additional_note').val());
      }else if($('#modal-action').find('.modal-title').html() == '{{ trans("common.done")}}'){
        $("#reason").val($('#complaint_progress_result').val());
      }

    });

    $('#submit-action-reason').on('click', function(event){
      if($('#reason').val() == ''){
        $('#reason').parent().parent().attr('class', 'has-error');
        $('#reason').parent().parent().find('span.help-block').html('Reason required');
        return;
      }

      if($('#modal-action').find('.modal-title').html() == '{{ trans("common.cancel")}}'){
        $("#cancel_note").val($("#reason").val());
      }else if($('#modal-action').find('.modal-title').html() == '{{ trans("common.approve")}}'){
        $("#additional_note").val($("#reason").val());
      }else if($('#modal-action').find('.modal-title').html() == '{{ trans("common.done")}}'){
        $("#complaint_progress_result").val($("#reason").val());
      }

      $('#is_save').val(0);
      $("#form-add").submit();
    });

    $('.button-action-confirmation').on('click', function(){
      $('#modal-confirmation').find('.modal-message').html('');
      $('#modal-confirmation').find('.modal-title').html($(this).data('label'));
      if($(this).data('label') == '{{ trans('common.waiting-approval') }}' && ($('#complaint_cost').val() == 0 || $('#complaint_cost').val() == '')){
        $('#modal-confirmation').find('.modal-message').html('Cost for this complaint is 0 rupiah, please make sure the cost is valid');
      }

      $('#complaint_status').val($(this).data('tipe'));
    });

    $('#submit-action-confirmation').on('click', function(event){
      $('#is_save').val(0);
      $("#form-add").submit();
    });

    $('.currency').on('keyup', function(event){
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40){
          event.preventDefault();
      }
      var $this = $(this);
      var num = $this.val().replace(/,/gi, "").split("").reverse().join("");

      var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1,").split("").reverse().join(""));

      // the following line has been simplified. Revision history contains original.
      $this.val(num2);
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

    $dataTableComplaint = $("#table-lov-complaint").DataTable({
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

    $dataTableEmployee = $("#table-lov-employee").DataTable({
      "aaSorting": [],
      pageLength: 10,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
              "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

    $dataTableSubunit = $("#table-lov-subunit").DataTable({
      "aaSorting": [],
      pageLength: 10,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
              "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

    $('.btn-cost-photo').on('click', function(){
        if($('#complaint_status').val() == '{{ Constants::COSTING }}'){
          $(this).parent().find('input[type="file"]').click();
        }
    });

    $("#complaint_cost_detail").on('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            var $img    = $(this).parent().find('img');
            var $span   = $(this).parent().find('span');
            reader.onload = function (e) {
                $img.attr('src', e.target.result);
                $img.show();
                $span.hide();
            }
            reader.readAsDataURL(this.files[0]);
        }
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

    $('#searchComplaint').on('keyup', loadLovComplaint);
    $('#not_limit').on('change', loadLovComplaint);
    $('#table-lov-complaint tbody').on('click', 'tr', selectComplaint);
    loadLovComplaint();

    $('#searchRoom').on('keyup', loadLovRoom);
    $('#table-lov-room tbody').on('click', 'tr', selectRoom);
    loadLovRoom();

    $('#searchFacility').on('keyup', loadLovFacility);
    $('#table-lov-facility tbody').on('click', 'tr', selectFacility);
    loadLovFacility();

    $('#searchEmployee').on('keyup', loadLovEmployee);
    $('#table-lov-employee tbody').on('click', 'tr', selectEmployee);

    $('#searchSubunit').on('keyup', loadLovSubunit);
    $('#table-lov-subunit tbody').on('click', 'tr', selectSubunit);

    $('#btn-modal-room').on('click', function(){
      if($('#complaint_id').val() != -1){
        $('#modal-alert').find('.alert-message').html('{{ trans('common.cant-change-room') }}');
        $('#modal-alert').modal('show');
        return;
      }
      $('#modal-room').modal('show');
    });

    $('#btn-modal-subunit').on('click', function(){
      if($('#complaint_id').val() != -1){
        $('#modal-alert').find('.alert-message').html('{{ trans('common.cant-change-subunit') }}');
        $('#modal-alert').modal('show');
        return;
      }
      if($('#room_id').val() == '' || $('#room_id').val() == -1){
        $('#modal-alert').find('.alert-message').html('{{ trans('common.choose-room-first') }}');
        $('#modal-alert').modal('show');
        return;
      }
      loadLovSubunit();
      $('#modal-subunit').modal('show');
    });

    $('#btn-modal-employee').on('click', function(){
      if($('#detail_unit_id').val() == ''){
        $('#modal-alert').find('.alert-message').html('{{ trans('common.choose-subunit-first') }}');
        $('#modal-alert').modal('show');
        return;
      }

      if($('#complaint_status').val() != '{{ Constants::OPEN }}'){
        $('#modal-alert').find('.alert-message').html('{{ trans('common.cant-change-technician') }}');
        $('#modal-alert').modal('show');
        return;
      }

      loadLovEmployee()
      $('#modal-employee').modal('show');
    });
    
});

function RemoveRougeChar(convertString){
  if(convertString.substring(0,1) == ","){

      return convertString.substring(1, convertString.length)            

  }
  return convertString;
}

var changeCurrency = function(event){
   
      var $this = $('.currency');
      var num = $this.val().replace(/,/gi, "").split("").reverse().join("");

      var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1,").split("").reverse().join(""));

      // the following line has been simplified. Revision history contains original.
      $this.val(num2);
};

var xhrComplaint;
var loadLovComplaint = function(callback) {

    if($('#not_limit').is(':checked')){
      $limit = 0;
    }else{
      $limit = 200;
    }

    $('#table-lov-complaint tbody').html('');
    if(xhrComplaint && xhrComplaint.readyState != 4){
        xhrComplaint.abort();
    }
    xhrComplaint = $.ajax({
        url : '{{ url('/json/get-complaint-index') }}',
        type: "POST",
        data: {searchComplaint: $('#searchComplaint').val(), limit: $limit, "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $('#table-lov-complaint tbody').html('');
            $dataTableComplaint.clear().draw();
            data['data'].forEach(function(item) {
              var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                              <td>' + item.complaint_id + '</td>\
                              <td>' + item.complaint_desc + '</td>\
                              <td>' + item.room_id + '</td>\
                              <td>' + item.room_name + '</td>\
                              <td>' + item.tenant_name + '</td>\
                              <td>' + item.complaint_status + '</td>\
                              <td>' + item.available_start_date + '</td>\
                              <td>' + item.available_end_date + '</td>\
                              <td>' + item.employee_name + '</td>\
                          </tr>';

              $dataTableComplaint.row.add( $(htmlTr)[0] ).draw( false );
            });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var editComplaint = function() {
  var data;
    $.ajax({
        url: '{{ url('/json/get-complaint') }}', 
          type: "POST",
        data: { complaint_id : $('#complaint_id').val(), "_token": "{{ csrf_token() }}" }, 
        success: function(result){
          result['data'].forEach(function(value) {
            data = value;
          });
        },
        async: false
    });

    if(!data){
      $('#complaint_id').val(-1);
      window.history.pushState("object or string", "Title", "{{ url('complaint') }}");
      return;
    }


    setFormComplaint(data);
    
};

var selectComplaint = function() {
    // $('#spinner').show();
    var data;
    var item = $(this).data('json');

    $.ajax({
        url: '{{ url('/json/get-complaint') }}', 
          type: "POST",
        data: { complaint_id : item.complaint_id, "_token": "{{ csrf_token() }}" }, 
        success: function(result){
          result['data'].forEach(function(value) {
            data = value;
          });
        },
        async: false
    });

    setFormComplaint(data);
};

var setFormComplaint = function(data) {
  $('#complaint_id_view').val(data.complaint_id);
    $('#complaint_id').val(data.complaint_id);
    $('#employee_id').val(data.employee_id);
    $('#employee_name').val(data.employee_name);
    $('#employee_name_view').val(data.employee_name);
    $('#complaint_desc').val(data.complaint_desc);
    $('#room_id').val(data.room_id);
    $('#room_name').val(data.room_name);
    $('#tenant_name').val(data.tenant_name);
    $('#status').val(data.status);
    $('#available_start_date').val(data.available_start_date);
    $('#available_end_date').val(data.available_end_date);
    $('#complaint_note').val(data.complaint_note);
    $('#complaint_reference').val(data.complaint_reference);
    $('#cancel_note').val(data.cancel_note);
    $('#available_contact_number').val(data.available_contact_number);
    $('#complaint_progress_result').val(data.complaint_progress_result);
    $('#additional_note').val(data.additional_note);
    $('#facility_id').val(data.facility_id);
    $('#facility_name').val(data.facility_name);
    $('#complaint_cost').val(data.complaint_cost);
    $('#complaint_status').val(data.complaint_status);
    $('#complaint_status_view').val(data.complaint_status);
    $('#employee_player_id').val(data.employee_player_id);
    $('#room_player_id').val(data.room_player_id);
    $('#complaint_inspect_result').val(data.complaint_inspect_result);

    changeCurrency();

    if(data.complaint_cost_detail != ''){
      $('#img_complaint_cost_detail').attr('src','data:image/jpg;base64,'+ data.complaint_cost_detail);
      $('#img_complaint_cost_detail').show();
      $('#span_complaint_cost_detail').hide();
    }else{
      $('#img_complaint_cost_detail').attr('src','');
      $('#img_complaint_cost_detail').hide();
      $('#span_complaint_cost_detail').show();
    }

    if(data.employee_photo != ''){
      $('#img_employee_photo').attr('src','data:image/jpg;base64,'+ data.employee_photo);
      $('#img_employee_photo').show();
      $('#span_employee_photo').hide();
    }else{
      $('#img_employee_photo').attr('src','');
      $('#img_employee_photo').hide();
      $('#span_employee_photo').show();
    }

    $('.complaint_rate').val(data.complaint_rate);
    $("#starhalf").attr('checked', false);
    $("#star1").attr('checked', false);
    $("#star1half").attr('checked', false);
    $("#star2").attr('checked', false);
    $("#star2half").attr('checked', false);
    $("#star3").attr('checked', false);
    $("#star3half").attr('checked', false);
    $("#star4").attr('checked', false);
    $("#star4half").attr('checked', false);
    $("#star5").attr('checked', false);
    
    if (data.complaint_rate == 0.5) {
      $("#starhalf").attr('checked', 'checked');
    }else if (data.complaint_rate == 1) {
      $("#star1").attr('checked', 'checked');
    }else if (data.complaint_rate == 1.5) {
      $("#star1half").attr('checked', 'checked');
    }else if (data.complaint_rate == 2) {
      $("#star2").attr('checked', 'checked');
    }else if (data.complaint_rate == 2.5) {
      $("#star2half").attr('checked', 'checked');
    }else if (data.complaint_rate == 3) {
      $("#star3").attr('checked', 'checked');
    }else if (data.complaint_rate == 3.5) {
      $("#star3half").attr('checked', 'checked');
    }else if (data.complaint_rate == 4) {
      $("#star4").attr('checked', 'checked');
    }else if (data.complaint_rate == 4.5) {
      $("#star4half").attr('checked', 'checked');
    }else if (data.complaint_rate == 5) {
      $("#star5").attr('checked', 'checked');
    }

    if(data.complaint_status == '{{ Constants::OPEN }}'){
      $("#available_start_date").removeAttr('disabled');
      $("#available_end_date").removeAttr('disabled');
    }else{
      $("#available_start_date").attr('disabled', 'disabled');
      $("#available_end_date").attr('disabled', 'disabled');
    }

    changeButton(data.complaint_status);

    if(data.complaint_rate > 0){
      $("input[type=radio]").attr('disabled', true);
      if(data.complaint_status == '{{ Constants::DONE }}'){
        $('#complaint_note').attr('readonly', true);
        $('#button-save').hide();
      }
    }


    $.each( data.complaint_lines, function(key, value) {
      $('#complaint_line_id').val(value.complaint_line_id);
      $('#detail_unit_id').val(value.detail_unit_id);
      $('#subunit_name').val(value.subunit_name);
      $('#unit_type').val(value.unit_type);
      $('#dept_name').val(value.dept_name);
    });


    $('#modal-complaint').modal('hide');
    $('#searchComplaint').val('');
    loadLovComplaint();

    changeModeEdit(data);
}

var changeButton = function(complaint_status) {
  complaint_status = complaint_status || [];
  if(complaint_status == '{{ Constants::OPEN }}' && $('#complaint_id').val() != -1){
      $('#btn-cancel').show();
      $('#btn-reject').hide();
      $('#btn-inspecting').show();
      $('#btn-costing').hide();
      $('#btn-waiting').hide();
      $('#btn-approve').hide();
      $('#btn-progress').hide();
      $('#btn-done').hide();

      $('#available_contact_number').attr('readonly', false);
      $('#complaint_reference').attr('readonly', false);
      $('#complaint_inspect_result').attr('readonly', false);
      $('#complaint_cost').attr('readonly', true);
      $('#complaint_cost_detail').attr('readonly', true);
      $('#complaint_note').attr('readonly', true);
      $("input[type=radio]").attr('disabled', true);

    }else if(complaint_status == '{{ Constants::CANCEL }}'){
      $('#btn-cancel').hide();
      $('#btn-reject').hide();
      $('#btn-inspecting').hide();
      $('#btn-costing').hide();
      $('#btn-waiting').hide();
      $('#btn-approve').hide();
      $('#btn-progress').hide();
      $('#btn-done').hide();
      $('#button-save').hide();

      $('#available_contact_number').attr('readonly', true);
      $('#complaint_reference').attr('readonly', true);
      $('#complaint_inspect_result').attr('readonly', true);
      $('#complaint_cost').attr('readonly', true);
      $('#complaint_cost_detail').attr('readonly', true);
      $('#complaint_note').attr('readonly', true);
      $("input[type=radio]").attr('disabled', true);

    }else if(complaint_status == '{{ Constants::INSPECTING }}'){
      $('#btn-cancel').show();
      $('#btn-reject').show();
      $('#btn-inspecting').hide();
      $('#btn-costing').show();
      $('#btn-waiting').hide();
      $('#btn-approve').hide();
      $('#btn-progress').show();
      $('#btn-done').hide();

      $('#available_contact_number').attr('readonly', true);
      $('#complaint_reference').attr('readonly', true);
      $('#complaint_inspect_result').attr('readonly', false);
      $('#complaint_cost').attr('readonly', true);
      $('#complaint_cost_detail').attr('readonly', true);
      $('#complaint_note').attr('readonly', true);
      $("input[type=radio]").attr('disabled', true);

    }else if(complaint_status == '{{ Constants::COSTING }}'){
      $('#btn-cancel').show();
      $('#btn-reject').show();
      $('#btn-inspecting').hide();
      $('#btn-costing').hide();
      $('#btn-waiting').show();
      $('#btn-approve').hide();
      $('#btn-progress').hide();
      $('#btn-done').hide();

      $('#available_contact_number').attr('readonly', true);
      $('#complaint_reference').attr('readonly', true);
      $('#complaint_inspect_result').attr('readonly', true);
      $('#complaint_cost').attr('readonly', false);
      $('#complaint_cost_detail').attr('readonly', false);
      $('#complaint_note').attr('readonly', true);
      $("input[type=radio]").attr('disabled', true);

    }else if(complaint_status == '{{ Constants::WAITING_APPROVAL }}'){
      $('#btn-cancel').show();
      $('#btn-reject').show();
      $('#btn-inspecting').hide();
      $('#btn-costing').hide();
      $('#btn-waiting').hide();
      $('#btn-approve').show();
      $('#btn-progress').hide();
      $('#btn-done').hide();

      $('#available_contact_number').attr('readonly', true);
      $('#complaint_reference').attr('readonly', true);
      $('#complaint_inspect_result').attr('readonly', true);
      $('#complaint_cost').attr('readonly', true);
      $('#complaint_cost_detail').attr('readonly', true);
      $('#complaint_note').attr('readonly', true);
      $("input[type=radio]").attr('disabled', true);

    }else if(complaint_status == '{{ Constants::APPROVED }}'){
      $('#btn-cancel').show();
      $('#btn-reject').show();
      $('#btn-inspecting').hide();
      $('#btn-costing').hide();
      $('#btn-waiting').hide();
      $('#btn-approve').hide();
      $('#btn-progress').show();
      $('#btn-done').hide();

      $('#available_contact_number').attr('readonly', true);
      $('#complaint_reference').attr('readonly', true);
      $('#complaint_inspect_result').attr('readonly', true);
      $('#complaint_cost').attr('readonly', true);
      $('#complaint_cost_detail').attr('readonly', true);
      $('#complaint_note').attr('readonly', true);
      $("input[type=radio]").attr('disabled', true);

    }else if(complaint_status == '{{ Constants::PROGRESS }}'){
      $('#btn-cancel').show();
      $('#btn-reject').show();
      $('#btn-inspecting').hide();
      $('#btn-costing').show();
      $('#btn-waiting').hide();
      $('#btn-approve').hide();
      $('#btn-progress').hide();
      $('#btn-done').show();

      $('#available_contact_number').attr('readonly', true);
      $('#complaint_reference').attr('readonly', true);
      $('#complaint_inspect_result').attr('readonly', true);
      $('#complaint_cost').attr('readonly', true);
      $('#complaint_cost_detail').attr('readonly', true);
      $('#complaint_note').attr('readonly', true);
      $("input[type=radio]").attr('disabled', true);

    }else if(complaint_status == '{{ Constants::DONE }}'){
      $('#btn-cancel').hide();
      $('#btn-reject').hide();
      $('#btn-inspecting').hide();
      $('#btn-costing').hide();
      $('#btn-waiting').hide();
      $('#btn-approve').hide();
      $('#btn-progress').hide();
      $('#btn-done').hide();

      $('#available_contact_number').attr('readonly', true);
      $('#complaint_reference').attr('readonly', true);
      $('#complaint_inspect_result').attr('readonly', true);
      $('#complaint_cost').attr('readonly', true);
      $('#complaint_cost_detail').attr('readonly', true);
      $('#complaint_note').attr('readonly', false);

      $("input[type=radio]").attr('disabled', false);

    }else{
      $('#btn-cancel').hide();
      $('#btn-reject').hide();
      $('#btn-inspecting').hide();
      $('#btn-costing').hide();
      $('#btn-waiting').hide();
      $('#btn-approve').hide();
      $('#btn-progress').hide();
      $('#btn-done').hide();

      $('#available_contact_number').attr('readonly', true);
      $('#complaint_reference').attr('readonly', true);
      $('#complaint_inspect_result').attr('readonly', true);
      $('#complaint_cost').attr('readonly', true);
      $('#complaint_cost_detail').attr('readonly', true);
      $('#complaint_note').attr('readonly', true);
      $("input[type=radio]").attr('disabled', true);
    }
};


var xhrRoom;
var loadLovRoom = function(callback) {
    if(xhrRoom && xhrRoom.readyState != 4){
        xhrRoom.abort();
    }
    xhrRoom = $.ajax({
        url : '{{ url('/json/get-room') }}',
        type: "POST",
        data: {searchRoom: $('#searchRoom').val(), is_active: 'Y', limit: 100, "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $dataTableRoom.clear().draw();
            data['data'].forEach(function(item) {
              var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                              <td>' + item.room_id + '</td>\
                              <td>' + item.room_name + '</td>\
                              <td>' + item.first_name_tenant +' '+ item.last_name_tenant + '</td>\
                              <td>' + item.phone_number_tenant + '</td>\
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
    $('#available_contact_number').val(data.phone_number_tenant);

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
        data: {searchFacility : $('#searchFacility').val(), limit: 100, "_token": "{{ csrf_token() }}"},
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

var xhrEmployee;
var loadLovEmployee = function(callback) {
    var detail_unit_id = $("#detail_unit_id").val();
    if(xhrEmployee && xhrEmployee.readyState != 4){
        xhrEmployee.abort();
    }
    xhrEmployee = $.ajax({
        url : '{{ url('/json/get-employee-detail-unit') }}',
        type: "POST",
        data: {searchEmployee : $('#searchEmployee').val(), detail_unit_id : detail_unit_id, is_active : 'Y', user_type : 'TEKNISI', limit: 100, "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $dataTableEmployee.clear().draw();
            data['data'].forEach(function(item) {
              $middle_name = item.middle_name ? item.middle_name : ''; 
              $last_name   = item.last_name ? item.last_name : ''; 
              var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                              <td>' + item.first_name + '</td>\
                              <td>' + $middle_name + '</td>\
                              <td>' + $last_name + '</td>\
                          </tr>';

              $dataTableEmployee.row.add( $(htmlTr)[0] ).draw( false );
            });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var selectEmployee = function() {
    var data = $(this).data('json');
    $('#employee_id').val(data.employee_id);
    $('#employee_name').val(data.first_name + ' ' + data.last_name);
    $('#employee_name_view').val(data.first_name + ' ' + data.last_name);

    $('#modal-employee').modal('hide');
    $('#searchEmployee').val('');
};

var xhrSubunit;
var loadLovSubunit = function(callback) {
    if(xhrSubunit && xhrSubunit.readyState != 4){
        xhrSubunit.abort();
    }
    xhrSubunit = $.ajax({
        url : '{{ url('/json/get-detail-unit-by-room') }}',
        type: "POST",
        data: { room_id: $('#room_id').val(), subunit_name: $('#searchSubunit').val(), limit: 100, "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $dataTableSubunit.clear().draw();
            data['data'].forEach(function(item) {
              var htmlTr = '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                              <td>' + item.subunit_name + '</td>\
                              <td>' + item.subunit_desc + '</td>\
                              <td>' + item.unit_type + '</td>\
                              <td>' + item.dept_name + '</td>\
                          </tr>';

              $dataTableSubunit.row.add( $(htmlTr)[0] ).draw( false );
            });

            if (typeof(callback) == 'function') {
                callback();
            }
        }
    });
};

var selectSubunit = function() {
    var data = $(this).data('json');
    $('#detail_unit_id').val(data.detail_unit_id);
    $('#subunit_name').val(data.subunit_name);
    $('#unit_type').val(data.unit_type);
    $('#dept_name').val(data.dept_name);

    $('#modal-subunit').modal('hide');
    $('#searchSubunit').val('');
};

var changeModeEdit = function(data) {
    $("#add-line").hide();
    $(".delete-line").hide();

    $('#complaint_desc').attr('readonly', true);

    
    $("#form-photo").hide();
    $("#show-photo").show();
    
    $('#show-photo').html('');
    $.each( data.complaint_uploads, function(key, value) {
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