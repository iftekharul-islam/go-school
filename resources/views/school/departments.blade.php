@extends('layouts.student-app')

@section('title', 'All Departments')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            All Departments
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Departments</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            @if(count($dpts) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered display text-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Total Teacher</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dpts as $index=>$dp)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $dp->department_name }}</td>
                                <td>{{ $dp->teachers->count() }}</td>
                                <td>
                                    <button class="button button--edit">Edit</button>
                                </td>
                                <td>
                                    <button class="button button--cancel">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
               No Department Found
            @endif
        </div>
    </div>
@endsection