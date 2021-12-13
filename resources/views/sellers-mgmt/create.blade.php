<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Add Seller - Ready Shopping</title>
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
                    <h4>Seller Registration Form</h4>
                    <div class="row right-15">
                      <div class="col-12"> <a href="{{ url('sellers') }}" class="btn btn-primary"><i class="fas fa-list mr-2"></i>Sellers List</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--------- Begin Message Notification --------->
                    @include('layouts.form-side-message')
                    <!--------- End Message Notification --------->

                    <!--------- Begin Form  --------->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('store-sellers') }}" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Seller Name<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="use_full_name" id="use_full_name" placeholder="Seller Name" value="{{ old('use_full_name') }}" required maxlength="200" autofocus>
                            @if($errors->has('use_full_name')) <span class="help-block">
                                <strong>{{ $errors->first('use_full_name') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Shop Name<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="use_shop_name" id="use_shop_name" placeholder="Shop Name" value="{{ old('use_shop_name') }}" required maxlength="200">
                            @if($errors->has('use_shop_name')) <span class="help-block">
                                <strong>{{ $errors->first('use_shop_name') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label>Shop Address</label>
                            <input type="text" class="form-control" name="use_shop_address" id="use_shop_address" placeholder="Shop Address" value="{{ old('use_shop_address') }}" maxlength="250">
                            @if($errors->has('use_shop_address')) <span class="help-block">
                                <strong>{{ $errors->first('use_shop_address') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label>Village<span class="require-star">*</span></label>
                            <select class="form-control selectric" name="use_village_id" id="use_village_id" required>
                              <option value="">Select Village</option>
                              @foreach($villages as $village)
                              <option value="{{ $village->vil_id }}">{{ $village->vil_name }}</option>
                              @endforeach
                            </select>
                            @if($errors->has('use_village_id')) <span class="help-block">
                                <strong>{{ $errors->first('use_village_id') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label>Taluka<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="use_taluka" id="use_taluka" placeholder="Taluka" value="{{ old('use_taluka') }}" required maxlength="100">
                            @if($errors->has('use_taluka')) <span class="help-block">
                                <strong>{{ $errors->first('use_taluka') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label>Pincode<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="use_pincode" id="use_pincode" placeholder="Pincode" value="{{ old('use_pincode') }}" required maxlength="6" onkeyup="onlyNumbric(this)">
                            @if($errors->has('use_pincode')) <span class="help-block">
                                <strong>{{ $errors->first('use_pincode') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label>Mobile Number<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="use_phone_no" id="use_phone_no" placeholder="Mobile Number" value="{{ old('use_phone_no') }}" required maxlength="12" onkeyup="onlyNumbric(this)">
                            @if($errors->has('use_phone_no')) <span class="help-block">
                                <strong>{{ $errors->first('use_phone_no') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label>Alternet Mobile Number</label>
                            <input type="text" class="form-control" name="use_alt_mobile_number" id="use_alt_mobile_number" placeholder="Alternet Mobile Number" value="{{ old('use_alt_mobile_number') }}" maxlength="12" onkeyup="onlyNumbric(this)">
                            @if($errors->has('use_alt_mobile_number')) <span class="help-block">
                                <strong>{{ $errors->first('use_alt_mobile_number') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row">
                         <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Profile Picture</label>
                            <input type="file" class="form-control" name="use_image" id="use_image">
                            @if($errors->has('use_image')) <span class="help-block">
                                <strong>{{ $errors->first('use_image') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row bordr-top">
                        <div class="col-12 text-center mt-3">
                          <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="far fa-save"></i> Save</button> <a href="{{ url('sellers') }}" class="btn btn-icon icon-left btn-secondary ml-2"><i class="fas fa-times"></i> Cancel</a>
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
<script type="text/javascript">
    function onlyNumbric(numbric) {
        var maintainplus = '';
        var numval = numbric.value
        if (numval.charAt(0) == '+') {
            var maintainplus = '';
        }
        curnumbricvar = numval.replace(/[\\A-Za-z!"£$%^&\,*+_={};:'@#~,.Š\/<>?|`¬\]\[]/g, '');
        numbric.value = maintainplus + curnumbricvar;
        var maintainplus = '';
        numbric.focus;
    }
</script>