<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Assins Seller Order - Ready Shopping</title>
  <!--------- Begin Css Style --------->
  @include('layouts.form-side-css')
  <!--------- End Css Style --------->
  <style type="text/css">
    .require-star{
      color: red;
    }
  </style>
</head>
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
      <!-- Begin Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Assign Seller Order</h4>
                    <div class="row right-15">
                      <div class="col-12"> <a href="{{ url('orders-list',$editData->ord_order_status) }}" class="btn btn-primary"><i class="fas fa-list mr-2"></i>Category List</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--------- Begin Message Notification --------->
                    @include('layouts.form-side-message')
                    <!--------- End Message Notification --------->

                    <!--------- Begin Form  --------->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('update-assign-order') }}" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <input type="hidden" class="form-control" name="ord_unique_id" id="ord_unique_id" value="{{ $editData->ord_unique_id }}" required>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Seller<span class="require-star">*</span></label>
                            <select class="form-control selectric" name="ord_seller_id" id="ord_seller_id" required>
                              @foreach($sellers as $category)
                              <option value="{{ $category->id }}" @if($editData->ord_seller_id == $category->id) selected="true" @endif>{{ $category->use_full_name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Delivery Boy<span class="require-star">*</span></label>
                            <select class="form-control selectric" name="ord_delivery_boy_id" id="ord_delivery_boy_id" required>
                              @foreach($devlveryboys as $boys)
                              <option value="{{ $boys->id }}" @if($editData->ord_delivery_boy_id == $boys->id) selected="true" @endif>{{ $boys->use_full_name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Order Status<span class="require-star">*</span></label>
                            <select class="form-control selectric" name="ord_order_status" id="ord_order_status" required>
                              <option value="0" @if($editData->ord_order_status == "0") selected="true" @endif>Pending</option>
                              <option value="1" @if($editData->ord_order_status == "1") selected="true" @endif>Delivery</option>
                              <option value="2" @if($editData->ord_order_status == "2") selected="true" @endif>Confirm</option>
                              <option value="3" @if($editData->ord_order_status == "3") selected="true" @endif>Cancle</option>
                            </select>
                          </div>
                        </div>
                      </div>
                     
                      <div class="row bordr-top">
                        <div class="col-12 text-center mt-3">
                          <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="far fa-save"></i> Update</button> <a href="{{ url('orders-list',$editData->ord_order_status) }}" class="btn btn-icon icon-left btn-secondary ml-2"><i class="fas fa-times"></i> Cancel</a>
                        </div>
                      </div>
                    </form>
                    <!--------- End Form  --------->
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