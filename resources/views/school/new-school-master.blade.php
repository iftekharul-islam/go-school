@extends('layouts.student-app')

@section('title', 'Manage Schools')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Manage Academy
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Manage Academy</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="row">
                <!-- Summery Area Start Here -->
                <div class="col-lg-3">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-teal">
                                    <i class="fas fa-user-graduate text-light"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Total Student</div>
                                    <div class="item-number"><span class="counter"
                                                                   data-num="{{ $total_students }}">{{ $total_students }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-teal">
                                    <i class="fas fa-school text-light"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Total Classes</div>
                                    <div class="item-number"><span class="counter"
                                                                   data-num="{{ $total_classes }}">{{ $total_classes }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-teal">
                                    <i class="fas fa-chalkboard-teacher	 text-light"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Total Teacher</div>
                                    <div class="item-number"><span class="counter"
                                                                   data-num="{{ $total_teacher }}">{{ $total_teacher }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-teal">
                                    <i class="fas fa-door-open text-light"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Total Departments</div>
                                    <div class="item-number"><span class="counter"
                                                                   data-num="{{count($school->departments)}}">{{count($school->departments)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card text-center" style="width: 100%">
                <div class="heading-layout1 mb-5">
                <div class="item-title">
                    <h3>School Information</h3>
                </div>
            </div>
                    <div class="card-body border">
                        <table class="table text-wrap">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Theme</th>
                                <th>Established</th>
                                <th>Add Admin</th>
                                <th>View Admins</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                            @if(\Auth::user()->role == 'master' || \Auth::user()->school_id == $school->id)
                                <tr>
                                    @if(\Auth::user()->role == 'master')
                                        <td>
                                            {{$school->name}}
                                        </td>
                                        <td>
                                            {{$school->code}}
                                        </td>
                                        <td>
                                            {{$school->theme}}
                                        </td>
                                        <td>
                                            {{$school->established}}
                                        </td>
                                    @endif
                                    @if(\Auth::user()->role == 'master')
                                        <td>
                                            <a class="btn btn-success btn-lg" role="button"
                                               href="{{url('register/admin/'.$school->id.'/'.$school->code)}}">
                                                <small>+ Create Admin</small>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-lg" role="button"
                                               href="{{url('school/admin-list/'.$school->id)}}">
                                                <small>View Admins</small>
                                            </a>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-lg" type="button" onclick="removeSchool({{ $school->id }})">Delete</button>
                                            <form id="delete-form-{{ $school->id }}" action="{{ url('school/delete/'.$school->id) }}" method="GET" style="display: none;">
                                                @csrf
                                                @method('GET')
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                                @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('customjs')
        <script type="text/javascript">
            function removeSchool(id) {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            document.getElementById('delete-form-'+id).submit();
                        } else {
                            swal("Your Delete Operation has been canceled");
                        }
                    });
            }
        </script>
    @endpush
@endsection