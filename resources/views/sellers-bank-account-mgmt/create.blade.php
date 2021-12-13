<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Add Seller Bank Detail - Ready Shopping</title>
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
                    <h4>Add Seller Bank Detail</h4>
                    <div class="row right-15">
                      <div class="col-12"> <a href="{{ url('sellers-bank-accounts') }}" class="btn btn-primary"><i class="fas fa-list mr-2"></i>Sellers Bank Detail</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--------- Begin Message Notification --------->
                    @include('layouts.form-side-message')
                    <!--------- End Message Notification --------->

                    <!--------- Begin Form  --------->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('store-sellers-bank-accounts') }}">
                      {{ csrf_field() }}
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Seller Name<span class="require-star">*</span></label>
                             <select class="form-control selectric" name="sbd_seller_id" id="sbd_seller_id" required>
                              <option value="">Select Seller</option>
                              @foreach($sellers as $seller)
                              <option value="{{ $seller->id }}">{{ $seller->use_full_name }}</option>
                              @endforeach
                            </select>
                            @if($errors->has('sbd_seller_id')) <span class="help-block">
                                <strong>{{ $errors->first('sbd_seller_id') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Account Holder Name<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="sbd_holder_name" id="sbd_holder_name" placeholder="Account Holder Name" value="{{ old('sbd_holder_name') }}" required maxlength="100">
                            @if($errors->has('sbd_holder_name')) <span class="help-block">
                                <strong>{{ $errors->first('sbd_holder_name') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label>Bank Name<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="sbd_bank_name" id="sbd_bank_name" placeholder="Bank Name" value="{{ old('sbd_bank_name') }}" maxlength="250" required>
                            @if($errors->has('sbd_bank_name')) <span class="help-block">
                                <strong>{{ $errors->first('sbd_bank_name') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label>IAFC Code<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="sbd_iafc_code" id="sbd_iafc_code" placeholder="IAFC Code" value="{{ old('sbd_iafc_code') }}" required maxlength="20">
                            @if($errors->has('sbd_iafc_code')) <span class="help-block">
                                <strong>{{ $errors->first('sbd_iafc_code') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label>Branch<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="sbd_branch" id="sbd_branch" placeholder="Branch" value="{{ old('sbd_branch') }}" required maxlength="50">
                            @if($errors->has('sbd_branch')) <span class="help-block">
                                <strong>{{ $errors->first('sbd_branch') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label>Account Number<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="sbd_account_number" id="sbd_account_number" placeholder="Adhar Card Number" value="{{ old('sbd_account_number') }}" required maxlength="20">
                            @if($errors->has('sbd_account_number')) <span class="help-block">
                                <strong>{{ $errors->first('sbd_account_number') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label>Adhar Card Number<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="sbd_adhar_number" id="sbd_adhar_number" placeholder="Adhar Card Number" value="{{ old('sbd_adhar_number') }}" required maxlength="14" onkeyup="onlyNumbric(this)">
                            @if($errors->has('sbd_adhar_number')) <span class="help-block">
                                <strong>{{ $errors->first('sbd_adhar_number') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label>Pan Card Number (optional)</label>
                            <input type="text" class="form-control" name="sbd_pan_number" id="sbd_pan_number" placeholder="Pan Card Number" value="{{ old('sbd_pan_number') }}" maxlength="20">
                            @if($errors->has('sbd_pan_number')) <span class="help-block">
                                <strong>{{ $errors->first('sbd_pan_number') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row bordr-top">
                        <div class="col-12 text-center mt-3">
                          <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="far fa-save"></i> Save</button> <a href="{{ url('sellers-bank-accounts') }}" class="btn btn-icon icon-left btn-secondary ml-2"><i class="fas fa-times"></i> Cancel</a>
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