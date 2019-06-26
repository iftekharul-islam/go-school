<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

{{--    <link rel="stylesheet" href="{{ asset('template/css/login.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('template/css/login.css') }}">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{ asset('/template/css/normalize.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('/template/css/main.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/template/css/bootstrap.min.css') }}">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('/template/css/all.min.css') }}">
    <!-- Flat Icon CSS -->
    <link rel="stylesheet" href=" {{ asset('/template/fonts/flaticon.css')}}">
    <!-- Full Calender CSS -->
    <link rel="stylesheet" href="{{ asset('/template/css/fullcalendar.min.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('/template/css/animate.min.css') }}">
    <!-- Data Table CSS -->
    <link rel="stylesheet" href="{{ asset('/template/css/jquery.dataTables.min.css') }}">
    <!-- Select 2 CSS -->
    <link rel="stylesheet" href="{{ asset('/template/css/select2.min.css') }}">
    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="{{ asset('/template/css/datepicker.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/template/css/style.css') }}">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/5.3.5/sweetalert2.min.css">
    <!-- Modernize js -->
    <script src="{{ asset('/template/js/modernizr-3.6.0.min.js') }}"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ (Auth::check() && (Auth::user()->role == 'student' || Auth::user()->role == 'teacher'
        || Auth::user()->role == 'admin' || Auth::user()->role == 'accountant' || Auth::user()->role ==
        'librarian'))?Auth::user()->school->name:'Laravel' }}</title>

    <script src="{{asset('js/jquery-2.1.3.min.js')}}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body>
<!-- Preloader Start Here -->
<div id="preloader"></div>
<!-- Preloader End Here -->
<div id="wrapper" class="wrapper bg-ash">

@include('layouts.shared.topbar')

<!-- Page Area Start Here -->
    <div class="dashboard-page-one">
        <!-- Sidebar Area Start Here -->
    @include('layouts.shared.sidebar-student')
    <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">

        @yield('content')
        <!-- Footer Area Start Here -->
            <footer class="footer-wrap-layout1">
                <div class="copyright">© Copyrights <a href="https://augnitive.com/" target="_blank">Augnitive</a> 2019.
                    All rights reserved
                </div>
            </footer>
            <!-- Footer Area End Here -->
        </div>
    </div>
    <!-- Page Area End Here -->
</div>
<script src="{{ asset('js/dataTables-1.10.16.min.js') }}"></script>
<script src="{{ asset('js/dataTables-1.10.16.bootstrap.min.js') }}"></script>

<script>
    $(document).ready(function () {
        var myTable = $('.table-data-div').DataTable({
            paging: false,
            "bSort" : false,
            language: {
                searchPlaceholder: "Search here"
            }
        });
    });
</script>

<script src="{{ asset('/template/js/plugins.js') }}"></script>
<!-- Popper js -->
<script src="{{ asset('/template/js/popper.min.js') }}"></script>
<!-- Bootstrap js -->
<script src="{{ asset('/template/js/bootstrap.min.js') }}"></script>
<!-- Counterup Js -->
<script src="{{ asset('/template/js/jquery.counterup.min.js') }}"></script>
<!-- Moment Js -->
<script src="{{ asset('/template/js/moment.min.js') }}"></script>
<!-- Waypoints Js -->
<script src="{{ asset('/template/js/jquery.waypoints.min.js') }}"></script>
<!-- Scroll Up Js -->
<script src="{{ asset('/template/js/jquery.scrollUp.min.js') }}"></script>
<!-- Full Calender Js -->
<script src="{{ asset('/template/js/fullcalendar.min.js') }}"></script>
<!-- Chart Js -->
<script src="{{ asset('/template/js/Chart.min.js') }}"></script>
<!-- Data Table Js -->
<script src="{{ asset('/template/js/jquery.dataTables.min.js') }}"></script>
<!-- Select 2 Js -->
<script src="{{ asset('/template/js/select2.min.js') }}"></script>
<!-- Date Picker Js -->
<script src="{{ asset('/template/js/datepicker.min.js') }}"></script>
<!-- Main js -->

<script src=" {{ asset('/template/js/main.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stack('customjs')

</body>

</html>
