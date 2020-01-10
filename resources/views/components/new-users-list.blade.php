
<div class="breadcrumbs-area">
    <h3>
        @foreach($users as $user)
            @if($user->role == 'teacher')
                    <i class='fas fa-chalkboard-teacher float-left'></i>  All Teachers
                    <a class="btn btn-lg btn-info float-right font-bold" href="{{url('admin/inactive/teachers')}}">See Inactive Teachers</a>
            @elseif($user->role == 'student')
                <i class="fas fa-users mr-2 "></i>   All Students
                <a class="btn btn-lg btn-info float-right font-bold" href="{{url('admin/inactive/students')}}">See Inactive Students</a>
            @elseif($user->role == 'accountant')
                <i class="fas fa-users mr-2 "></i>  Accountants
                <a class="btn btn-lg btn-info float-right font-bold" href="{{url('admin/inactive/accountants')}}">See Inactive Accountants</a>
            @elseif($user->role == 'librarian')
                <i class="fas fa-users mr-2 "></i>   All Librarians
                <a class="btn btn-lg btn-info float-right font-bold" href="{{url('admin/inactive/librarians')}}">See Inactive Librarians</a>
            @else
                <i class="fas fa-users mr-2 "></i>    All Users
            @endif
            @break
        @endforeach
    </h3>
    <ul>
        <li>
            <a href="{{ URL::previous() }}" style="color: #32998f!important;">Back &nbsp;|</a>
            <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
        </li>
        <li>   @foreach($users as $user)
                @if($user->role == 'teacher')
                    All Teachers
                @elseif($user->role == 'student')
                    All Students
                @elseif($user->role == 'accountant')
                    Accountants
                @elseif($user->role == 'librarian')
                    All Librarians
                @else
                    All Users
                @endif
                @break
            @endforeach</li>
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
        <div class="mb-5">
            <table class="table data-table-paginate table-bordered display text-wrap">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Code</th>
                    <th>Full Name</th>
                    @foreach ($users as $user)
                        @if($user->role == 'student')
                            @if (!Session::has('section-attendance'))
                                <th>Session</th>
                                <th>Version</th>
                                <th>Class</th>
                                <th>Section</th>
                            @endif
                        @elseif(Auth::user()->role == 'librarian' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin' || Auth::user()->role == 'accountant')
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
                            @if($user->role != 'student')
                                <th>Attendance</th>
                            @endif
                            <th>Action</th>
                        @endif
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $key=>$user)
                    <tr>
                        <th scope="row">{{$loop->index + 1 }}</th>
                        <td>{{$user->student_code}}</td>
                        <td>
                            <a class="text-teal" href="{{url('user/'.$user->student_code)}}">{{$user->name}}</a>
                        </td>
                        @if($user->role == 'student')
                            @if (!Session::has('section-attendance'))
                                <td>{{$user->studentInfo['session']}}</td>
                                <td>{{ucfirst($user->studentInfo['version'])}}</td>
                                <td>{{$user->section['class']['class_number']}} {{!empty($user->group)? '- '.$user->group:''}}</td>
                                <td style="white-space: nowrap;">{{$user->section['section_number']}}
                                </td>
                            @endif
                        @elseif(Auth::user()->role == 'librarian' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin' || Auth::user()->role == 'accountant')
                            @if (!Session::has('section-attendance'))
                                @if($user->role == 'teacher')
                                    <td style="white-space: nowrap;">

                                        <a class="text-teal" href="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/courses/'.$user->id.'/0')}}">All Courses</a>

                                    </td>
                                @endif
                            @endif
                        @elseif($user->role == 'accountant' || $user->role == 'librarian')
                            @if (!Session::has('section-attendance'))
                                <td>{{$user->phone_number}}</td>
                                <td>
                                    {{$user->email}}
                                </td>
                            @endif
                        @endif
                        @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                            @if($user->role == 'student')<td><a class="btn-link text-teal" role="button" href="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/attendances/0/'.$user->id.'/0')}}">View</a></td>@endif
                        @endif
                        @if(Auth::user()->role == 'admin')
                            @if (!Session::has('section-attendance'))
                                @if($user->role != 'student')
                                    <td>
                                        <a href="{{ url('admin/staff/attendance/'.$user->id) }}" class="btn-link text-teal">View</a>
                                    </td>
                                @endif
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
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--<div class="paginate123 mt-5 float-right">--}}
            {{--{{ $users->links() }}--}}
            {{--</div>--}}
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
