<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Procurement">
    <meta name="author" content="Procurement">
    <meta name="keywords" content="Procurement">
	<link rel="icon" href="{{asset('img/house-of-prayer-ministries-logo.png')}}" type="icon">

    <!-- Title Page-->
    <title>Procurement || Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="{{asset('admin/css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{asset('admin/vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{asset('admin/vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/slick/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{asset('admin/css/theme.css')}}" rel="stylesheet" media="all">
    {{-- <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script> --}}

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                            <img src="{{asset('images/EssayFalcon.png')}}" alt="Procurement" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                            <ul class="list-unstyled navbar__list">
                                <li class="active has-sub">
                                    <a class="js-arrow" href="/">
                                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>                            
                                </li>
                                <li>
                                    <a href="/quotes">
                                        <i class="fas fa-table"></i>Quotes</a>
                                </li>
                                <li>
                                    <a href="/bids">
                                        <i class="fas fa-list"></i>Bids</a>
                                </li>         
                                @if(Auth::user()->role->id == 1 )
                                    <li>
                                        <a href="/users">
                                            <i class="fas fa-users"></i>Users</a>
                                    </li>
                                @endif
                                <li>
                                    <a href="/users/settings">
                                        <i class="zmdi zmdi-settings"></i>Settings</a>
                                </li> 
                            </ul>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <h4>Procurement</h4>
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="/">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>                            
                        </li>
                        <li>
                            <a href="/quotes">
                                <i class="fas fa-list"></i>Quotes</a>
                        </li>
                        <li>
                            <a href="/bids">
                                <i class="fas fa-list"></i>Bids</a>
                        </li> 
                        @if(Auth::user()->role->id <= 2 )
                            <li>
                                <a href="/departments">
                                    <i class="fas fa-table"></i>Departments</a>
                            </li> 
                        @endif       
                        @if(Auth::user()->role->id == 1 )
                            <li>
                                <a href="/users">
                                    <i class="fas fa-users"></i>Users</a>
                            </li>
                        @endif
                        <li>
                            <a href="/users/settings">
                                <i class="zmdi zmdi-settings"></i>Settings</a>
                        </li>                        
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">
                                {{-- <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button> --}}
                            </form>
                            <div class="header-button">
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            @if(!empty (Auth::user()->avatar))
                                                <img src="{{asset(Auth::user()->avatar)}}" alt="{{ Auth::user()->first_name }}" />
                                            @else
                                                <img src="{{asset('img/house-of-prayer-ministries-logo.png')}}" alt="{{ Auth::user()->first_name }}" />
                                            @endif
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#">{{ Auth::user()->first_name }}</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                            @if(!empty (Auth::user()->avatar))
                                                                <img src="{{asset(Auth::user()->avatar)}}" alt="{{ Auth::user()->first_name }}" />
                                                            @else
                                                                <img src="{{asset('img/house-of-prayer-ministries-logo.png')}}" alt="{{ Auth::user()->first_name }}" />
                                                            @endif
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#">{{ Auth::user()->first_name }}</a>
                                                    </h5>
                                                    <span class="email">{{ Auth::user()->email }}</span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">                                                
                                                <div class="account-dropdown__item">
                                                    <a href="/users/settings">
                                                        <i class="zmdi zmdi-settings"></i>Settings</a>
                                                </div>                                                
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="{{ route('logout') }}" 
                                                onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            @yield('content')

                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p> Copyright &copy;<script>document.write(new Date().getFullYear());</script> <b style="color:#6bbb24">Shiqs</b><b style="color:#1583e9"></b>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{asset('/admin/vendor/jquery-3.2.1.min.js')}}"></script>
    <!-- Bootstrap JS-->
    <script src="{{asset('/admin/vendor/bootstrap-4.1/popper.min.js')}}"></script>
    <script src="{{asset('/admin/vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
    <!-- Vendor JS       -->
    <script src="{{asset('/admin/vendor/slick/slick.min.js')}}">
    </script>
    <script src="{{asset('/admin/vendor/wow/wow.min.js')}}"></script>
    <script src="{{asset('/admin/vendor/animsition/animsition.min.js')}}"></script>
    <script src="{{asset('/admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}">
    </script>
    <script src="{{asset('/admin/vendor/counter-up/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('/admin/vendor/counter-up/jquery.counterup.min.js')}}">
    </script>
    <script src="{{asset('/admin/vendor/circle-progress/circle-progress.min.js')}}"></script>
    <script src="{{asset('/admin/vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('/admin/vendor/chartjs/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('/admin/vendor/select2/select2.min.js')}}"></script>

    <!-- Main JS-->
    <script src="{{asset('admin/js/main.js')}}"></script>
    <script src="{{asset('/admin/js/sermons.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
            // $('.dateTimePicker').datetimepicker();
        });
    </script>
{{-- <script>
    $().ready(function () {
        tinymce.init({
            selector: 'textarea',
            height: 300,
            theme: 'modern',
            plugins: [
                'image code print preview fullpage  searchreplace autolink directionality  visualblocks visualchars fullscreen image link    table charmap hr pagebreak nonbreaking  toc insertdatetime advlist lists textcolor wordcount   imagetools    contextmenu colorpicker textpattern media '
            ],
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat |undo redo | image code| link fontsizeselect  | ',
            relative_urls: false,
            file_browser_callback: function(field_name, url, type, win) {
                // trigger file upload form
                if (type == 'image') $('#formUpload input').click();
            }
        });
    });
    </script>  --}}

<script>
    function readURL(input,id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#'+id)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>

</html>
<!-- end document-->
