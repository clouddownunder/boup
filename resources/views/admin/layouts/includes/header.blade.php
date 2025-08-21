<nav class="site-navbar navbar navbar-default navbar-inverse navbar-fixed-top navbar-mega"
    role="navigation">

    <div class="navbar-header">
      <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
        data-toggle="menubar">
        <span class="sr-only">Toggle navigation</span>
        <span class="hamburger-bar"></span>
      </button>
      <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
        data-toggle="collapse">
        <i class="icon md-more" aria-hidden="true"></i>
      </button>
      <div class="navbar-brand navbar-brand-center">
         <img style="width: 120px; object-fit:contain" class="navbar-brand-logo" src="{{ asset('images/login.png') }}" >
         {{-- <h3>Boup</h3> --}}
        {{-- <span class="navbar-brand-text hidden-xs-down"> Remark</span> --}}
      </div>
      {{-- <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search"
        data-toggle="collapse">
        <span class="sr-only">Toggle Search</span>
        <i class="icon md-search" aria-hidden="true"></i>
      </button> --}}
    </div>

    <div class="navbar-container container-fluid">
      <!-- Navbar Collapse -->
      <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
        <!-- Navbar Toolbar -->
        <ul class="nav navbar-toolbar">
          <li class="nav-item hidden-float" id="toggleMenubar">
            <a class="nav-link" data-toggle="menubar" href="#" role="button">
                <i class="icon hamburger hamburger-arrow-left">
                  <span class="sr-only">Toggle menubar</span>
                  <span class="hamburger-bar"></span>
                </i>
              </a>
          </li>
          {{-- <li class="nav-item hidden-sm-down" id="toggleFullscreen">
            <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
<!--               <span class="sr-only">Toggle fullscreen</span>
 -->            </a>
          </li> --}}
        </ul>
        <!-- End Navbar Toolbar -->

        <!-- Navbar Toolbar Right -->
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">

          <li class="nav-item dropdown">
            <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
              data-animation="scale-up" role="button">
              <span class="avatar avatar-online">
                <img src="{{!empty(Auth::guard('admin')->user()->profile_pics) ? url('admin_bkp/profile_pics/'.Auth::guard('admin')->user()->profile_pics) : asset('images/default_image.png') }}" alt="{{Auth::guard('admin')->user()->name}}">
                <i></i>
              </span>
              <label class="author-name">{{Auth::guard('admin')->user()->name}}</label>
            </a>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" href="{{route('user-profile.index')}}" role="menuitem"><i class="icon md-account" aria-hidden="true"></i> Profile</a>
              <a class="dropdown-item" href="javascript:void(0)" onclick="logout()" role="menuitem"><i class="icon md-power" aria-hidden="true"></i> Logout</a>
            </div>
          </li>
        </ul>
        <!-- End Navbar Toolbar Right -->
      </div>
      <!-- End Navbar Collapse -->

    </div>
  </nav>
