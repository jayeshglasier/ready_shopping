<!DOCTYPE html>
<html lang="en">
<!-- datatables.html  21 Nov 2019 03:55:21 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Ready Shopping - Dashboard</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/app.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('public/assets/img/logo.png')}}" />
    <style type="text/css">
      .user-img{
        height: 80PX;
      }
      .card .card-statistic-4 .banner-img img {
    max-width: 100%;
    float: right;
    height: 100px;
}
    </style>
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('layouts.header')
            <div class="main-sidebar sidebar-style-2">
            @include('layouts.sidebar')
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-body">

                        <div class="row ">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <div class="card">
                                <div class="card-statistic-4">
                                  <div class="align-items-center justify-content-between">
                                    <div class="row ">
                                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                          <h5 class="font-15">Today Pending Order</h5>
                                          <h2 class="mb-3 font-18">{{$pendingOrder}}</h2>
                                          <p class="mb-0"><a href="{{ url('orders-list/0') }}" class="card-footer card-link text-center big">View All</a></p>
                                        </div>
                                      </div>
                                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                          <img src="{{ asset('public/assets/admin/img/banner/1.png') }}" alt="">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <div class="card">
                                <div class="card-statistic-4">
                                  <div class="align-items-center justify-content-between">
                                    <div class="row ">
                                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                          <h5 class="font-15"> Today Delivery Order</h5>
                                          <h2 class="mb-3 font-18">{{$deliveryOrder}}</h2>
                                          <p class="mb-0"><a href="{{ url('orders-list/1') }}" class="card-footer card-link text-center big">View All</a></p>
                                        </div>
                                      </div>
                                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                          <img src="{{ asset('public/assets/admin/img/banner/2.png') }}" alt="">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <div class="card">
                                <div class="card-statistic-4">
                                  <div class="align-items-center justify-content-between">
                                    <div class="row ">
                                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                          <h5 class="font-15">Today Confirm Order</h5>
                                          <h2 class="mb-3 font-18">{{$confirmOrder}}</h2>
                                          <p class="mb-0"><a href="{{ url('orders-list/2') }}" class="card-footer card-link text-center big">View All</a></p>
                                        </div>
                                      </div>
                                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                          <img src="{{ asset('public/assets/admin/img/banner/3.png') }}" alt="">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <div class="card">
                                <div class="card-statistic-4">
                                  <div class="align-items-center justify-content-between">
                                    <div class="row ">
                                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                          <h5 class="font-15">Today Cancle Order</h5>
                                          <h2 class="mb-3 font-18">{{$cancleOrder}}</h2>
                                          <p class="mb-0"><a href="{{ url('orders-list/3') }}" class="card-footer card-link text-center big">View All</a></p>
                                        </div>
                                      </div>
                                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                          <img src="{{ asset('public/assets/admin/img/banner/4.png') }}" alt="">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                           <!-- // pending: 0 delivery : 1 confirm: 2 cancle: 3     -->
                        <div class="row">
                           <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Pending Order <small>(<?php echo date('d-M-Y'); ?>)</small></h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                              @if(count($pendings) > 0)
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Order Id</th>
                                                        <th>Customer Name</th>
                                                        <th>Mobile Number</th>
                                                        <th>Payment Method</th>
                                                        
                                                    </tr>
                                                </thead>
                                                @endif
                                                <tbody>
                                                  @if(count($pendings) > 0)
                                                    <?php $i=0 ; ?>@foreach($pendings as $pending) <?php $i++; ?>
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td><a href="{{ url('customer-invoice',$pending->ord_order_id) }}">{{$pending->ord_order_id}}</a></td>
                                                        <td>{{$pending->ord_full_name}}</td>
                                                        <td>{{$pending->ord_phone_number}}</td>
                                                        <td>{{$pending->ord_pay_method}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <div class="jumbotron text-center">
                                                        <h4>No any Pending Order</h4>
                                                      <a class="btn btn-primary mt-3" href="{{ url('orders-list/0') }}" target="_blank" role="button">View All</a>
                                                    </div>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Delivery Order <small>(<?php echo date('d-M-Y'); ?>)</small></h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                              @if(count($deliverys) > 0)
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Order Id</th>
                                                        <th>Customer Name</th>
                                                        <th>Mobile Number</th>
                                                        <th>Payment Method</th>
                                                        
                                                    </tr>
                                                </thead>
                                                @endif
                                                <tbody>
                                                  @if(count($deliverys) > 0)
                                                    <?php $i=0 ; ?>@foreach($deliverys as $delivery) <?php $i++; ?>
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td><a href="{{ url('customer-invoice',$delivery->ord_order_id) }}">{{$delivery->ord_order_id}}</a></td>
                                                        <td>{{$delivery->ord_full_name}}</td>
                                                        <td>{{$delivery->ord_phone_number}}</td>
                                                        <td>{{$delivery->ord_pay_method}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                     <div class="jumbotron text-center">
                                                        <h4>No any Delivery Order</h4>
                                                      <a class="btn btn-primary mt-3" href="{{ url('orders-list/1') }}" target="_blank" role="button">View All</a>
                                                    </div>
                                                  @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                           <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Confirm Order <small>(<?php echo date('d-M-Y'); ?>)</small></h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                              @if(count($confirms) > 0)
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Order Id</th>
                                                        <th>Customer Name</th>
                                                        <th>Mobile Number</th>
                                                        <th>Payment Method</th>
                                                        
                                                    </tr>
                                                </thead>
                                                @endif
                                                <tbody>
                                                  @if(count($confirms) > 0)
                                                    <?php $i=0 ; ?>@foreach($confirms as $confirm) <?php $i++; ?>
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td><a href="{{ url('customer-invoice',$confirm->ord_order_id) }}">{{$confirm->ord_order_id}}</a></td>
                                                        <td>{{$confirm->ord_full_name}}</td>
                                                        <td>{{$confirm->ord_phone_number}}</td>
                                                        <td>{{$confirm->ord_pay_method}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                     <div class="jumbotron text-center">
                                                        <h4>No any Confirm Order</h4>
                                                      <a class="btn btn-primary mt-3" href="{{ url('orders-list/2') }}" target="_blank" role="button">View All</a>
                                                    </div>
                                                  @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Cancle Order <small>(<?php echo date('d-M-Y'); ?>)</small></h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                              @if(count($cancles) > 0)
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Order Id</th>
                                                        <th>Customer Name</th>
                                                        <th>Mobile Number</th>
                                                        <th>Payment Method</th>
                                                        
                                                    </tr>
                                                </thead>
                                                @endif
                                                <tbody>
                                                  @if(count($cancles) > 0)
                                                    <?php $i=0 ; ?>@foreach($cancles as $cancle) <?php $i++; ?>
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td><a href="{{ url('customer-invoice',$cancle->ord_order_id) }}">{{$cancle->ord_order_id}}</a></td>
                                                        <td>{{$cancle->ord_full_name}}</td>
                                                        <td>{{$cancle->ord_phone_number}}</td>
                                                        <td>{{$cancle->ord_pay_method}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                     <div class="jumbotron text-center">
                                                        <h4>No any Cancle Order</h4>
                                                      <a class="btn btn-primary mt-3" href="{{ url('orders-list/3') }}" target="_blank" role="button">View All</a>
                                                    </div>
                                                  @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            @include('layouts.footer')</div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('public/assets/js/app.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('public/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('public/assets/js/custom.js') }}"></script>
</body>
<!-- datatables.html  21 Nov 2019 03:55:25 GMT -->
</html>