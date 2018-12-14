
  @php $auth_admin = Auth::guard('admin')->user()@endphp
  
  <!-- Logo -->
  <a href="#" class="logo">
    <span class="logo-mini"><img class="logo-img" src="{{asset('images/white-techchain.png')}}" alt=""></span>
    <span class="logo-lg logo-techchain"><img src="{{asset('images/white-techchain.png')}}" alt=""></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="push-menu">
      <span class="sr-only">Toggle navigation</span>
    </a>
    
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{url('admin/models/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
            <span class="hidden-xs">
              @if($auth_admin)
                {{$auth_admin->role}}
              @endif
            </span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-footer">
              <div class="form-group">
                <ul>
                  <li>
                    <a href="#" data-toggle="modal" data-target="#{{$auth_admin->id}}">Profile</a> 
                  </li>
                  <li><a href="{{route('getLogout')}}">Logout</a></li>
                </ul>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
    </div>
  </nav>
  

