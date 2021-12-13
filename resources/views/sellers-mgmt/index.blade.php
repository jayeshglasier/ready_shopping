<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sellers Record - Ready Shopping</title>
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
                                        <h4>Sellers Details</h4>
                                        <div class="row right-15">
                                            <div class="col-12"> <a href="{{ url('create-sellers') }}" class="btn btn-primary" data-toggle="tooltip" title="Add Seller!"><i class="fas fa-plus mr-2"></i>Add Seller</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--------- Begin Message Notification --------->
                                        @include('layouts.grid-side-message')
                                    <!--------- End Message Notification --------->
                                    <div class="card-body">
                                        <form class="form-horizontal" role="form" method="get" action="{{ url('/sellers') }}">
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
                                                            <option value="id" @if($sortBy=='id' ) selected="true" @endif>Sort By Sr.No</option>
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
                                                        <th>Profile</th>
                                                        <th>Fullname</th>
                                                        <th>Shop Name</th>
                                                        <th>Village</th>
                                                        <th>Taluka</th>
                                                        <th>Mobile Number</th>
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
                                                        <td width="5%">
                                                        @if($data->use_image)
                                                        <a href="{{ asset('public/assets/img/users/'.$data->use_image) }}" target="_blank"><img src="{{ asset('public/assets/img/users/'.$data->use_image) }}" align="center" class="center" style="width: 60px;height: 50px;padding: 5px;"></a>
                                                        @else
                                                         <a href="{{ asset('public/assets/img/default-profile-img.jpg') }}" target="_blank"><img src="{{ asset('public/assets/img/default-profile-img.jpg') }}" align="center" class="center" style="width: 60px;height: 50px;padding: 5px;"></a>
                                                        @endif
                                                        </td>
                                                        <td>{{ $data->use_full_name }}</td>
                                                        <td>{{ $data->use_shop_name }}</td>
                                                        <td>{{ $data->use_village_name }}</td>
                                                        <td>{{ $data->use_taluka }}</td>
                                                        <td>{{ $data->use_phone_no }}
                                                            @if($data->use_alt_mobile_number){{ ', '.$data->use_alt_mobile_number }} @endif</td>
                                                        <td>
                                                            <div class="material-switch" style="margin-left: -15px;">
                                                                <input id="switch-primary-{{$data->id}}" value="{{$data->id}}" name="toggle" type="checkbox" {{ $data->use_status === 0 ? 'checked' : '' }}>
                                                                <label for="switch-primary-{{$data->id}}" class="btn-success"></label>
                                                            </div>
                                                        </td>
                                                        <td class="text-center" width="15%">
                                                            <!--------- Begin Edit Link --------->
                                                            <a href="{{ url('edit-sellers',$data->id) }}" class="btn btn-icon btn-primary mr-1" data-toggle="tooltip" title="Edit Seller!"><i class="far fa-edit"></i>
                                                            </a>
                                                            <!--------- End Edit Link --------->
                                                            <!--------- Begin Delete Link --------->
                                                            <a href="{{ url('delete-sellers',$data->id) }}" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" title="Delete Seller!">
                                                                <button class="btn btn-icon btn-danger"><i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </a>
                                                            <!--------- End Delete Link --------->
                                                        </td>
                                                    </tr>
                                                    @endforeach 
                                                    @else
                                                    <td colspan="8" style="text-align: center;">Record not available!</td>
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
      url:"{{ url('/status-sellers') }}",
      data : {
            _token: '{{ csrf_token() }}',
            mode : mode,
            id:id
            },
      success:function(data)
      {
        if(data.status == "true")
        {
          alert("Seller active successfully.");
        }
        else if(data.status == "false")
        {
          alert("Seller inactive successfully.");
        }
      }
    });
    }); 
</script>