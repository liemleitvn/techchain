

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{url('admin/models/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{Auth::guard('admin')->user()->role}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU</li>
      <li class=" treeview">
        <a href="#">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <!--------------------- Phan menu Level -------------->
      <li>
        <a href="{{route('level.index')}}">
          <i class="fa fa-level-up"></i>
          <span>Level</span>
        </a>
      </li>
      <!--------------------- Phan menu Category -------------->
      <li>
        <a href="{{route('category.index')}}">
          <i class="fa fa-list"></i>
          <span>Category</span>
        </a>
      </li>

      <!--------------------- Phan menu SKill -------------->
      <li>
        <a href="{{route('skill.index')}}">
          <i class="fa fa-share"></i> <span>Skill</span>
        </a>
      </li>
      
      <!--------------------- Phan menu Question -------------->
      <li class="treeview">
        <a href="javascipt:void(0)">
          <i class="fa fa-question-circle"></i>
          <span>Question</span>
          <span class="pull-right-container">
            @if(count($skills) > 0)
                <i class="fa fa-angle-left pull-right"></i>
            @endif
          </span>
        </a>
          <ul class="treeview-menu">
            @foreach($skills as $skill)
              <li @if($skill->is_can_add_category == 1)class={{'treeview'}}  @endif>
                <a href="{{url('admin/question',[$skill->name])}}"><i class="fa fa-circle-o"></i> {{$skill->name}}
                  @if($skill->is_can_add_category == 1)
                  <span class="pull-right-container">
                    @if(count($cates) > 0)
                        <i class="fa fa-angle-left pull-right"></i>
                    @endif
                  </span>
                  @endif
                </a>
                @if($skill->is_can_add_category == 1)
                <ul class="treeview-menu">
                  @foreach($cates as $cate)
                    <li>
                      <a href="{{url('admin/question',[$skill->name,$cate->name])}}"><i class="fa fa-circle-o"></i> {{$cate->name}}</a>
                    </li>
                  @endforeach
                </ul>
                @endif
              </li>
            @endforeach
          </ul>
      </li>
      <!--------------------- Phan menu User -------------->
      <li>
        <!--------------------- Phan menu User -------------->
        <a href="{{route('user.index')}}">
          <i class="fa fa-user"></i>
          <span>User</span>
        </a>
      </li>
      <li>
        <!--------------------- Phan menu User result-------------->
        <a href="{{route('userResultIndex')}}">
          <i class="fa fa-user"></i>
          <span>User result</span>
        </a>
      </li>
      <!--------------------- Phan menu Admin -------------->
      @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == config('constant.superAdmin'))
      <li>
        <a href="{{route('account-admin.index')}}">
          <i class="fa fa-user-secret"></i>
          <span>Admin</span>
        </a>
      </li>
      <!--------------------- Phan menu Seting -------------->
      <li>
        <a href="{{route('settingIndex')}}">
          <i class="fa fa-cogs"></i>
          <span>Seting</span>
        </a>
      </li>
      @endif
    </ul>
  </section>
  <!-- /.sidebar -->
