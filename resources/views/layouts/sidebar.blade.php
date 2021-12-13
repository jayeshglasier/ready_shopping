<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="{{ url('/home') }}">
      <img alt="image" src="{{ asset('public/assets/img/logo.png')}}" class="header-logo"  style="height: 111px;margin-top: -22px;" /> 
    </a>
  </div>
  <ul class="sidebar-menu">
     <li class="dropdown {{ request()->is('*home*') ? 'active' : '' }}"> <a href="{{ url('/home') }}" class="nav-link"><i class="fab fa-first-order"></i><span>Dashboard</span></a>
    </li>
    <li class="dropdown {{ request()->is('*products*') ? 'active' : '' || request()->is('*mobiles*') ? 'active' : '' || request()->is('*seller-products*') ? 'active' : '' || request()->is('*category*') ? 'active' : '' || request()->is('*sub-category*') ? 'active' : '' }}"> <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Products</span></a>
      <ul class="dropdown-menu">
        <li class="{{ request()->is('*products*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/products') }}">Products</a></li>
        <li class="{{ request()->is('*mobiles*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/mobiles') }}">Smart Phones</a></li>
        <li class="{{ request()->is('*seller-products*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/seller-products') }}">Seller Products</a></li>
        <li class="{{ request()->is('*main-category*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/main-category') }}">Main Category</a></li>
        <li class="{{ request()->is('*category*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/category') }}">Category</a></li>
        <li class="{{ request()->is('*color*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/color') }}">Color</a></li>
        <li class="{{ request()->is('*sub-category*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/sub-category') }}">Sub Category</a></li>
      </ul>
    </li>
    <li class="dropdown {{ request()->is('*users*') ? 'active' : '' }}"> <a href="{{ url('/users') }}" class="nav-link"><i class="fas fa-address-card"></i><span>User Details</span></a>
    </li>
    <li class="dropdown {{ request()->is('*sellers*') ? 'active' : '' || request()->is('*sellers-bank-accounts*') ? 'active' : '' || request()->is('*delivery-boys*') ? 'active' : '' }}"> <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-bag"></i><span>Seller Details</span></a>
      <ul class="dropdown-menu">
        <li class="{{ request()->is('*sellers*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/sellers') }}">Seller Details</a></li>
        <li class="{{ request()->is('*sellers-bank-accounts*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/sellers-bank-accounts') }}">Seller Bank Details</a></li>
        <li class="{{ request()->is('*delivery-boys*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/delivery-boys') }}">Delivery Boy</a></li>
      </ul>
    </li>
     <li class="dropdown {{ request()->is('*orders-list/0*') ? 'active' : '' || request()->is('*orders-list/1*') ? 'active' : '' || request()->is('*orders-list/2*') ? 'active' : '' || request()->is('*orders-list/3*') ? 'active' : '' }}"> <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-bag"></i><span>Order Details</span></a>
      <ul class="dropdown-menu">
        <!-- pending: 0 delivery : 1 confirm: 2 cancle: 3  -->
       <!--  <li><a class="nav-link" href="{{ url('/orders-list/4') }}">All Order List</a></li> -->
        <li class="{{ request()->is('*orders-list/0*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/orders-list/0') }}">Pending Order</a></li>
        <li class="{{ request()->is('*orders-list/1*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/orders-list/1') }}">Delivery Order</a></li>
        <li class="{{ request()->is('*orders-list/2*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/orders-list/2') }}">Confirm Order</a></li> 
        <li class="{{ request()->is('*orders-list/3*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/orders-list/3') }}">Cancle Order</a></li>
      </ul>
    </li>
    <!-- <li class="dropdown"> <a href="{{ url('/product-delivery') }}" class="nav-link"><i data-feather="package"></i><span>Delivery Details</span></a></li> -->
    <li class="dropdown {{ request()->is('*clothes*') ? 'active' : '' || request()->is('*watches*') ? 'active' : '' || request()->is('*shoes*') ? 'active' : '' || request()->is('*beltes*') ? 'active' : '' || request()->is('*walletes*') ? 'active' : ''  || request()->is('*mobiles-covers*') ? 'active' : '' || request()->is('*gadget*') ? 'active' : '' || request()->is('*children-toys*') ? 'active' : '' || request()->is('*girl-beauty*') ? 'active' : '' }}"> <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-bag"></i><span>Shop</span></a>
      <ul class="dropdown-menu">
        <li class="{{ request()->is('*clothes*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/clothes') }}">Cloth <b class="shop-product-count">({{ $clothes }})</b></a></li>
        <li class="{{ request()->is('*watches*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/watches') }}">Watch <b class="shop-product-count">({{ $watches }})</b></a></li>
        <li class="{{ request()->is('*shoes*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/shoes') }}">Shoes <b class="shop-product-count">({{ $shoes }})</b></a></li>
        <li class="{{ request()->is('*beltes*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/beltes') }}">Belt <b class="shop-product-count">({{ $beltes }})</b></a></li>
        <li class="{{ request()->is('*walletes*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/walletes') }}">Wallet <b class="shop-product-count">({{ $walletes }})</b></a></li>
        <li class="{{ request()->is('*mobiles-covers*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/mobiles-covers') }}">Chasma <b class="shop-product-count">({{ $mobilesCovers }})</b></a></li>
        <li class="{{ request()->is('*gadget*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/gadget') }}">Gadget <b class="shop-product-count">({{ $gadget }})</b></a></li>
        <li class="{{ request()->is('*children-toys*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/children-toys') }}">Toys <b class="shop-product-count">({{ $childrenToys }})</b></a></li>
        <li class="{{ request()->is('*girl-beauty*') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/girl-beauty') }}">Girl Beauty <b class="shop-product-count">({{ $girlBeauty }})</b></a></li>
      </ul>
    </li>
    <li class="dropdown {{ request()->is('*villages*') ? 'active' : '' }}"> <a href="{{ url('/villages') }}" class="nav-link"><i data-feather="home"></i><span>Village</span></a></li>
    <li class="dropdown {{ request()->is('*banners*') ? 'active' : '' }}"> <a href="{{ url('/banners') }}" class="nav-link"><i data-feather="home"></i><span>Banner</span></a></li>
    <li class="dropdown {{ request()->is('*feedback*') ? 'active' : '' }}"> <a href="{{ url('/feedback') }}" class="nav-link"><i data-feather="home"></i><span>Feedback</span></a></li>
  </ul>
</aside>