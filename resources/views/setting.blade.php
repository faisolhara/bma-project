@extends('layouts.master')

@section('title', trans('menu.setting'))


@section('content')
<div class="be-content">
	<div class="main-content container-fluid">
	@parent
		<div class="row">
	        <div class="col-sm-12">
	          <div class="panel panel-default panel-border-color panel-border-color-primary">
	            <div class="panel-heading panel-heading-divider"><span class="panel-subtitle">{{ trans('menu.setting') }}</span></div>
	            <div class="panel-body">
	              <form class="form-horizontal" action="{{ url('save-setting') }}" method="POST" id="form-add">
                    {{ csrf_field() }}
    	            <input id="subunit_id" name="subunit_id" type="hidden" value="{{ count($errors) > 0 ? old('subunit_id') : -1 }}">
            		  <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('language') ? 'has-error' : '' }}">
                      <label class="col-sm-4 control-label ">{{ trans('fields.language') }} *</label>
                      <div class="col-sm-8">
                        <?php $language = count($errors) > 0 ? old('language') : strtoupper(\Session::get('language')); ?>
                        <select class="form-control input-sm" name="language" id="language">
                          <option value="">{{ trans('common.please-select') }}</option>
                        @foreach($languageOptions as $key => $option)
                          <option value="{{ $option }}" {{ $language == $option ? 'selected' : '' }}>{{ $key }}</option>
                        @endforeach
                        </select>
                        @if($errors->has('language'))
                            <span class="help-block">{{ $errors->first('language') }}</span>
                        @endif
                      </div>
                    </div>
    	            </div>
                  <div class="row xs-pt-15">
                    <div class="col-xs-12">
                      <p class="text-right">
                        <a class="btn btn-space btn-warning" href="{{ url('/dashboard') }}"><i class="icon mdi mdi-mail-reply"></i> {{ trans('common.cancel') }}</a>
                        <button type="submit" class="btn btn-space btn-primary"><i class="icon mdi mdi-mail-save"></i> {{ trans('common.save') }}</button>
                      </p>
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

@section('script')
@parent
<script src="{{ asset('assets/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/app-form-elements.js') }}" type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function(){
  	//initialize the javascript
  	App.init();
  	App.formElements();
 
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
        data: {searchSubunit: $('#searchSubunit').val(), limit: 10, "_token": "{{ csrf_token() }}"},
        success: function(data) {
            $('#table-lov-subunit-type tbody').html('');
            data['data'].forEach(function(item) {
                $('#table-lov-subunit-type tbody').append(
                    '<tr data-json=\'' + JSON.stringify(item) + '\'>\
                        <td>' + item.subunit_name + '</td>\
                        <td>' + item.subunit_desc + '</td>\
                    </tr>'
                );
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