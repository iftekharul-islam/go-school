@extends('layouts.app')

@section('title', 'Admins')

@section('content')
    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4>
            </a>&nbsp;&nbsp;All Admin
        </h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>All Admin</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
{{--                <div class="item-title">--}}
{{--                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 8px;">Back</h4></a>--}}
{{--                    <h3>All Admin List</h3>--}}
{{--                    <a class="btn btn-success btn-lg" href="{{url('create-school')}}">Manage School</a>--}}
{{--                </div>--}}
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if(count($admins) > 0)
                <div class="table-responsive">
                    <table class="table display data-table text-wrap">
                        <tr>
                            <th>Action</th>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>About</th>
                        </tr>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>
                                    @if($admin->active == 0)
                                        <a href="{{url('master/activate-admin/'.$admin->id)}}" class="btn btn-lg btn-success"
                                           role="button"></i>Activate</a>
                                    @else
                                        <a href="{{url('master/deactivate-admin/'.$admin->id)}}" class="btn btn-lg btn-danger"
                                           role="button">Deactivate</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('edit/user/'.$admin->id)}}" class="btn btn-lg btn-info"
                                       role="button">Edit</a>
                                </td>
                                <td>
                                    {{$admin->name}}
                                </td>
                                <td>{{$admin->student_code}}</td>
                                <td>{{$admin->email}}</td>
                                <td>{{$admin->phone_number}}</td>
                                <td>{{$admin->address}}</td>
                                <td>{{$admin->about}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @else
        </div>
            <div class="card-body">
                No Related Data Found.
            </div>
        @endif
    </div>
@endsection