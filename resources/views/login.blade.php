<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="{!! asset('img/logo-fav.png') !!}">
        <title>Building Management</title>
        <link rel="stylesheet" type="text/css" href="{!! asset('lib/perfect-scrollbar/css/perfect-scrollbar.min.css') !!}"/>
        <link rel="stylesheet" type="text/css" href="{!! asset('lib/material-design-icons/css/material-design-iconic-font.min.css') !!}"/><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="{!! asset('css/style.css') !!}" type="text/css"/>
    </head>
    <body class="be-splash-screen">
        <div class="be-wrapper be-login">
            <div class="be-content">
                <div class="main-content container-fluid">
                    <div class="splash-container">
                        <div class="panel panel-default panel-border-color panel-border-color-primary">
                            <div class="panel-heading"><img src="{!! asset('img/logo-plain.png') !!}" alt="logo" width="102" height="27" class="logo-img"><span class="splash-description">Please enter your user information.</span></div>
                            <div class="panel-body">
                                <form action="login" method="POST">
                                    {{ csrf_field() }}
                                    <div class="login-form">
                                        @if($errors->has('errorMessage'))
                                        <div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            {{ $errors->first('errorMessage') }}
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <input id="username" name="username" type="text" placeholder="Username" autocomplete="off" class="form-control">
                                            @if($errors->has('username'))
                                                <div role="alert" class="alert alert-danger alert-dismissible">
                                                  <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button><strong>{{ $errors->first('username') }}</strong>
                                                </div>

                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input id="password" name="password" type="password" placeholder="Password" class="form-control">
                                            @if($errors->has('password'))
                                                <div role="alert" class="alert alert-danger alert-dismissible">
                                                  <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button><strong>{{ $errors->first('password') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group row login-submit">
                                            <div class="col-xs-12">
                                                <button data-dismiss="modal" type="submit" class="btn btn-primary btn-xl">Log in</button>
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
        <script src="{!! asset('lib/jquery/jquery.min.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('js/main.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('lib/bootstrap/dist/js/bootstrap.min.js') !!}" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                //initialize the javascript
                App.init();
                $('#username').focus();
            });

        </script>
    </body>
</html>