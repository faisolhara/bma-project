<?php
function getAvatar() {

	if(!empty(\Session::get('user')['employee_upload']['bytea_upload']))
		$avatar = "data:image/jpg;base64,".\Session::get('user')['employee_upload']['bytea_upload'];
	else
		$avatar = "assets/img/avatar.png";
	return $avatar;
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="programmer_name" content="Faisol Andi Sefihara">
    <meta name="programmer_email" content="sfaisolandi@gmail.com">

    <link rel="shortcut icon" href="{{ asset('assets/img/logo-fav.png') }}">
    <title>Building Management - @yield('title')</title>
    @section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/material-design-icons/css/material-design-iconic-font.min.css') }}"/><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/jqvmap/jqvmap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css"/>
    <style type="text/css">
      .spinner {
          text-align:center;
          overflow: auto;
          width: 100px; /* width of the spinner gif */
          height: 102px; /*hight of the spinner gif +2px to fix IE8 issue */
        }
    </style>
    @include('custom-css')
    @show
  </head>
  <body>
    
    <div class="be-wrapper be-fixed-sidebar">
      <nav class="navbar navbar-default navbar-fixed-top be-top-header">
        <div class="container-fluid">
          <div class="navbar-header"><a href="{{ url('/dashboard') }}" class="navbar-brand"></a></div>
          <div class="be-right-navbar">
            <ul class="nav navbar-nav navbar-right be-user-nav">
              <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><img src="{{ getAvatar() }}" alt="Avatar"><span class="user-name">{{ \Session::get('user')['first_name'].' '.\Session::get('user')['last_name'] }}</span></a>
                <ul role="menu" class="dropdown-menu">
                  <li>
                    <div class="user-info">
                      <div class="user-name">{{ \Session::get('user')['first_name'].' '.\Session::get('user')['last_name'] }}</div>
                      <div class="user-position online">{{ \Session::get('user')['user_type'] }}</div>
                    </div>
                  </li>
                  <li><a href="{{ URL('/setting') }}""><span class="icon mdi mdi-settings"></span> Settings</a></li>
                  <li><a href="{{ URL('/logout') }}"><span class="icon mdi mdi-power"></span> Logout</a></li>
                </ul>
              </li>
            </ul>
            <div class="page-title">
            <span>@yield('title')
              <span id="spinner" class="spinner" style="display:none;">
                <img id="img-spinner" src="{{ asset('img/pacman.gif') }}" width="30px;" alt="Loading"/>
              </span>
              </span>
            </div>
            <?php
            $notifications = \App\Service\NotificationService::getNotifications();
            $count         = \App\Service\NotificationService::getCountNotification();
            ?>
            <ul class="nav navbar-nav navbar-right be-icons-nav" style="margin-right: 0px !important;">
              <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><span class="icon mdi mdi-notifications"></span><span class="badge notification-badge">{{ $count }}</span></a>
                <ul class="dropdown-menu be-notifications">
                  <li>
                    <div class="title">Notifications<span class="badge notification-badge">{{ $count }}</span></div>
                    <div class="list">
                      <div class="be-scroller">
                        <div class="content">
                          <ul id="list-notification">
                          @foreach($notifications as $notification)
                            <li class="notification notification-unread">
                              <a href="{{ url('/notification/read/'.$notification['complaint_id']) }}" style="color: #404953 !important;">
                                  <div class="text"><strong>{{ $notification['notification_title'] }}</strong> <br>{{ $notification['notification_desc'] }}</div><span class="date">{{ $notification['creation_date'] }}</span>
                              </a>
                            </li>
                          @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="footer"> <a href="{{ url('/notification') }}">View all notifications</a></div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="be-left-sidebar">
        <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">Menu</a>
          <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
              <div class="left-sidebar-content">
                <ul class="sidebar-elements">
                  <li class="{{ Request::is('dashboard') ? 'active' : '' }}"><a href="{{ url('/dashboard') }}"><i class="icon mdi mdi-home"></i><span>{{ trans('menu.dashboard') }}</span></a>
                  <li class="{{ Request::is('notification') ? 'active' : '' }}"><a href="{{ url('/notification') }}"><i class="icon mdi mdi-email"></i><span>{{ trans('menu.notification') }}</span></a>
                  @foreach($navigations as $navigations)
                  <li class="divider">{{ $navigations['label'] }}</li>
                    @foreach($navigations['children'] as $navigation)
                    <li class="{{ Request::is($navigation['route']) ? 'active' : '' }}"><a href="{{ url('/'.$navigation['route']) }}"><i class="{{ $navigation['icon'] }}"></i><span>{{ trans('menu.'.$navigation['label']) }}</span></a>
                    @endforeach
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      @section('content')
      @if(Session::has('successMessage'))
      <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          {{ Session::get('successMessage') }}
      </div>
      @endif

      @if($errors->has('errorMessage'))
      <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          {{ $errors->first('errorMessage') }}
      </div>
      @endif
      @show
    </div>
    
    @section('script')
    <script src="{{ asset('assets/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    @show
    @include('notification-script')
    <div id="modal-alert" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index: 100000;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center text-danger">
                        <span class="mdi mdi-alert-circle" aria-hidden="true"></span>
                        <strong>{{ strtoupper(trans('common.alert')) }} !</strong>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="alert-message">Alert Message</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-alert-success" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index: 100000;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center text-success">
                        <span class="mdi mdi-check-circle" aria-hidden="true"></span>
                        <strong>{{ strtoupper(trans('common.success')) }} !</strong>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="alert-message">Alert Message</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-spinner" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index: 100000;">
        <div class="modal-dialog modal-sm">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="loader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('modal')
    @show
  </body>
</html>