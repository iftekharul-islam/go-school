@extends('layouts.student-app')

@section('title', 'Guardian List')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="main-container">
                <div class="panel panel-default">
                    <div class="breadcrumbs-area">
                        <ul>
                            <h3>{{ __('text.guardians') }}</h3>
                            <li>
                                <a href="{{ URL::previous() }}" style="color: #32998f!important;">{{ __('text.Back') }} &nbsp;|</a>
                                <a style="margin-left: 8px;" href="{{ (current_user()->role. '.home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                            </li>
                            <li>{{ __('text.guardians') }}</li>
                        </ul>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @elseif(session('error-status'))
                        <div class="alert alert-success">
                            {{ session('error-status') }}
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
                    <div class="card height-auto">
                        <div class="card-body">
{{--                            @if(count($users) > 0)--}}
                                <form id="userBulkAction" action="{{ route('user.bulk.action') }}" method="post"> {{ csrf_field() }}
                                    <div class="mb-5">
                                        <table class="table table-bordered display text-wrap">
                                            <thead>
                                            <tr>
                                                <th>{{ __('text.Code') }}</th>
                                                <th>{{ __('text.Name') }}</th>
                                                <th>{{ __('text.Email') }}</th>
                                                <th>{{ __('text.phone_number') }}</th>
                                                <th>{{ __('text.action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div class="row mt-5">
                                            <div class="col-md-3 col-sm-12">
{{--                                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }}--}}
                                            </div>
                                            <div class="col-md-9 col-sm-12 text-right">
                                                <div class="paginate123 float-right">
{{--                                                    {{ $users->appends(request()->query())->links() }}--}}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
{{--                            @else--}}
{{--                                <p class="text-center">No Related Data Found.</p>--}}
{{--                            @endif--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
