<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>View Product - Ready Shopping</title>
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
                  <div class="card-header">
                    <h4>Product Detail</h4>
                    <div class="row right-15">
                      <div class="col-12"> <a href="{{ url('products') }}" class="btn btn-primary"><i class="fas fa-list mr-2"></i>Product List</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--------- Begin Message Notification --------->
                    @include('layouts.form-side-message')
                    <!--------- End Message Notification --------->
                    <div class="table-responsive">
                          <table class="table table-bordered table-striped">
                              <tbody>
                                  <tr>
                                      <th width="20%"><i class="fa fa-cubes" aria-hidden="true"></i> Product Code</th>
                                      <td>{{ $viewdata->pod_pro_id ? $viewdata->pod_pro_id : '' }}</td>
                                  </tr>
                                  <tr>
                                      <th width="20%"><i class="fa fa-cubes" aria-hidden="true"></i> Product Name</th>
                                      <td>{{ $viewdata->pod_pro_name ? $viewdata->pod_pro_name : '' }}</td>
                                  </tr> 
                                  <tr>
                                      <th width="20%"><i class="fa fa-cubes" ></i> Brand</th>
                                      <td>{{ $viewdata->pod_brand_name ? $viewdata->pod_brand_name : '' }}</td>
                                  </tr>
                                  <tr>
                                      <th width="20%"><i class="fa fa-cubes" ></i> Description</th>
                                      <td>{{ $viewdata->pod_pro_description ? $viewdata->pod_pro_description : 'NA' }}</td>
                                  </tr>
                                  <tr>
                                      <th width="20%"><i class="fa fa-cubes" ></i> Price</th>
                                      <td>{{ $viewdata->pod_price ? $viewdata->pod_price : '0.00' }} -/</td>
                                  </tr>
                                  <tr>
                                      <th width="20%"><i class="fa fa-cubes" ></i> Offer Price</th>
                                      <td>{{ $viewdata->pod_offer_price ? $viewdata->pod_offer_price : '0.00' }} -/</td>
                                  </tr>
                                  <tr>
                                      <th width="20%"><i class="fa fa-cubes" ></i> Quantity</th>
                                      <td>{{ $viewdata->Quantity ? $viewdata->Quantity : '1' }}</td>
                                  </tr>
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
    <!--------- End Main Content --------->
    <!--------- Begin Footer  --------->
    @include('layouts.footer')
    <!--------- End Footer --------->
  </div>
  </div>
</body>
</html>
@include('layouts.form-side-js')