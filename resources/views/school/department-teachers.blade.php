@extends('layouts.student-app')

@section('title', 'Teachers')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="main-container">
                <div class="panel panel-default">
                    @if(count($users) > 0)
                        <div class="panel-body">

                            <div class="breadcrumbs-area">
                                <h3>
                                    <i class='fas fa-chalkboard-teacher'></i>  All Teachers
                                </h3>
                                <ul>
                                    <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                                            Back &nbsp;&nbsp;|</a>
                                        <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                                    </li>
                                    <li>All Teachers</li>
                                </ul>
                            </div>

                            <div class="card height-auto">
                                <div class="card-body">

                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @elseif(session('error-status'))
                                        <div class="alert alert-success">
                                            {{ session('error-status') }}
                                        </div>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table table-data-div table-bordered display text-wrap">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th>Code</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                @foreach ($users as $user)

                                                    @if(Auth::user()->role == 'librarian' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin' || Auth::user()->role == 'accountant')
                                                        @if (!Session::has('section-attendance'))
                                                            @if($user->role == 'teacher')
                                                                <th>Courses</th>
                                                            @endif
                                                        @endif
                                                    @elseif($user->role == 'accountant' || $user->role == 'librarian')
                                                        @if (!Session::has('section-attendance'))
                                                            <th>Phone Number</th>
                                                            <th>Email</th>
                                                        @endif
                                                    @endif
                                                    @break($loop->first)
                                                @endforeach
                                                @foreach ($users as $user)
                                                    @if(Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                                                        @if($user->role === 'student')<th>Attendance</th>@endif
                                                    @endif
                                                    @break($loop->first)
                                                @endforeach
                                                @if(Auth::user()->role == 'admin')
                                                    @if (!Session::has('section-attendance'))
                                                        <th>Action</th>
                                                    @endif
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($users as $key=>$user)
                                                <tr>
                                                    <th scope="row">{{ $loop->index + 1  }}</th>
                                                    <td>{{$user->student_code}}</td>
                                                    <td>
                                                        <a class="text-teal" href="{{url('user/'.$user->student_code)}}">{{$user->name}}</a>
                                                    </td>
                                                    <td>
                                                        {{$user->email}}
                                                    </td>

                                                    @if(Auth::user()->role == 'librarian' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin' || Auth::user()->role == 'accountant')
                                                        @if (!Session::has('section-attendance'))
                                                            @if($user->role == 'teacher')
                                                                <td style="white-space: nowrap;">

                                                                    <a class="text-teal" href="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/courses/'.$user->id.'/0')}}">All Courses</a>

                                                                </td>
                                                            @endif
                                                        @endif
                                                        @if(Auth::user()->role == 'admin')
                                                            @if (!Session::has('section-attendance'))
                                                                <td>
                                                                    <a class="btn btn-lg btn-primary mr-3" href="{{url('admin/edit/user/'.$user->id)}}"><i class="far fa-edit"></i></a>
                                                                    <button class="btn btn-danger btn-lg" type="button" onclick="removeUser({{ $user->id }})">
                                                                        <i class="far fa-trash-alt"></i></button>
                                                                    <form id="delete-form-{{ $user->id }}" action="{{ url('admin/user/deactivate/'.$user->id) }}" method="GET" style="display: none;">
                                                                        @csrf
                                                                        @method('GET')
                                                                    </form>
                                                                </td>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>

                            @push('customjs')
                                <script type="text/javascript">
                                    function removeUser(id) {
                                        swal({
                                            title: "Are you sure?",
                                            text: "Once deleted, you will not be able to recover this user!",
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
                        </div>
                    @else
                        <div class="panel-body">
                            There's not Teacher Assigned for this section
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
