<!doctype html>
<html lang="en">

<head>
    <title>{{(isset($page_title)) ? $page_title : "Events"}}</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="apple-touch-icon" sizes="180x180" href="">
    <link rel="icon" type="image/png" sizes="32x32" href="">
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <link rel="manifest" href="">
    <meta name="theme-color" content="#ffffff">

    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="stylesheet" href="{{ asset('/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/backend.css?v=1.0.1') }}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/remixicon/fonts/remixicon.css') }}">

    <style>
        #loading-center {
            background-size: 10%;
        }
    </style>
</head>


<body class=" ">
    <div id="loading">
        <div id="loading-center"></div>
    </div>

    <div class="wrapper">
        @yield('content')
    </div>

    <script src="{{ asset('/assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/js/customizer.js') }}"></script>
    <script src="{{ asset('/assets/js/app.js') }}"></script>

    @yield('scripts')

</body>

</html>