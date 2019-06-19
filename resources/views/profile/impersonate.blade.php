@extends('layouts.app')

@section('title', 'Impersonate')

@section('content')

    <div class="breadcrumbs-area">
        <h3>Teacher</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>User Rules</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>All Users Role</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
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
                                            <button type="submit" class="fw-btn-fill btn-gradient-yellow">Impersonate</button>
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
