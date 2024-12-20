<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>

    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--basic styles-->
    <link href="{{ url('assets/admin/css/style.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/admin/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ url('assets/admin/css/font-awesome.min.css') }}" />


    <!--[if IE 7]>
      <link rel="stylesheet" href="{{ url('assets/admin/css/font-awesome-ie7.min.css') }}" />
    <![endif]-->

    <!--page specific plugin styles-->

    <!--fonts-->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

    <!--ace styles-->
    <link rel="stylesheet" href="{{ url('assets/admin/css/ace.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/admin/css/ace-responsive.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/admin/css/ace-skins.min.css') }}" />
    <link rel="stylesheet" type="text/css"href="{{ url('assets/admin/css/toastr.min.css') }}">
    <script src="{{ url('assets/admin/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ url('assets/admin/js/toastr.min.js') }}"></script>

    <!--[if lte IE 8]>
      <link rel="stylesheet" href="{{ url('assets/admin/css/ace-ie.min.css') }}" />
    <![endif]-->

    <!--inline styles related to this page-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a href="{{ url('/') }}" class="brand">
                    <small>
                        <i class="icon-leaf"></i>
                        Salik & Co Blog Admin
                    </small>
                </a>
                <!--/.brand-->

                <ul class="nav ace-nav pull-right">

                    <li class="light-blue">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            @if (Auth::user()->image !="")
                                <img class="nav-user-photo" src="{{ asset('storage/image/avatars/thumbnail/'.Auth::user()->image) }}" alt="User image dropdown" />
                            @else
                                <img class="nav-user-photo" src="{{ url('assets/admin/avatars/thum_no_image.jpg') }}" alt="User image dropdown" />
                            @endif
                            <span class="user-info">
                                <small>Welcome,</small>
                                {{ ucwords(Auth::user()->first_name.' '. Auth::user()->last_name) }}
                            </span>

                            <i class="icon-caret-down"></i>
                        </a>

                        <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
                            <li>
                                <a href="{{ url('admin/profile') }}">
                                    <i class="icon-user"></i>
                                    Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/change-password') }}">
                                    <i class="icon-key"></i>
                                    Change Password
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascipt:void(0)" onclick="logout()">
                                    <i class="icon-off"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!--/.ace-nav-->
            </div>
            <!--/.container-fluid-->
        </div>
        <!--/.navbar-inner-->
    </div>

    <div class="main-container container-fluid">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>

        <div class="sidebar" id="sidebar">


            <ul class="nav nav-list">
                <li class="active">
                    <a href="{{ url('admin/dashboard') }}">
                        <i class="icon-dashboard"></i>
                        <span class="menu-text"> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-file-alt"></i>
                        <span class="menu-text">Post Content</span>

                        <b class="arrow icon-angle-down"></b>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="{{ url('admin/content') }}">
                                <i class="icon-double-angle-right"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/content/show') }}">
                                <i class="icon-double-angle-right"></i>
                                Lists
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-list-alt"></i>
                        <span class="menu-text">Comments</span>

                        <b class="arrow icon-angle-down"></b>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="Admin/resultPublish">
                                <i class="icon-double-angle-right"></i>
                                Parent Comments
                            </a>
                        </li>
                        <li>
                            <a href="Admin/resultShow">
                                <i class="icon-double-angle-right"></i>
                                Replay Comments
                            </a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-cogs"></i>
                        <span class="menu-text"> Setting </span>

                        <b class="arrow icon-angle-down"></b>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="{{ url('admin/categories/show') }}">
                                <i class="icon-double-angle-right"></i>
                                Categories
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0)" onclick="logout()">
                        <i class="icon-off"></i>
                        <span class="menu-text"> Logout </span>
                    </a>
                </li>

            </ul>
            <!--/.nav-list-->

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="icon-double-angle-left"></i>
            </div>
        </div>

        <div class="main-content">
            @yield('content')
        </div><!--/.main-content-->
    </div><!--/.main-container-->

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
	    <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>


    <!--[if !IE]>-->
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>-->
    <!--<![endif]-->

    <!--[if IE]>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <![endif]-->

    <!--[if !IE]>-->
    <script type="text/javascript">
            window.jQuery || document.write("<script src='{{ url('assets/admin/js/jquery-2.0.3.min.js') }}'>"+"<"+"/script>");
    </script>
    <!--<![endif]-->

    <!--[if IE]>
        <script type="text/javascript">
         window.jQuery || document.write("<script src='{{ url('assets/admin/js/jquery-1.10.2.min.js') }}'>"+"<"+"/script>");
        </script>
    <![endif]-->

    <script type="text/javascript">
            if("ontouchend" in document) document.write("<script src='{{ url('assets/admin/js/jquery.mobile.custom.min.js') }}'>"+"<"+"/script>");
    </script>
    <script src="{{ url('assets/admin/js/bootstrap.min.js') }}"></script>
    <!--ace scripts-->
    <script src="{{ url('assets/admin/js/ace-elements.min.js') }}"></script>
    <script src="{{ url('assets/admin/js/ace.min.js') }}"></script>

    <script>
        function logout(){
            event.preventDefault();
            document.getElementById('logout-form').submit();
        }
    </script>

    </body>
</html>
