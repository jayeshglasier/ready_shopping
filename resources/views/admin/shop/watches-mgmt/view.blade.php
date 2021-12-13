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
  ul {
    list-style-type: none;
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
      <div class="main-content" style="padding-top: 90px;">
        <section class="section">
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-4">
                <div class="card author-box">
                  <div class="card-header">
                    <h4>Product Details</h4>
                    <div class="row right-15">
                      <div class="col-12"> <a href="{{ url('watches') }}" class="btn btn-primary"><i class="fas fa-list mr-2"></i>Watches List</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="author-box-center text-center">
                      <img alt="image" src="{{ asset('public/assets/img/products/'.$viewdata->pod_picture) }}" class="rounded-circle author-box-picture" width="200px" height="200px">
                      </div>
                      <div class="author-box-name text-center">
                        <a href="#">{{ $viewdata->pod_pro_id ? $viewdata->pod_pro_id : '' }}</a>
                      </div>
                    <div class="text-center">
                      <div class="author-box-description">
                        <p>{{ $viewdata->pod_pro_name ? $viewdata->pod_pro_name : '' }}</p>
                      </div>
                      <div class="mb-2 mt-3">
                        <div class="font-weight-bold">{{ $viewdata->pod_price ? $viewdata->pod_price : '0.00' }} -/</div>
                      </div>
                      <div class="w-100 d-sm-none"></div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Other Details</h4>
                  </div>
                  <div class="card-body">
                   
                      <p class="clearfix">
                        <span class="float-left">Colour</span>
                        <span class="float-right text-muted">{{ $viewdata->pod_colour ? $viewdata->pod_colour : '---' }}</span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">Size</span>
                        <span class="float-right text-muted">{{ $viewdata->pod_size ? $viewdata->pod_size : '---' }}</span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">Order With In</span>
                        <span class="float-right text-muted">{{ $viewdata->pod_ord_within ? $viewdata->pod_ord_within : '---' }}</span>
                      </p>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-8">
                <div class="card">
                  <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab" aria-selected="false">About</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab" aria-selected="true">Images</a>
                      </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade active show" id="about" role="tabpanel" aria-labelledby="home-tab2">
                        <div class="row">
                          <div class="col-md-3 col-6 b-r">
                            <strong>Brand Name</strong>
                            <br>
                            <p class="text-muted">{{ $viewdata->pod_brand_name ? $viewdata->pod_brand_name : '' }}</p>
                          </div>
                          <div class="col-md-3 col-6 b-r">
                            <strong>Price</strong>
                            <br>
                            <p class="text-muted">{{ $viewdata->pod_price ? $viewdata->pod_price : '0.00' }} -/</p>
                          </div>
                          <div class="col-md-3 col-6 b-r">
                            <strong>Offer Price</strong>
                            <br>
                            <p class="text-muted">{{ $viewdata->pod_offer_price ? $viewdata->pod_offer_price : '0.00' }} -/</p>
                          </div>
                          <div class="col-md-3 col-6">
                            <strong>Made In</strong>
                            <br>
                            <p class="text-muted">{{ $viewdata->pod_made_in ? $viewdata->pod_made_in : '' }}</p>
                          </div>
                        </div>
                        <div class="section-title" style="margin: 0px 0 7px 0;">Description</div>
                        <ul>
                          <li>{!! nl2br(e($viewdata->pod_pro_description ? $viewdata->pod_pro_description : '')) !!} 
                          </li>
                        </ul>
                      </div>
                      <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                        <form method="post" class="needs-validation">
                          <div class="card-header">
                            <h4>Upload Images</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="form-group col-md-12 col-12">
                                <label>Upload Images</label>
                                <input type="file" class="form-control" value="John">
                                <div class="invalid-feedback">
                                  Please fill in the first name
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-footer text-right">
                            <div class="col-12 text-center mt-3">
                              <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="far fa-save"></i> Save</button> <a href="{{ url('/view-watches/'.$viewdata->pod_unique_id) }}" class="btn btn-icon icon-left btn-secondary ml-2"><i class="fas fa-times"></i> Cancel</a>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
       <!--------- Begin Footer  --------->
    @include('layouts.footer')
    <!--------- End Footer --------->
  </div>
  </div>
</body>
</html>
@include('layouts.form-side-js')