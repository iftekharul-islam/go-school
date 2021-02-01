@extends('layouts.student-app')

@section('title', 'Messages')
@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.message') }}
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url( current_user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.message') }}</li>
        </ul>
    </div>

    <div class="card false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                </div>
            </div>
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
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
                @component('components.message', ['messages' => $messages])@endcomponent
            </div>
        </div>
    </div>
    <!-- Student Attendence Area End Here -->
@endsection

@push('customjs')
    <script type="text/javascript">
        function deleteMsg(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Message!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-'+id).submit();
                    }
                });
        }
    </script>
@endpush
