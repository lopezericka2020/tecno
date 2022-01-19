<!DOCTYPE html>
<html lang="es">

    <head>
        <title> Login </title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="#">
        <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
        <meta name="author" content="#">
        <!-- Favicon icon -->
        <link rel="icon" href="https://demo.dashboardpack.com/adminty-html/files/assets/images/favicon.ico" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="/dist/files/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- themify-icons line icon -->
        <link rel="stylesheet" type="text/css" href="/dist/files/assets/icon/themify-icons/themify-icons.css">
        <!-- ico font -->
        <link rel="stylesheet" type="text/css" href="/dist/files/assets/icon/icofont/css/icofont.css">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="/dist/files/assets/css/style.css">
    </head>

    <body class="fix-menu">
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

        <section class="login-block">
            <!-- Container-fluid starts -->
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        <form class="md-float-material form-material" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Login</h3>
                                        </div>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="login" class="form-control @error('login') is-invalid @enderror" 
                                            required placeholder="Ingresar Usuario" value="{{ old('email') }}" autocomplete="login" autofocus
                                        />
                                        <span class="form-bar"></span>

                                        @error('login')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" 
                                            required placeholder="Ingresar Contraseña" autocomplete="current-password"
                                        />
                                        <span class="form-bar"></span>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">
                                                Iniciar Sesion
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- end of form -->
                    </div>
                    <!-- end of col-sm-12 -->
                </div>
                <!-- end of row -->
            </div>
            <!-- end of container-fluid -->
        </section>
        
        <!-- Required Jquery -->
        <script type="text/javascript" src="/dist/files/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="/dist/files/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="/dist/files/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="/dist/files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- jquery slimscroll js -->
        <script type="text/javascript" src="/dist/files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>
        <!-- modernizr js -->
        <script type="text/javascript" src="/dist/files/bower_components/modernizr/modernizr.js"></script>
        <script type="text/javascript" src="/dist/files/bower_components/modernizr/feature-detects/css-scrollbars.js"></script>
        <!-- i18next.min.js -->
        <script type="text/javascript" src="/dist/files/bower_components/i18next/i18next.min.js"></script>
        <script type="text/javascript" src="/dist/files/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
        <script type="text/javascript" src="/dist/files/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
        <script type="text/javascript" src="/dist/files/bower_components/jquery-i18next/jquery-i18next.min.js"></script>
        <script type="text/javascript" src="/dist/files/assets/js/common-pages.js"></script>
    </body>

</html>
