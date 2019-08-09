@extends('layouts.student-app')

@section('title', 'All Departments')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class='fas fa-microscope'></i>
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
    <div class="row">
        <div class="col-12">
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
                                    <th>List of Teachers</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dpts as $index=>$dp)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $dp->department_name }}</td>
                                        <td>{{ $dp->teachers->count() }}</td>
                                        <td>
                                            <a href="{{ url('admin/department-teachers', $dp->id) }}" class="button btn-link text-teal">View Department Teachers</a>
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
        </div>
    </div>
@endsection