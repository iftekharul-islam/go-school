<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ (Auth::check() && (Auth::user()->role == 'student' || Auth::user()->role == 'teacher'
        || Auth::user()->role == 'admin' || Auth::user()->role == 'accountant' || Auth::user()->role ==
        'librarian'))?Auth::user()->school->name: 'Shoroborno' }}</title>
    <link rel="stylesheet" href="{{ asset('template/css/login.css') }}">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/normalize.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/main.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/bootstrap.min.css') }}">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/all.min.css') }}">
    <!-- Flat Icon CSS -->
    <link rel="stylesheet" href=" {{ asset('template/fonts/flaticon.css')}}">
    <!-- Full Calender CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/fullcalendar.min.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/animate.min.css') }}">
    <!-- Data Table CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/jquery.dataTables.min.css') }}">
    {{--<!-- Select 2 CSS -->--}}
    <link rel="stylesheet" href="{{ asset('template/css/select2.min.css') }}">
    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/datepicker.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/responsive.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('template/css/sweet-alert5.3.5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/chosen.min.css') }}">
    @stack('customcss')

    <!--JS Begin -->


    <script src="{{ asset('template/js/jquery-3.3.1.min.js') }}"></script>
{{--    <script src="{{ asset('js/chosen.jquery.min.js') }}"></script>--}}
    <script src="{{ asset('js/bootstrap3-typeahead.min.js') }}"></script>
    <!--JS END-->

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
{{--<div id="preloader"></div>--}}
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
            <footer class="ml-4 footer-wrap-layout1 example-screen">
                <div class="copyright">© Copyrights <a href="https://augnitive.com/" target="_blank">Augnitive</a> 2019.
                    All rights reserved
                </div>
            </footer>
            <!-- Footer Area End Here -->
        </div>
    </div>
    <!-- Page Area End Here -->
</div>

</body>
<script src="{{ asset('template/js/jquery-3.3.1.min.js') }}"></script>

{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>--}}

{{--<script src="{{ asset('template/js/plugins.js') }}"></script>--}}
{{--<!-- Popper js -->--}}
<script src="{{ asset('template/js/popper.min.js') }}"></script>
{{--<!-- Bootstrap js -->--}}
<script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
{{--<!-- Counterup Js -->--}}
<script src="{{ asset('template/js/jquery.counterup.min.js') }}"></script>
{{--<!-- Moment Js -->--}}
<script src="{{ asset('template/js/moment.min.js') }}"></script>
{{--<!-- Waypoints Js -->--}}
<script src="{{ asset('template/js/jquery.waypoints.min.js') }}"></script>
{{--<!-- Scroll Up Js -->--}}
<script src="{{ asset('template/js/jquery.scrollUp.min.js') }}"></script>
{{--<!-- Full Calender Js -->--}}
<script src="{{ asset('template/js/fullcalendar.min.js') }}"></script>
{{--<!-- Chart Js -->--}}
<script src="{{ asset('template/js/Chart.min.js') }}"></script>
{{--<!-- Data Table Js -->--}}
<script src="{{ asset('template/js/jquery.dataTables.min.js') }}"></script>
{{--<!-- Select 2 Js -->--}}
<script src="{{ asset('template/js/select2.min.js') }}"></script>
{{--<!-- Date Picker Js -->--}}
<script src=" {{ asset('template/js/main.js') }}"></script>
<script src="{{ asset('template/js/sweetalert.js') }}"></script>

<script src="{{ asset('template/js/datepicker.min.js') }}"></script>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>--}}
<script>
    $(document).ready(function () {
        $('.table-data-div').DataTable({
            paging: false,
            bSort : false,
            language: {
                search: '',
                searchPlaceholder: "Search here"
            }
        });

        $('.section-student-data-table').DataTable({
            paging: true,
            bSort: false,
            scrollY: false,
            language: {
                searchPlaceholder: "Search here"
            }
        });
        $('.data-table-paginate').DataTable({
            paging: true,
            pageLength: 50,
            bSort : true,
            lengthChange: true,
            scrollY: false,
            language: {
                searchPlaceholder: "Search here"
            }
        });

    });
    $(function () {
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
        });
    });

</script>

@stack('customjs')

</html>
