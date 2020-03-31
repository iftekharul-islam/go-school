@extends('layouts.student-app')

@section('title', 'Manage Classes')

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>
                <i class="fas fa-cog fa-fw"></i>
                {{ __('text.all_classes') }}
            </h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.all_classes') }}</li>
            </ul>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="false-height">
            <div class="card height-auto">
                <div class="card-body">
                    @include('school.new-manage-classes')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('customjs')
    <script type="text/javascript">
        function removeSection(id) {
            swal({
                title: "{{ __('text.conform_msg') }}",
                text: "{{ __('text.conform_info') }}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
        }

        function removeClass(id) {
            swal({
                title: "{{ __('text.conform_msg') }}",
                text: "{{ __('text.conform_info_class') }}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
        }
    </script>
@endpush
