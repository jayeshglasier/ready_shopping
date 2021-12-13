<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>View Mobile - Ready Shopping</title>
  <!--------- Begin Css Style --------->
  @include('layouts.form-side-css')
  <!--------- End Css Style --------->
</head>
<style type="text/css">
  .category-option{
    font-size: 13px;
    padding: 10px 15px;
  }
  .require-star{
  color: red !important;
  }
  .invoice-number {
    float: right;
    font-size: 20px;
    font-weight: 700;
    margin-top: -45px;
}
</style>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <!--------- Begin Header --------->
      @include('layouts.header')
      <!--- End Header  -------->
      <div class="main-sidebar sidebar-style-2">
        <!--------- Begin Sidebar  --------->
        @include('layouts.sidebar')
        <!--------- End Sidebar --------->
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
            
                  <div class="card-body">
                    <!--------- Begin Message Notification --------->
                    @include('layouts.form-side-message')
                    <!--------- End Message Notification --------->
                    
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h3><span style="color: white;background-color: #ff665e;padding: 0px 6px 0px 6px;">R</span><span style="color: black;">eqdeal</span></h3>
                      <div class="invoice-number">Order  #{{ $datarecord->ord_order_id }}</div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>Billed To:</strong><br>
                          VAGHELA BHARATBHAI R<br>
                          ચાળવા,લાખણી<br>
                          9978291640, 9978291640
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Shipped To:</strong><br>
                           {{ $datarecord->use_full_name }}<br>
                            {{ $datarecord->ord_shipped_to }}<br>
                          {{ $datarecord->ord_phone_number }}<br>
                          {{ $datarecord->ord_alternate_number }}
                        </address>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>Payment Method:</strong><br>
                         {{ $datarecord->ord_shipping_method }}
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Order Date:</strong><br>
                          {{ date('d-M-Y',strtotime($datarecord->ord_order_date)) }}<br><br>
                        </address>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">Order Summary</div>
                    <!-- <p class="section-lead">All items here cannot be deleted.</p> -->
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tbody><tr>
                          <th data-width="40" style="width: 40px;">Sr.No</th>
                          <th>Item</th>
                          <th class="text-center">Price</th>
                          <th class="text-center">Quantity</th>
                          <th class="text-right">Totals</th>
                        </tr>
                        <?php $i=0; ?>@foreach($ordersummary as $order) <?php $i++; ?>
                        <tr>
                          <td class="text-center">{{$i}}</td>
                          <td>{{ $order->pod_pro_name }}</td>
                          <td class="text-center" width="10%">{{ $order->ors_unit_per_price }}</td>
                          <td class="text-center" width="10%">{{ $order->ors_qty_ordered }}</td>
                          <td class="text-right" width="10%">{{ $order->ors_sub_total }} ₹</td>
                        </tr>
                        @endforeach
                      </tbody></table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="section-title">Notices:</div>
                        <p class="section-lead"></p>
                      </div>
                      <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Subtotal</div>
                          <div class="invoice-detail-value">{{$grandtotal}} ₹</div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Shipping Fee</div>
                          <div class="invoice-detail-value">00 ₹</div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Total</div>
                          <div class="invoice-detail-value invoice-detail-value-lg">{{$grandtotal}} ₹</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">
                  <!-- <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Process
                    Payment</button> -->
                  <button class="btn btn-danger btn-icon icon-left"><a href="{{ url('orders-list/0') }}" style="color: #fff;"><i class="fas fa-times"></i> Back</a></button>
                </div>
                <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
              </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
      </section>
    </div>
    <!--------- End Main Content --------->
    <!--------- Begin Footer  --------->
    @include('layouts.footer')
    <!--------- End Footer --------->
  </div>
  </div>
</body>
</html>
@include('layouts.form-side-js')