<aside class="main-sidebar sidebar-dark-primary elevation-3">
    <div href="#" class="brand-link">
      <img src="{{Auth::user()->getProfile()}}"  class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name') }}</span>

    </div>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ Auth::user()->getProfile() }}" class="img-circle elevation-2" >
        </div>
        <div class="info">
          <div href="#" class="d-block text-white">{{ Auth::user()->getName() }}</div>
        </div>
      </div>


      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
            <a href="{{ route('reports.home') }}" class="nav-link {{ activeSegment('reports') }}">
                <i class="nav-icon fas fa-solid fa-desktop"></i>
                <p>
               Dashboard
                </p>
            </a>
        </li>

          <li class="nav-item">
            <a href="{{ route('orders.index') }}" class="nav-link {{ activeSegment('orders') }}">
                <i class="nav-icon fas fa-solid fa-desktop"></i>
              <p>
                Report
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('cart.index') }}" class="nav-link {{ activeSegment('cart') }}">
                <i class="nav-icon fas fa-cart-plus"></i>
              <p>
                POS System
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('products.index') }}" class="nav-link {{ activeSegment('products') }}">
              <i class="nav-icon fas fa-solid fa-image"></i>
              <p>
                Product
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('customers.index') }}" class="nav-link {{ activeSegment('customers') }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customer
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('settings.index') }}" class="nav-link {{ activeSegment('settings') }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Setting
              </p>
            </a>
          </li>

          <li class="nav-item menu-open">
            <a href="{{ route('logout') }}" class="nav-link "
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
               <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>

        </ul>
      </nav>
    </div>

  </aside>
