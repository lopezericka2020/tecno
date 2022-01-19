<!DOCTYPE html>
<html lang="es">

    <head>
        <title> Sistema </title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="#">
        <meta name="keywords" content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
        <meta name="author" content="#">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon icon -->
        <link rel="icon" href="https://demo.dashboardpack.com/adminty-html/files/assets/images/favicon.ico" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="/dist/files/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- feather Awesome -->
        <link rel="stylesheet" type="text/css" href="/dist/files/assets/icon/feather/css/feather.css">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="/dist/files/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="/dist/files/assets/css/jquery.mCustomScrollbar.css">
    </head>

    <body>
        <!-- Pre-loader start -->
        <div class="theme-loader">
            <div class="ball-scale">
                <div class='contain'>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pre-loader end -->

        <input type="hidden" id="usuario-nombre" value="{{ Auth::user()->nombre }}" />

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

        <div id="appRaiz"></div>

        <script type="text/javascript" src="/js/app.js"></script>

        <script type="text/javascript" src="/dist/files/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="/dist/files/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="/dist/files/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="/dist/files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="/dist/files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>

        <script type="text/javascript" src="/dist/files/bower_components/modernizr/modernizr.js"></script>
        <script type="text/javascript" src="/dist/files/bower_components/modernizr/feature-detects/css-scrollbars.js"></script>

        <script type="text/javascript" src="/dist/files/bower_components/chart.js/dist/Chart.js"></script>

        <script src="/dist/files/assets/pages/widget/amchart/amcharts.js"></script>
        <script src="/dist/files/assets/pages/widget/amchart/serial.js"></script>
        <script src="/dist/files/assets/pages/widget/amchart/light.js"></script>

        <script type="text/javascript" src="/dist/files/assets/js/SmoothScroll.js"></script>
        <script src="/dist/files/assets/js/pcoded.min.js"></script>
        <script src="/dist/files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="/dist/files/assets/js/vartical-layout.min.js"></script>
        <script type="text/javascript" src="/dist/files/assets/pages/dashboard/analytic-dashboard.min.js"></script>
        <script type="text/javascript" src="/dist/files/assets/js/script.js"></script>
    </body>

</html>