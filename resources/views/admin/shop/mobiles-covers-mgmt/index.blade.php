<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Chasma Products Record - Ready Shopping</title>
    <!--------- Begin Css Style  --------->
    @include('layouts.grid-side-css')
    <!--------- End Css Style   --------->
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
                                        <h4>Chasma Products</h4>
                                        <div class="row right-15">
                                            <div class="col-12"> <a href="{{ url('create-mobiles-covers') }}" class="btn btn-primary" data-toggle="tooltip" title="Add Chasma!"><i class="fas fa-plus mr-2"></i>Add Chasma</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--------- Begin Message Notification --------->
                                        @include('layouts.grid-side-message')
                                    <!--------- End Message Notification --------->
                                    <div class="card-body">
                                        <form class="form-horizontal" role="form" method="get" action="{{ url('/mobiles-covers') }}">
                                            <div class="row">
                                                <div class="col-12 col-md-3 filter-forms" style="padding-right: 0px;padding-left: 10px;">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="search" value="{{ $search ? $search : '' }}" placeholder="Search Here...">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-2 filter-forms" style="max-width: 10.333% !important;padding-right: 0px;padding-left: 10px;">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="page" value="{{ $pageGoto ? $pageGoto : '' }}" placeholder="Go To">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-2 filter-forms" style="padding-right: 0px;padding-left: 10px;">
                                                    <div class="form-group">
                                                        <select class="form-control selectric" name="sort_by" required>
                                                            <option value="pod_id" @if($sortBy=='pod_id' ) selected="true" @endif>Sort By Sr.No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @include('support.table-header-manu')
                                            </div>
                                        </form>
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th>Sr.No</th>
                                                        <th>Product Code</th>
                                                        <th>Product Name</th>
                                                        <th>Brand Name</th>
                                                        <th>Category</th>
                                                        <th>Sub Category</th>
                                                        <th>Price</th>
                                                        <th>Offer Price</th>
                                                        <th>Quantity</th>
                                                        <th>Stock</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>@if(count($datarecords) > 0)
                                                    <?php $i=0 ; ?>@foreach($datarecords as $data) <?php $i++; ?>
                                                    <tr>@if($pageOrder == "ASC")
                                                        <td class="text-center" width="5%">{{ ($datarecords->currentpage()-1) * $datarecords->perpage() + $i}}</td>@endif @if($pageOrder == "DESC")
                                                        <td class="text-center" width="5%">{{ substr(($datarecords->currentpage()-1) * $datarecords->perpage() + $i - ($datarecords->total()+1),1)}}</td>
                                                        @endif
                                                        <td>{{ $data->pod_pro_id }}</td>
                                                        <td>{{ str_limit($data->pod_pro_name,30) }}</td>
                                                        <td>{{ $data->pod_brand_name }}</td>
                                                        <td>{{ $data->cat_name }}</td>
                                                        <td>{{ $data->sub_cat_name ? $data->sub_cat_name: '---' }}</td>
                                                        <td>{{ $data->pod_price }} -/</td>
                                                        <td>{{ $data->pod_offer_price }} -/</td>
                                                        <td>{{ $data->pod_quantity }}</td>
                                                        <td>{{ $data->pod_stock }}</td>
                                                        <td>
                                                            <div class="material-switch" style="margin-left: -15px;">
                                                                <input id="switch-primary-{{$data->pod_id}}" value="{{$data->pod_id}}" name="toggle" type="checkbox" {{ $data->pod_status === 0 ? 'checked' : '' }}>
                                                                <label for="switch-primary-{{$data->pod_id}}" class="btn-success"></label>
                                                            </div>
                                                        </td>
                                                        <td class="text-center" width="15%">
                                                            <!--------- Begin Edit Link --------->
                                                            <a href="{{ url('edit-mobiles-covers',$data->pod_unique_id) }}" class="btn btn-icon btn-primary mr-1" data-toggle="tooltip" title="Edit Product!"><i class="far fa-edit"></i>
                                                            </a>
                                                            <!--------- End Edit Link --------->
                                                             <!--------- Begin View Link --------->
                                                            <a href="{{ url('view-mobiles-covers',$data->pod_unique_id) }}" class="btn btn-icon btn-success mr-1" data-toggle="tooltip" title="View Product!"><i class="far fa-eye"></i>
                                                            </a>
                                                            <!--------- End Edit Link --------->
                                                            <!--------- Begin Delete Link --------->
                                                            <a href="{{ url('delete-mobiles-covers',$data->pod_unique_id) }}" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" title="Delete Product!">
                                                                <button class="btn btn-icon btn-danger"><i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </a>
                                                            <!--------- End Delete Link --------->
                                                        </td>
                                                    </tr>
                                                    @endforeach 
                                                    @else
                                                    <td colspan="12" style="text-align: center;">Record not available!</td>
                                                    @endif
                                                </tbody>
                                            </table>
                                            @include('support.pagination')
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
@include('layouts.grid-side-js')
<script type="text/javascript">
 $('input[name=toggle]').change(function(){
    var mode= $(this).prop('checked');
    var id= $(this).val();
    $.ajax({
      type:"POST",
      dataType:"JSON",
      url:"{{ url('/status-mobiles-covers') }}",
      data : {
            _token: '{{ csrf_token() }}',
            mode : mode,
            pod_id:id
            },
      success:function(data)
      {
        if(data.status == "true")
        {
          alert("Product active successfully.");
        }
        else if(data.status == "false")
        {
          alert("Product inactive successfully.");
        }
      }
    });
    }); 
</script>