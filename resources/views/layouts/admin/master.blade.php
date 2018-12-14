<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title> TechChain Software - {{isset($title)? $title : ''}}</title>

  @include('layouts.admin.layouts.first')
  @yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    
  <!--Include header-->
    <header class="main-header">
      @include('layouts.admin.layouts.header')
    </header>
    <!--Include meunu-left-->
    <aside class="main-sidebar">
      @include('layouts.admin.layouts.menu-left')
    </aside>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
            {{isset($name_content) ? $name_content : ''}}
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">{{isset($name_content) ? $name_content : ''}}</li>
        </ol>
      </section>
      <!--Input Content-->
        <div class='show-notification-main'>
            @if ($errors->all())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(Session::has('success'))
            <div class='alert alert-success'>
              {{ Session('success')}}
            </div>
            @elseif(Session::has('error'))
            <div class='alert alert-danger'>
              {{ Session('error')}}
            </div>
            @endif
        </div>
      @yield('content')
      @include('layouts.admin.pages.change-password-admin')
    </div> 
  </div>

<!-- jQuery 3 -->
   @include('layouts.admin.layouts.last')
  <!--My js-->
  @yield('script')
</body>
</html>
