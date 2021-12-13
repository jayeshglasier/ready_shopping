<!DOCTYPE html>
<html lang="en">
<!-- datatables.html  21 Nov 2019 03:55:21 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login - Ready Shopping</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/app.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('public/assets/img/favicon-icon.png')}}" />
</head>
<style type="text/css">
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 70%;
        }
        .alert{
            padding:5px !important;
            margin-bottom:10px !important;
        }
        .login-panel {
            margin-top: 0%;
        }
        .btn-primary:hover{
            color: #fff;
        }
    </style>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" style="top:100px;background-color: #fff;left:33%;">
                <img src="{{ asset('public/assets/img/logo.png')}}" align="center" class="center" style="border-radius:50%;margin-bottom: 10px;margin-top: -50px;">
                <div class="login-panel panel panel-default" style="border-top-left-radius: 50px;border-top-right-radius: 50px;border-radius:15px;">
                    <div class="panel-heading" style="margin-top: -60px;margin-bottom: 20px;">
                        <h3 class="panel-title" style="text-align: center;color: orange;">Sign In</h3>
                    </div>
                    <div class="panel-body">
                        @if(session('error'))
                        <div class="flash-message" style="padding-top: 5px;">
                            <div class="alert alert-danger" style="text-align: center;"> 
                                <span class="error-message"><big>{{ session('error') }}</big></span>
                            </div>
                        </div>
                        @endif
                        <form role="form" method="POST" action="{{ url('user-login') }}">{{ csrf_field() }}
                            <fieldset>
                                <div class="form-group">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Id" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" class="form-control" name="password" required placeholder="********">
                                </div>
                                <div class="checkbox">
                                    <label><input name="remember" type="checkbox" value="Remember Me">  Remember Me</label>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary btn-block" style="background-color: orange;font-size: 20px;">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
