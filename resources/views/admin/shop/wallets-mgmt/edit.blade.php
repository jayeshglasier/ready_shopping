<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Update Wallet - Ready Shopping</title>
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
                    <h4>Update Wallet <small>(Wallet can be managed from here)</small></h4>
                    <div class="row right-15">
                      <div class="col-12"> <a href="{{ url('/walletes') }}" class="btn btn-primary"><i class="fas fa-list mr-2"></i>Walletes List</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--------- Begin Message Notification --------->
                    @include('layouts.form-side-message')
                    <!--------- End Message Notification --------->
                    <!--------- Begin Form  --------->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('update-walletes') }}" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <input type="hidden" class="form-control" name="pod_id" id="pod_id" value="{{ $editData->pod_id }}" required>
                      <span class="require-star">* Required</span>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Wallet Title<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="pod_pro_name" id="pod_pro_name" placeholder="Wallet Title" value="{{ $editData->pod_pro_name }}" required maxlength="200">
                            @if($errors->has('pod_pro_name')) <span class="help-block">
                                <strong>{{ $errors->first('pod_pro_name') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-3">
                          <div class="form-group">
                            <label>Brand Name<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="pod_brand_name" id="pod_brand_name" placeholder="Brand Name" value="{{ $editData->pod_brand_name }}" required maxlength="200">
                            @if($errors->has('pod_brand_name')) <span class="help-block">
                                <strong>{{ $errors->first('pod_brand_name') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                         <div class="col-12 col-md-3">
                          <div class="form-group">
                            <label>Type</label>
                            <select name="pod_choose_type" id="pod_choose_type" class="pod_choose_type form-control selectric">
                              @foreach($choosetype as $type)
                              <option value="{{ $type->coo_id }}" @if($editData->pod_choose_type == $type->coo_id) selected="true" @endif>{{ $type->coo_name}}</option>
                              @endforeach
                              </select>
                               @if($errors->has('pod_choose_type')) <span class="help-block">
                                  <strong>{{ $errors->first('pod_choose_type') }}</strong>
                                  </span> 
                              @endif
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-3">
                          <div class="form-group">
                            <label>Category<span class="require-star">*</span></label>
                            <select name="pod_cat_id" id="pod_cat_id" class="form-control pod_cat_id" required="">
                              @foreach($categorysList as $cat)
                              <option value="{{ $cat->cat_id }}" @if($editData->pod_cat_id == $cat->cat_id) selected="true" @endif>{{ $cat->cat_name}}</option>
                              @endforeach
                            </select>
                             @if($errors->has('pod_cat_id')) <span class="help-block">
                                <strong>{{ $errors->first('pod_cat_id') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-3">
                          <div class="form-group">
                            <label>Sub Category</label>
                            <select name="pod_sub_cat_id" id="pod_subcatId" class="pod_sub_cat_id form-control">
                              @foreach($subCategorysList as $subcategory)
                              <option value="{{ $subcategory->sub_id }}" @if($editData->pod_sub_cat_id == $subcategory->sub_id) selected="true" @endif>{{ $subcategory->sub_cat_name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label>Wallet Discription<span class="require-star">*</span></label>
                            <textarea rows="8" class="form-control" name="pod_pro_description" id="pod_pro_description" placeholder="Write here wallet description...">{{ $editData->pod_pro_description }}</textarea>
                             @if($errors->has('pod_pro_description')) <span class="help-block">
                                <strong>{{ $errors->first('pod_pro_description') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label>Return Policy</label>
                            <textarea rows="8" class="form-control" name="pod_return_policy" id="pod_return_policy" placeholder="Ex :  30 Day Free Returns & Exchange ">{{ $editData->pod_return_policy }}</textarea>
                             @if($errors->has('pod_return_policy')) <span class="help-block">
                                <strong>{{ $errors->first('pod_return_policy') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-3">
                          <div class="form-group">
                            <label>Price<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="pod_price" id="pod_price" placeholder="0.0" value="{{ $editData->pod_price }}" pattern="^\d*(\.\d{0,2})?$" onkeyup="onlyNumbricDecimal(this);" maxlength="10" required>
                            @if($errors->has('pod_price')) <span class="help-block">
                                <strong>{{ $errors->first('pod_price') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-3">
                          <div class="form-group">
                            <label>Quantity<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="pod_quantity" id="pod_quantity" placeholder="0" value="{{ $editData->pod_quantity }}" required maxlength="10" onkeyup="onlyNumbric(this);">
                            @if($errors->has('pod_quantity')) <span class="help-block">
                                <strong>{{ $errors->first('pod_quantity') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                        <div class="col-12 col-md-2 mt-35">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input customCheck1" name="pod_deal_of_day" id="customCheck1" value="1">
                            <label class="custom-control-label" for="customCheck1">Deal of the day</label>
                          </div>
                        </div>
                         <div class="col-12 col-md-3" id="offer_price_div" style="display: none;">
                          <div class="form-group">
                            <label>Offer Price</label>
                            <input type="text" class="form-control cntDecimalvalue pod_offer_price" name="pod_offer_price" id="pod_offer_price" placeholder="0.0" value="{{ $editData->pod_offer_price }}" pattern="^\d*(\.\d{0,2})?$" onkeyup="onlyNumbricDecimal(this);" maxlength="10" required>
                            @if($errors->has('pod_offer_price')) <span class="help-block">
                                <strong>{{ $errors->first('pod_offer_price') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-12 col-md-3">
                          <div class="form-group">
                            <label>Made In<span class="require-star">*</span></label>
                            <input type="text" class="form-control" name="pod_made_in" id="pod_made_in" placeholder="Made In" value="{{ $editData->pod_made_in }}" required maxlength="40">
                            @if($errors->has('pod_made_in')) <span class="help-block">
                                <strong>{{ $errors->first('pod_made_in') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                         <div class="col-12 col-md-3">
                          <div class="form-group">
                            <label>Colour</label>
                                <?php $prod_colour = explode(",",$editData->pod_colour); //print_r($prod_colour);exit;?>
                                <select name="pod_colour[]" id="pod_colour" class="pod_colour form-control  select2" multiple="multiple">
                                    <option value="">Select Color</option>
                                    @foreach ($colors as $colors_list)
                                        <option value="{{ $colors_list->col_name }}" @if(in_array($colors_list->col_name,$prod_colour)) selected="selected" @endif>{{ $colors_list->col_name }}</option>
                                    @endforeach
                              </select>    
                            @if($errors->has('pod_colour')) <span class="help-block">
                                <strong>{{ $errors->first('pod_colour') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                         <div class="col-12 col-md-3">
                          <div class="form-group">
                            <label>Order WithIn</label>
                             <input type="text" class="form-control" name="pod_ord_within" id="pod_ord_within" placeholder="Ex : 2 days" value="{{ $editData->pod_ord_within }}" maxlength="50">
                            @if($errors->has('pod_ord_within')) <span class="help-block">
                                <strong>{{ $errors->first('pod_ord_within') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>

                       <div class="row">
                         <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Wallet Picture</label>
                            <input type="file" class="form-control" name="pod_picture" id="pod_picture">
                            @if($errors->has('pod_picture')) <span class="help-block">
                                <strong>{{ $errors->first('pod_picture') }}</strong>
                                </span> 
                            @endif
                          </div>
                        </div>
                      </div>
                      <a href="{{ asset('public/assets/img/products/'.$editData->pod_picture) }}" target="_blank">Wallet Picture</a>
                       <div class="row bordr-top">
                        <div class="col-12 text-center mt-3">
                          <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="far fa-save"></i> Update</button> <a href="{{ url('/walletes') }}" class="btn btn-icon icon-left btn-secondary ml-2"><i class="fas fa-times"></i> Cancel</a>
                        </div>
                      </div>
                    </form>
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
$(document).ready(function () {
    $('#customCheck1').change(function () {
        if (!this.checked) 
          
         $('#offer_price_div').fadeOut('slow');
        else 
          $('#offer_price_div').fadeIn('slow');
         
    });
});
</script>
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

    function onlyNumbricDecimal(numbric) {
        var maintainplus = '';
        var numval = numbric.value
        if (numval.charAt(0) == '+') {
            var maintainplus = '';
        }
        curnumbricvar = numval.replace(/[\\A-Za-z!"£$%^&\,*+_={};:'@#~,Š\/<>?|`¬\]\[]/g, '');
        numbric.value = maintainplus + curnumbricvar;
        var maintainplus = '';
        numbric.focus;
    }

    function onlyCharacter(alphabet) {
        var maintainplus = '';
        var numval = alphabet.value
        if (numval.charAt(0) == '+') {
            var maintainplus = '';
        }
        curalphabetvar = numval.replace(/[\\0-9!"£$%^&\,*+_={};:'@#~,.Š\/<>?|`¬\]\[]/g, '');
        alphabet.value = maintainplus + curalphabetvar;
        var maintainplus = '';
        alphabet.focus;
    }

    $(document).on('keydown', 'input[pattern]', function(e){
      var input = $(this);
      var oldVal = input.val();
      var regex = new RegExp(input.attr('pattern'), 'g');

      setTimeout(function(){
        var newVal = input.val();
        if(!regex.test(newVal)){
          input.val(oldVal); 
        }
      }, 0);
    });
</script>
<script>
  $("#pod_main_cat_id").on('change',function(){
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

                      $(".pod_cat_id option").each(function() {
                          $(this).remove();
                      });
                      var items = [];
                       $.each( data, function( key, val ) {
                          items.push( "<option value='" +this['cat_id']+"' class='category-option'>" + this['cat_name'] +"</option>" );
                       });
                      $("#pod_cat_id").append('<option value="">-- Select Category --</option>');
                      $("#pod_cat_id").append(items);
                  },
              error : function(error){
                  console.log(error);
              }
          });
      });
</script>
<script>
  $("#pod_cat_id").on('change',function(){
          var categoryId = $(this).val();
          $.ajax({
              type : "POST",
              url : "{{ url('sub-category-products') }}",
              data : {
                  _token: '{{ csrf_token() }}',
                  category_id : categoryId
              },
              dataType : "JSON",
              success : function(data){

                      $(".pod_sub_cat_id option").each(function() {
                          $(this).remove();
                      });
                      var items = [];
                       $.each( data, function( key, val ) {
                          items.push( "<option value='" +this['sub_id']+"' class='category-option'>" + this['sub_cat_name'] +"</option>" );
                       });
                      $("#pod_subcatId").append('<option value="">-- Select Subcategory --</option>');
                      $("#pod_subcatId").append(items);
                  },
              error : function(error){
                  console.log(error);
              }
          });
      });
</script>