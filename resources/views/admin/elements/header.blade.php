<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="{{ route('admin.dashboard.index') }}"><h1 class="m-0 display-5 font-weight-semi-bold border border-white"><span class="text-primary font-weight-bold border px-3 mr-1">PMS</span>Brain Technosys</h1></a>
          <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard.index') }}"><h1 class="m-0 display-5 font-weight-semi-bold border border-white"><span class="text-primary font-weight-bold border px-3 mr-1">PMS</span></h1></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
              <div class="input-group" style="border: 1px solid #afa0a0;border-radius: 50px;">
                <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="bg-transparent border-0" placeholder="Search">
              </div>
            </form>
          </div>
          
          <ul class="navbar-nav navbar-nav-right">

          <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                <i class="mdi mdi-bell-outline"></i>
                <span class="count-symbol bg-danger"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <h6 class="p-3 mb-0">Notifications</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="mdi mdi-calendar"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                    <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                      <i class="mdi mdi-settings"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                    <p class="text-gray ellipsis mb-0"> Update dashboard </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                      <i class="mdi mdi-link-variant"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                    <p class="text-gray ellipsis mb-0"> New admin wow! </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <h6 class="p-3 mb-0 text-center">See all notifications</h6>
              </div>
            </li>


            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">              
              <div class="nav-profile-img">
                  {{-- <img src="{{ auth()->user()->image ? asset('public/admin/images/profile/{{auth()->user()->image}}') : asset('public/admin/images/profile/default.jpg') }}" alt="image"> --}}
                  <img src="{{ auth()->user()->image ? asset('public/admin/images/profile/' . auth()->user()->image) : asset('public/admin/images/profile/default.jpg') }}" alt="image" loading="lazy">
                  <span class="availability-status online"></span>
              </div>
              <div class="nav-profile-text">
                  <p class="mb-1 text-black">{{ auth()->user()->name }}</p>
              </div>
              </a>

              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">

                  <a class="dropdown-item" href="{{ route('admin.profile',['id'=> auth()->user()->id]) }}">
                  <i class="mdi mdi-account-edit me-2 me-2 text-primary"></i> 
                  Profile-info
                  </a>
                  
                  <div class="dropdown-divider"></div>

                  <a class="dropdown-item" href="{{ route('admin.userPassword',['id'=> auth()->user()->id]) }}">
                  <i class="mdi mdi-textbox-password me-2 me-2 text-primary"></i> 
                  Change Password
                  </a>
                  
                  <div class="dropdown-divider"></div>

                  <a class="dropdown-item" href="#">
                  <i class="mdi mdi-settings me-2 text-primary"></i> 
                  <form action="{{ route('admin.logout') }}" method="GET">
                  @csrf
                  <button type="submit"style="border: 5px  transparent;background:transparent;">Logout</button>
                  </form>
                  </a>
                  
            </li>
            </ul>
              <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
        
      </nav>
          