@if(session('success'))
  <div class="col-lg-6">
  <div class="flash-message" style="margin-bottom: -20px;">
      <div class="alert alert-info" style="text-align: center;">
          <span class="success-message"><big>{{ session('success') }}</big></span>
      </div>
  </div>
  </div>
  @endif 
  @if(session('error'))
  <div class="col-lg-6" style="margin-bottom: -20px;">
    <div class="flash-message">
        <div class="alert alert-danger" style="text-align: center;">
            <span class="error-message"><big>{{ session('error') }}</big></span>
        </div>
    </div>
  </div>
@endif