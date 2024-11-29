<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="{{ route('admin.dashboard.index') }}" class="nav-link">
                <div class="nav-profile-image">
                  {{-- <img src="{{ asset('public/admin/images/profile/default.jpg') }}" alt="profile"> --}}
                  <img src="{{ auth()->user()->image ? asset('public/admin/images/profile/' . auth()->user()->image) : asset('public/admin/images/profile/default.jpg') }}" alt="image" loading="lazy">
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">{{ auth()->user()->name }}</span>
                  <span class="text-secondary text-small">{{ auth()->user()->role}}</span>
                </div>
               
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
          
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.employee.index') }}">
                <span class="menu-title">Employee</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
              {{-- <a class="nav-link" href="{{ route('admin.employee.index', ['user' => auth()->user()->id]) }}">
                <span class="menu-title">Employee</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a> --}}
            
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.department.index') }}"> 
                <span class="menu-title">Department</span>
                <i class="mdi mdi-hexagon menu-icon"></i>
              </a>
            </li>

            {{-- <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.clients.index') }}"> 
                <span class="menu-title">Client</span>
                <i class="mdi mdi-human-greeting menu-icon"></i>
              </a>
            </li> --}}
            @if (in_array(auth()->user()->role, ['Manager', 'Super Admin']))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.clients.index') }}"> 
            <span class="menu-title">Client</span>
            <i class="mdi mdi-human-greeting menu-icon"></i>
        </a>
    </li>
@endif

            
            <li class="nav-item">
              <a class="nav-link" href=""> 
                <span class="menu-title">Project</span>
                <i class="mdi mdi-medical-bag menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href=""> 
                <span class="menu-title">Module</span>
                <i class=" mdi mdi-view-module menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href=""> 
                <span class="menu-title">Task</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href=""> 
                <span class="menu-title">DSR</span>
                <i class="mdi mdi-wrap menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>