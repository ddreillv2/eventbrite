<!doctype html>

<html lang="{{ app()->getLocale() }}">

<head>
    <title>{{$page_title}}</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{$page_logo}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{$page_logo}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{$page_logo}}">
    <meta name="theme-color" content="#ffffff">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{$page_logo}}" />

    <link rel="stylesheet" href="{{ asset('/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/backend.css?v=1.0.1') }}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/remixicon/fonts/remixicon.css') }}">

    @yield('styles')

    <style>
        .alert .iq-alert-icon i {
            font-size: 1.6em;
        }

        #loading-center {
            background-size: 10%;
        }
    </style>

</head>

<body class="fixed-top-navbar top-nav  ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">
        <div class="iq-top-navbar">
            <div class="container">
                <div class="iq-navbar-custom py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                            <i class="ri-menu-line wrapper-menu"></i>
                            <a href="{{url('/events')}}" class="header-logo">
                                <img src="{{$page_logo}}" class="img-fluid rounded-normal light-logo" alt="logo">
                            </a>
                        </div>
                        <div class="iq-menu-horizontal">
                            <nav class="iq-sidebar-menu">
                                <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
                                    <a href="{{url('/events')}}" class="header-logo">
                                        <img src="{{$page_logo}}" class="img-fluid rounded-normal" alt="logo">
                                    </a>
                                    <div class="iq-menu-bt-sidebar">
                                        <i class="las la-bars wrapper-menu"></i>
                                    </div>
                                </div>
                                <ul id="iq-sidebar-toggle" class="iq-menu d-flex">
                                    <li class="active">
                                        <a href="{{url('/events')}}" class="">
                                            <span>Events</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="{{url('/about')}}" class="">
                                            <span>About</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="{{url('/sponsor')}}" class="">
                                            <span>Sponsor</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <button type="button" class="btn btn-primary"><i class="ri-bill-fill"></i>My eCertificate</button>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-page">
            @yield('content');
        </div>
    </div>

    <!-- Wrapper End-->
    <footer class="iq-footer">
        <div class="container-fluid container">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="{{url('/privacy-policy')}}">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="{{url('/terms')}}">Terms of Use</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 text-right">
                &copy {{date("Y")}} All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>
    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('/assets/js/backend-bundle.min.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('/assets/js/customizer.js') }}"></script>


    <!-- app JavaScript -->
    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script src="{{ asset('/assets/vendor/axios/dist/axios.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/moment/moment-with-locales.min.js') }}"></script>

    <script>
        function display_axios_error(error) {
            Swal.fire({
                html: "<b>" + ((error.code != undefined) ? error.code : 'Unknown Code') + "</b>: " + error.name + " ― " + error.message + "<br><br> Please try again later",
                icon: 'error',
                buttonsStyling: !1,
                allowOutsideClick: false,
                confirmButtonText: 'Ok, got it!',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
            }).then(function(e) {
                if (e.isConfirmed)
                    location.reload();
            });
        }

        function display_axios_success(message) {
            Swal.fire({
                text: message,
                icon: 'success',
                buttonsStyling: !1,
                allowOutsideClick: false,
                confirmButtonText: 'Ok, got it!',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
            });
        }

        function display_modal_error(error_message) {
            Swal.fire({
                text: error_message,
                icon: 'error',
                buttonsStyling: !1,
                allowOutsideClick: false,
                confirmButtonText: 'Ok, got it!',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
            });
        }
    </script>

    @yield('scripts')
</body>

</html>