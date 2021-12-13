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
                                          <h5 class="font-15">Total Seller</h5>
                                          <h2 class="mb-3 font-18">{{$totalSeller}}</h2>
                                          <p class="mb-0"><a href="{{ url('sellers') }}" class="card-footer card-link text-center big">View All</a></p>
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
                                          <h5 class="font-15"> Customers</h5>
                                          <h2 class="mb-3 font-18">{{$totalCustomer}}</h2>
                                          <p class="mb-0"><a href="{{ url('users') }}" class="card-footer card-link text-center big">View All</a></p>
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
                                          <h5 class="font-15">Total Pending Order</h5>
                                          <h2 class="mb-3 font-18">{{$pendingOrder}}</h2>
                                          <p class="mb-0"><a href="{{ url('dashboard-today-order') }}" class="card-footer card-link text-center big">View All Order</a></p>
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
                          <!--   <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <div class="card">
                                <div class="card-statistic-4">
                                  <div class="align-items-center justify-content-between">
                                    <div class="row ">
                                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                          <h5 class="font-15">Revenue</h5>
                                          <h2 class="mb-3 font-18">$48,697</h2>
                                          <p class="mb-0"><span class="col-green">42%</span> Increase</p>
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
                            </div> -->
                          </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-12 col-xl-6">
                                <!-- Support tickets -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4>New Feedback (Month <?php echo date('M-Y') ?>)</h4>
                                        <form class="card-header-form">
                                            <input type="text" name="search" class="form-control" placeholder="Search">
                                        </form>
                                    </div>
                                    <div class="card-body">
                                      @foreach($feedbacks as $feedback)
                                        <div class="support-ticket media pb-1 mb-3">
                                            <img src="{{ asset('public/assets/img/users/user-3.png') }}" class="user-img mr-2" alt="">
                                            <div class="media-body ml-3">
                                                <div class="badge badge-pill badge-success mb-1 float-right">{{ $feedback->use_full_name }}</div> <span class="font-weight-bold">{{ $feedback->use_full_name }}</span>
                                                <a href="javascript:void(0)">{{ $feedback->use_phone_no }}</a>
                                                <p class="my-1">Feedback :  {{ $feedback->fed_content }}</p> 
                                                Date: {{ date('d-M-Y',strtotime($feedback->fed_createat)) }}
                                            </div>
                                        </div>
                                        @endforeach
                                    </div> <a href="{{ url('feedback') }}" class="card-footer card-link text-center small ">View All</a>
                                </div>
                                <!-- Support tickets -->
                            </div>
                            <!-- <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Projects Payments</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Client Name</th>
                                                        <th>Date</th>
                                                        <th>Payment Method</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>John Doe</td>
                                                        <td>11-08-2018</td>
                                                        <td>NEFT</td>
                                                        <td>$258</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Cara Stevens</td>
                                                        <td>15-07-2018</td>
                                                        <td>PayPal</td>
                                                        <td>$125</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Airi Satou</td>
                                                        <td>25-08-2018</td>
                                                        <td>RTGS</td>
                                                        <td>$287</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>Angelica Ramos</td>
                                                        <td>01-05-2018</td>
                                                        <td>CASH</td>
                                                        <td>$170</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Ashton Cox</td>
                                                        <td>18-04-2018</td>
                                                        <td>NEFT</td>
                                                        <td>$970</td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>John Deo</td>
                                                        <td>22-11-2018</td>
                                                        <td>PayPal</td>
                                                        <td>$854</td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td>Hasan Basri</td>
                                                        <td>07-09-2018</td>
                                                        <td>Cash</td>
                                                        <td>$128</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
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