
<!-- General JS Scripts -->
<script src="{{ asset('public/assets/js/app.min.js') }}"></script>
<!-- JS Libraies -->
<!-- Template JS File -->
<script src="{{ asset('public/assets/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('public/assets/js/custom.js') }}"></script>

<script src="{{ asset('public/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('public/assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('public/assets/bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('public/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>

<script type="text/javascript"> 
    $(document).ready( function() {
      $('.flash-message').delay(4000).fadeOut();
    });
</script>
<script type="text/javascript"> 
    $(document).ready( function() {
      $('.flash-error-message').delay(9000).fadeOut();
    });
</script>