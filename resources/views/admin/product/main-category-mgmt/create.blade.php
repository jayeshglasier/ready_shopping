<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Add Main Category - Ready Shopping</title>
  <!--------- Begin Css Style --------->
  @include('layouts.form-side-css')
  <!--------- End Css Style --------->
  <style type="text/css">
  .category-option{
    font-size: 13px;
    padding: 10px 15px;
  }
  .require-star{
  color: red !important;
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
      <!--------- Begin Main Content --------->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Add Main Category</h4>
                    <div class="row right-15">
                      <div class="col-12"> <a href="{{ url('main-category') }}" class="btn btn-primary"><i class="fas fa-list mr-2"></i>Main Category List</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--------- Begin Message Notification --------->
                    @include('layouts.form-side-message')
                    <!--------- End Message Notification --------->

                    <!--------- Begin Form  --------->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('store-main-category') }}">
                      {{ csrf_field() }}
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Category Name<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="mac_title" id="mac_title" placeholder="Category Name" value="{{ old('mac_title') }}" maxlength="90" required>
                            @if($errors->has('mac_title')) <span class="help-block">
                                <strong>{{ $errors->first('mac_title') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Description<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="mac_description" id="mac_description" placeholder="Description" value="{{ old('mac_description') }}" maxlength="200" required>
                            @if($errors->has('mac_description')) <span class="help-block">
                                <strong>{{ $errors->first('mac_description') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row bordr-top">
                        <div class="col-12 text-center mt-3">
                          <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="far fa-save"></i> Save</button> <a href="{{ url('main-category') }}" class="btn btn-icon icon-left btn-secondary ml-2"><i class="fas fa-times"></i> Cancel</a>
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