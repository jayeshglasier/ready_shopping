<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Update Category - Ready Shopping</title>
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
      <!-- Begin Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Update Category</h4>
                    <div class="row right-15">
                      <div class="col-12"> <a href="{{ url('category') }}" class="btn btn-primary"><i class="fas fa-list mr-2"></i>Category List</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--------- Begin Message Notification --------->
                    @include('layouts.form-side-message')
                    <!--------- End Message Notification --------->

                    <!--------- Begin Form  --------->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('update-category') }}" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <input type="hidden" class="form-control" name="cat_id" id="cat_id" value="{{ $editData->cat_id }}" required>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Main Category<span class="require-star">*</span></label>
                            <select class="form-control selectric" name="cat_main_id" id="cat_main_id" required>
                              @foreach($mainCategorys as $category)
                              <option value="{{ $category->mac_id }}" @if($editData->cat_main_id == $category->mac_id) selected="true" @endif>{{ $category->mac_title}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Category Name<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="cat_name" id="cat_name" placeholder="Category Name" value="{{ $editData->cat_name }}" maxlength="60" required>
                            @if($errors->has('cat_name')) <span class="help-block">
                                <strong>{{ $errors->first('cat_name') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Picture</label>
                            <input type="file" class="form-control" name="cat_picture" id="cat_picture">
                            @if($errors->has('cat_picture')) <span class="help-block">
                                <strong>{{ $errors->first('cat_picture') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Old Picture</label>
                            <img src="{{ asset('public/assets/img/category/'.$editData->cat_picture) }}" align="center" class="center" style="width: 150px;height: 100px;">
                          </div>
                        </div>
                      </div>
                      <div class="row bordr-top">
                        <div class="col-12 text-center mt-3">
                          <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="far fa-save"></i> Update</button> <a href="{{ url('category') }}" class="btn btn-icon icon-left btn-secondary ml-2"><i class="fas fa-times"></i> Cancel</a>
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