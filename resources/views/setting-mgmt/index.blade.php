<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Setting - Ready Shopping</title>
  <!--------- Begin Css Style --------->
  @include('layouts.form-side-css')
  <!--------- End Css Style --------->
</head>
<style type="text/css">
  .require-star{
  color: red !important;
  }
  .help-block{
  color: #eb0808;
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
      <!--------- Begin Main Content --------->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Setting</h4>
                    <div class="row right-15">
                      <div class="col-12"> <a href="#" class="btn btn-primary"><i class="fas fa-list mr-2"></i>Setting</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--------- Begin Message Notification --------->
                    @include('layouts.form-side-message')
                    <!--------- End Message Notification --------->
                    
                    <!--------- Begin Form  --------->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('update-setting') }}" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Razorpay Key Id<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="sys_razorpay_key_id" id="sys_razorpay_key_id" placeholder="Enter razorpay key id" value="{{ $editRecord->sys_razorpay_key_id }}" required maxlength="200" autofocus>
                            @if($errors->has('sys_razorpay_key_id')) 
                              <span class="help-block">
                                <strong>{{ $errors->first('sys_razorpay_key_id') }}</strong>
                              </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row bordr-top">
                        <div class="col-12 mt-3">
                          <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="far fa-save"></i> Update</button>
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