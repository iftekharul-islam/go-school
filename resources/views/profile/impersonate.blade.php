@extends('layouts.student-app')

@section('title', 'Impersonate')

@section('content')

    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;Impersonate
        </h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>Impersonate</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table display text-nowrap table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($other_users as $other_user)
                            <tr>
                                <form method="POST" action="{{ url('/user/config/impersonate') }}">
                                    {{ csrf_field() }}
                                    <td>{{ $other_user->id }}</td>
                                    <td>{{ $other_user->name }}</td>
                                    <td>{{ $other_user->role }}</td>
                                    <td>
                                        <input type="hidden" name="id" value="{{$other_user->id}}" />
                                        <div class="col-12 form-group">
                                            <button type="submit" class="btn-primary btn btn-lg">Impersonate</button>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

{{--<div class="container">--}}
{{--    <div class="panel panel-default">--}}
{{--        <div class="table-responsive">--}}
{{--            <table class="table text-nowrap">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th>ID</th>--}}
{{--                    <th>Name</th>--}}
{{--                    <th>Role</th>--}}
{{--                    <th></th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach ($other_users as $other_user)--}}
{{--                    <form method="POST" action="{{ url('/user/config/impersonate') }}">--}}
{{--                        {{ csrf_field() }}--}}
{{--                        <tr>--}}
{{--                            <td>{{ $other_user->id }}</td>--}}
{{--                            <td>{{ $other_user->name }}</td>--}}
{{--                            <td>{{ $other_user->role }}</td>--}}
{{--                            <td>--}}
{{--                                <input type="hidden" name="id" value="{{$other_user->id}}" />--}}
{{--                                <div class="col-12 form-group">--}}
{{--                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">Impersonate</button>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    </form>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@endsection
