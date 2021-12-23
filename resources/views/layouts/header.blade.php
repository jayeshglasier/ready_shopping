<nav class="navbar navbar-expand-lg main-navbar sticky">
  <div class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"> <i data-feather="align-justify"></i></a>
      </li>
      <li><a href="#" class="nav-link nav-link-lg fullscreen-btn"> <i data-feather="maximize"></i></a>
      </li>
      <li>
        <form class="form-inline mr-auto">
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
            <button class="btn" type="submit"> <i class="fas fa-search"></i>
            </button>
          </div>
        </form>
      </li>
    </ul>
  </div>
  <ul class="navbar-nav navbar-right">
    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
      <span class="badge headerBadge1">6 </span> </a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
        <div class="dropdown-header">Messages
          <div class="float-right"> <a href="#">Mark All As Read</a></div>
        </div>
        <div class="dropdown-list-content dropdown-list-message">
          <a href="#" class="dropdown-item"> 
            <span class="dropdown-item-avatar text-white"> 
              <img alt="image" src="{{ asset('public/assets/img/users/user-1.png') }}" class="rounded-circle">
            </span>  
            <span class="dropdown-item-desc"> <span class="message-user">John Deo</span>
              <span class="time messege-text">Please check your mail !!</span>
              <span class="time">2 Min Ago</span>
            </span>
          </a>
        </div>
        <div class="dropdown-footer text-center"> <a href="#">View All <i class="fas fa-chevron-right"></i></a>
        </div>
      </div>
    </li>
    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
            </a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
        <div class="dropdown-header">Notifications
          <div class="float-right"> <a href="#">Mark All As Read</a></div>
        </div>
        <div class="dropdown-list-content dropdown-list-icons">
          <a href="#" class="dropdown-item dropdown-item-unread"> 
            <span class="dropdown-item-icon bg-primary text-white"> <i class="fas fa-code"></i></span>  
            <span class="dropdown-item-desc"> Template update is available now! <span class="time">2 Min Ago</span></span>
          </a>
        </div>
        <div class="dropdown-footer text-center"> <a href="#">View All <i class="fas fa-chevron-right"></i></a>
        </div>
      </div>
    </li>
    <li style="margin-top: 10px;">{{ Auth::user()->use_full_name}}</li>
    <li class="dropdown dropdown-list-toggle">
      <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-user">
        <img alt="image" src="{{ asset('public/assets/img/users/'.Auth::user()->use_image) }}" class="user-img-radious-style"> 
        <span class="d-sm-none d-lg-inline-block"></span>
      </a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
        <div class="dropdown-list-content dropdown-list-icons">
          <div class="dropdown-title">Hello {{ Auth::user()->use_full_name}}</div>
          <a href="{{ url('user-profile') }}" class="dropdown-item has-icon"> <i class="far fa-user"></i> Profile</a>
          <a href="{{ url('setting') }}" class="dropdown-item has-icon"> <i class="fas fa-cog"></i> Settings</a>
          <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i> Policy</a>
          <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
            Logout</a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
      </div>
    </li>
  </ul>
</nav>