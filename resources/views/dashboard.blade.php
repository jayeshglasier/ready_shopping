<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Projects Management System</title>
  <link rel="icon" type="image/ico" href="{{ asset('public/images/Login/titleimg.png') }}" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@include('layouts.header')
@include('layouts.sidebar')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('dashboard.dashboard') }}</h1>
        </div>
    </div>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $totalmonthtaskcompleted ? $totalmonthtaskcompleted : '0' }}</div>
                            <div>{{ trans('dashboard.Task Completed this month') }}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('tasks') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ trans('dashboard.View Details') }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $totaltodaytaskcompleted ? $totaltodaytaskcompleted : '0' }}</div>
                            <div>{{ trans('dashboard.Task Completed Today') }}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('tasks') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ trans('dashboard.View Details') }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $totaltodaytaskcreated ? $totaltodaytaskcreated : '0' }}</div>
                            <div>{{ trans('dashboard.Task Created Today') }}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('tasks') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ trans('dashboard.View Details') }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-bars fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $totalclients ? $totalclients : '0' }}</div>
                            <div>{{ trans('dashboard.Total Clients') }}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('clients') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ trans('dashboard.View Details') }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>Notice Board</b>
                </div>
                <div class="panel-body">
                    @foreach($noticeboards as $notice)
                    <blockquote>
                        <p>{{ str_limit($notice->Not_Notice ? $notice->Not_Notice : 'No any notice',200)  }}</p>
                        <small>{{ $notice->Use_Full_Name ? $notice->Use_Full_Name : '-' }} Date
                            <cite>{{ date('d-m-Y', strtotime(str_replace('/', '-', $notice->Not_CreatedAt))) }}</cite>
                        </small>
                    </blockquote>
                    @endforeach
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
</div>

<script src="{{ asset('public/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('public/js/startmin.js') }}"></script>
</body>
</html>
