<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Add Category - Ready Shopping</title>
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
                    <h4>Add Category</h4>
                    <div class="row right-15">
                      <div class="col-12"> <a href="{{ url('sub-category') }}" class="btn btn-primary"><i class="fas fa-list mr-2"></i>Category List</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--------- Begin Message Notification --------->
                    @include('layouts.form-side-message')
                    <!--------- End Message Notification --------->

                    <!--------- Begin Form  --------->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('store-sub-category') }}" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Main Category<span class="require-star">*</span></label>
                            <select class="form-control selectric" name="sub_main_cat_id" id="sub_main_cat_id" required>
                              <option value="">Select Main Category</option>
                              @foreach($mainCategorys as $category)
                              <option value="{{ $category->mac_id }}">{{ $category->mac_title}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Category Name<span class="require-star">*</span></label>
                            <select name="sub_cat_id" id="pod_subcatId" class="sub_cat_id form-control">
                              <option value="">---- Select Main Category -----</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Subcategory Name<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="sub_cat_name" id="sub_cat_name" placeholder="Subcategory Name" value="{{ old('sub_cat_name') }}" required>
                            @if($errors->has('sub_cat_name')) <span class="help-block">
                                <strong>{{ $errors->first('sub_cat_name') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Picture<span class="require-star">*</span></label>
                            <input type="file" class="form-control" name="sub_picture" id="sub_picture" required>
                            @if($errors->has('sub_picture')) <span class="help-block">
                                <strong>{{ $errors->first('sub_picture') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row bordr-top">
                        <div class="col-12 text-center mt-3">
                          <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="far fa-save"></i> Save</button> <a href="{{ url('sub-category') }}" class="btn btn-icon icon-left btn-secondary ml-2"><i class="fas fa-times"></i> Cancel</a>
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
<script>
  $("#sub_main_cat_id").on('change',function(){
          var categoryId = $(this).val();
          $.ajax({
              type : "POST",
              url : "{{ url('category-list') }}",
              data : {
                  _token: '{{ csrf_token() }}',
                  category_id : categoryId
              },
              dataType : "JSON",
              success : function(data){

                      $(".sub_cat_id option").each(function() {
                          $(this).remove();
                      });
                      var items = [];
                       $.each( data, function( key, val ) {
                          items.push( "<option value='" +this['cat_id']+"' class='category-option'>" + this['cat_name'] +"</option>" );
                       });
                      $("#pod_subcatId").append('<option value="">-- Select Category --</option>');
                      $("#pod_subcatId").append(items);
                  },
              error : function(error){
                  console.log(error);
              }
          });
      });
</script>