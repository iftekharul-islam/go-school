@extends('layouts.student-app')
@section('title','Search Result')
@section('content')

    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
            </li>
            <li class="text-capitalize">{{ \Auth::user()->role }} Dashboard</li>
        </ul>
    </div>
    <div class="card false-height">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table display text-wrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Role</th>
                        @foreach($users as $user)
                            @if($user->role == 'student')
                                <th>Class</th>
                                <th>Section</th>
                            @endif
                            @break
                        @endforeach
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role }}</td>
                            @if($user->role == 'student')
                                <td>{{ $user->section->class->class_number }}</td>
                                <td>{{ $user->section->section_number }}</td>
                            @endif
                            <td>
                                <a href="{{ url('admin/search-result/'.$user->id) }}" class="button button--save">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection