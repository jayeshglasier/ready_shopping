<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Feedback Record - Ready Shopping</title>
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
                                        <h4>Feedback Record</h4>
                                        <div class="row right-15">
                                            <div class="col-12"></div>
                                        </div>
                                    </div>
                                    <!--------- Begin Message Notification --------->
                                        @include('layouts.grid-side-message')
                                    <!--------- End Message Notification --------->
                                    <div class="card-body">
                                        <form class="form-horizontal" role="form" method="get" action="{{ url('/products') }}">
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
                                                        <th>Customer Name</th>
                                                        <th>Mobile Number</th>
                                                        <th>Feedback</th>
                                                        <th>Date</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>@if(count($datarecords) > 0)
                                                    <?php $i=0 ; ?>@foreach($datarecords as $data) <?php $i++; ?>
                                                    <tr>@if($pageOrder == "ASC")
                                                        <td class="text-center" width="5%">{{ ($datarecords->currentpage()-1) * $datarecords->perpage() + $i}}</td>@endif @if($pageOrder == "DESC")
                                                        <td class="text-center" width="5%">{{ substr(($datarecords->currentpage()-1) * $datarecords->perpage() + $i - ($datarecords->total()+1),1)}}</td>
                                                        @endif
                                                        <td>{{ $data->use_full_name }}</td>
                                                        <td>{{ $data->use_phone_no }}</td>
                                                        <td>{{ $data->fed_content }}</td>
                                                        <td>{{ $data->fed_createat }}</td>
                                                        <td class="text-center" width="15%">
                                                          
                                                            <!--------- Begin Delete Link --------->
                                                            <a href="{{ url('delete-feedback',$data->fed_id) }}" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" title="Delete Product!">
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
      url:"{{ url('/status-products') }}",
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