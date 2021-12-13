<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Update Banner - Ready Shopping</title>
  <!--------- Begin Css Style --------->
  @include('layouts.form-side-css')
  <!--------- End Css Style --------->
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
                    <h4>Update Banner</h4>
                    <div class="row right-15">
                      <div class="col-12"> <a href="{{ url('banners') }}" class="btn btn-primary"><i class="fas fa-list mr-2"></i>Banners List</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--------- Begin Message Notification --------->
                    @include('layouts.form-side-message')
                    <!--------- End Message Notification --------->

                    <!--------- Begin Form  --------->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('update-banners') }}" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <input type="hidden" class="form-control" name="ban_unique_id" id="ban_unique_id" value="{{ $editData->ban_unique_id }}">
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Title<span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="ban_title" id="ban_title" placeholder="Title" value="{{ $editData->ban_title }}" required maxlength="100">
                            @if($errors->has('ban_title')) <span class="help-block">
                                <strong>{{ $errors->first('ban_title') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Banner Picture</label>
                            <input type="file" class="form-control" name="ban_picture" id="ban_picture">
                            @if($errors->has('ban_picture')) <span class="help-block">
                                <strong>{{ $errors->first('ban_picture') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div><a href="{{ asset('public/assets/img/banners/'.$editData->ban_picture) }}" target="_blank">Banner Picture</a></div>
                      <div class="row bordr-top">
                        <div class="col-12 text-center mt-3">
                          <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="far fa-save"></i> Update</button> <a href="{{ url('banners') }}" class="btn btn-icon icon-left btn-secondary ml-2"><i class="fas fa-times"></i> Cancel</a>
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