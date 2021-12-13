@include('layouts.header')
@include('layouts.sidebar')
<link href="{{ asset('public/new-theam/jasny-bootstrap/css/jasny-bootstrap.css')}}" rel="stylesheet" />
<link href="{{ asset('public/css/form-style.css') }}" rel="stylesheet">
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h4 class="page-header">System Setting</h4>
        </div>
    <!------------------------------------------------ Success Message Display Start Here ------------------------>
       @include('layouts.message-notification')
    <!---------------------------------------------- Success Message Display Start Here ------------------------------->
    </div>
   
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b><i class="fa fa-cubes" aria-hidden="true"></i> System Setting</b>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('save-system-setting') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="Sys_Unique_Id" value="{{ isset($editdata->Sys_Unique_Id) ? $editdata->Sys_Unique_Id : '' }}">
                    <div class="col-lg-8">
                        <div class="form-group{{ $errors->has('Sys_Name') ? ' has-error' : '' }}">
                            <label for="Sys_Name" class="col-md-4 control-label">System Name<font color="red">*</font></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="Sys_Name" name="Sys_Name" placeholder="System Name" value="{{ isset($editdata->Sys_Name) ? $editdata->Sys_Name : '' }}" maxlength="100" autofocus>
                                @if ($errors->has('Sys_Name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('Sys_Name') }}</strong>
                                </span> 
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('Sys_Title') ? ' has-error' : '' }}">
                            <label for="Sys_Title" class="col-md-4 control-label">System Title<font color="red">*</font></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="Sys_Title" name="Sys_Title" placeholder="System Title" value="{{ isset($editdata->Sys_Title) ? $editdata->Sys_Title : '' }}" maxlength="100">
                                @if ($errors->has('Sys_Title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('Sys_Title') }}</strong>
                                </span> 
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Sys_Address" class="col-md-4 control-label">Address<font color="red">*</font></label>
                            <div class="col-md-8">
                                <textarea id="Sys_Address" type="text" class="form-control" name="Sys_Address" placeholder="Address" rows="5">{{ isset($editdata->Sys_Address) ? $editdata->Sys_Address : '' }}</textarea>
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="Sys_Phone" class="col-md-4 control-label">Phone<font color="red">*</font></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="Sys_Phone" name="Sys_Phone" placeholder="Phone" value="{{ isset($editdata->Sys_Phone) ? $editdata->Sys_Phone : '' }}" maxlength="10">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Sys_Email" class="col-md-4 control-label">Email<font color="red">*</font></label>
                            <div class="col-md-8">
                                <input type="Email" class="form-control" id="Sys_Email" name="Sys_Email" placeholder="Email" value="{{ isset($editdata->Sys_Email) ? $editdata->Sys_Email : '' }}" maxlength="100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Sys_App_Key" class="col-md-4 control-label">Dropbox App Key</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="Sys_App_Key" name="Sys_App_Key" placeholder="Dropbox App Key" value="{{ isset($editdata->Sys_App_Key) ? $editdata->Sys_App_Key : '' }}" maxlength="30">
                            </div>
                        </div>   
                         <div class="form-group">
                            <label for="Sys_Logo" class="col-md-4 control-label">Upload Logo</label>
                            <div class="col-md-8">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">Select file</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="Sys_Logo">
                                        </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>     
                    </div>

                    <div class="col-lg-4">  
                        <div class="form-group">
                            <label for="Sys_Logo" class="col-md-4 control-label">Old Logo</label>
                            <div class="col-md-8">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                     <img src="{{ asset('public/images/system').'/'.$editdata->Sys_Logo }}" style="height: 150px;width:150px;" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- /.col-lg-6 (nested) -->
            </div>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<!---------------------- New Theam Javascript---------------->
</body>

</html>

<script src="{{ asset('public/new-theam/js/app.js')}}" type="text/javascript"></script>
<script src="{{ asset('public/new-theam/jasny-bootstrap/js/jasny-bootstrap.js')}}"></script>
<script src="{{ asset('public/new-theam/js/pages/form_examples.js')}}"></script>
<!---------------------- New Theam Javascript---------------->

<script src="{{ asset('public/js/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="{{ asset('public/js/metisMenu.min.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset('public/js/startmin.js') }}"></script>
<script type="text/javascript"> 
  $(document).ready( function() {
    $('.flash-message').delay(3000).fadeOut();
  });
</script>