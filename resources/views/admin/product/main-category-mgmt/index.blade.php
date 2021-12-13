<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Main Category Record - Ready Shopping</title>
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
                                        <h4>Main Category</h4>
                                        <div class="row right-15">
                                            <div class="col-12"> <a href="{{ url('create-main-category') }}" class="btn btn-primary" data-toggle="tooltip" title="Add Record!"><i class="fas fa-plus mr-2"></i>Add Main Category</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--------- Begin Message Notification --------->
                                    @include('layouts.grid-side-message')
                                    <!--------- End Message Notification --------->
                                    <div class="card-body">
                                        <form class="form-horizontal" role="form" method="get" action="{{ url('/main-category') }}">
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
                                                @include('support.table-header-manu')
                                            </div>
                                        </form>
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th>Sr.No</th>
                                                        <th>Main Category Name</th>
                                                        <th>Description</th>
                                                        <!-- <th>Status</th> -->
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>@if(count($datarecords) > 0)
                                                    <?php $i=0 ; ?>@foreach($datarecords as $data) <?php $i++; ?>
                                                    <tr>@if($pageOrder == "ASC")
                                                        <td class="text-center" width="5%">{{ ($datarecords->currentpage()-1) * $datarecords->perpage() + $i}}</td>@endif @if($pageOrder == "DESC")
                                                        <td class="text-center" width="5%">{{ substr(($datarecords->currentpage()-1) * $datarecords->perpage() + $i - ($datarecords->total()+1),1)}}</td>
                                                        @endif
                                                        <td>{{ $data->mac_title}}</td>
                                                        <td>{{ $data->mac_description }}</td>
                                                       <!--  <td>
                                                            <div class="material-switch" style="margin-left: -15px;">
                                                                <input id="switch-primary-{{$data->mac_id}}" value="{{$data->mac_id}}" name="toggle" type="checkbox" {{ $data->mac_status === 0 ? 'checked' : '' }}>
                                                                <label for="switch-primary-{{$data->mac_id}}" class="btn-success"></label>
                                                            </div>
                                                        </td> -->
                                                        <td class="text-center" width="15%">
                                                            <!--------- Begin Edit Link --------->
                                                            <a href="{{ url('edit-main-category',$data->mac_id) }}" class="btn btn-icon btn-primary mr-1" data-toggle="tooltip" title="Edit Record!"><i class="far fa-edit"></i>
                                                            </a>
                                                            <!--------- End Edit Link --------->
                                                        </td>
                                                    </tr>
                                                    @endforeach 
                                                    @else
                                                    <td colspan="6" style="text-align: center;">Record not available!</td>
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
      url:"{{ url('/status-main-category') }}",
      data : {
            _token: '{{ csrf_token() }}',
            mode : mode,
            mac_id:id
            },
      success:function(data)
      {
        if(data.status == "true")
        {
          alert("Main Category active successfully.");
        }
        else if(data.status == "false")
        {
          alert("Main Category inactive successfully.");
        }
      }
    });
    }); 
</script>