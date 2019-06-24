{{--{{$users->links()}}--}}
{{--<div class="breadcrumbs-area">--}}
{{--    <h3>Dashboard</h3>--}}
{{--    <ul style="margin-left: -100px !important;>--}}
{{--        <li>--}}
{{--            <a href="{{ url('/home') }}">Home</a>--}}
{{--        </li>--}}
{{--        @if(count($users) > 0)--}}
{{--            @foreach ($users as $user)--}}
{{--                <li>{{ucfirst($user->role)}}s</li>--}}
{{--                @break($loop->first)--}}
{{--            @endforeach--}}
{{--        @endif--}}
{{--    </ul>--}}
{{--</div>--}}

<div class="breadcrumbs-area">
    <h3><a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; font-size: 22px;">Back</h4>
        </a>&nbsp;&nbsp;All @foreach($users as $user)
            {{ $user->role }}
            @break
        @endforeach
    </h3>
    <ul style="margin-left: -100px !important;">
        <li>
            <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
        </li>
        <li>All
            @foreach($users as $user)
                {{ $user->role }}
                @break
            @endforeach</li>
    </ul>
</div>


<div class="card height-auto">
    <div class="card-body">
        <div class="table-responsive">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <table class="table table-data-div display text-wrap">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Code</th>
                    <th>Full Name</th>
                    @foreach ($users as $user)
                        @if($user->role == 'student')
                            @if (!Session::has('section-attendance'))
{{--                                <th>Session</th>--}}
                                <th>Version</th>
                                <th>Class</th>
                                <th>Section</th>
                            @endif
                        @elseif($user->role == 'teacher')
                            @if (!Session::has('section-attendance'))
                                <th>Email</th>
                                @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                                    <th>Courses</th>
                                @endif
                            @endif
                        @elseif($user->role == 'accountant' || $user->role == 'librarian')
                            @if (!Session::has('section-attendance'))
                                <th>Email</th>
                            @endif
                        @endif
                        @break($loop->first)
                    @endforeach
{{--                    @if (!Session::has('section-attendance'))--}}
{{--                        <th>Gender</th>--}}
{{--                        <th>Blood</th>--}}
{{--                        <th>Phone</th>--}}
{{--                        <th>Address</th>--}}
{{--                    @endif--}}
                    @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                        <th scope="col">Attendance</th>
                    @endif
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
                        <th scope="row">{{ ($current_page-1) * $per_page + $key + 1 }}</th>
                        <td>{{$user->student_code}}</td>
                        <td>

                            @if(!empty($user->pic_path))
                                {{--                  <img src="{{asset('01-progress.gif')}}" data-src="{{url($user->pic_path)}}" style="border-radius: 50%;" width="25px" height="25px">--}}
                            @else
                                @if(strtolower($user->gender) == 'male')
                                    <img src="{{asset('01-progress.gif')}}"
                                         data-src="https://png.icons8.com/dusk/50/000000/user.png"
                                         style="border-radius: 50%;" width="25px" height="25px">&nbsp;
                                @else
                                    <img src="{{asset('01-progress.gif')}}"
                                         data-src="https://png.icons8.com/dusk/50/000000/user-female.png"
                                         style="border-radius: 50%;" width="25px" height="25px">&nbsp;
                                @endif
                            @endif
                            <a href="{{url('user/'.$user->student_code)}}">
                                {{$user->name}}</a>
                        </td>
                        @if($user->role == 'student')
                            @if (!Session::has('section-attendance'))
{{--                                <td>{{$user->studentInfo['session']}}</td>--}}
                                <td>{{ucfirst($user->studentInfo['version'])}}</td>
                                <td>{{$user->section->class->class_number}} {{!empty($user->group)? '- '.$user->group:''}}</td>
                                <td style="white-space: nowrap;">{{$user->section->section_number}}
                                </td>
                            @endif
                        @elseif($user->role == 'teacher')
                            @if (!Session::has('section-attendance'))
                                <td>
                                    {{$user->email}}
                                </td>
                                @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                                    <td style="white-space: nowrap;">

                                        <a href="{{url('courses/'.$user->id.'/0')}}">All Courses</a>

                                    </td>
                                @endif
                            @endif
                        @elseif($user->role == 'accountant' || $user->role == 'librarian')
                            @if (!Session::has('section-attendance'))
                                <td>
                                    {{$user->email}}
                                </td>
                            @endif
                        @endif
{{--                        @if (!Session::has('section-attendance'))--}}
{{--                            <td>{{ucfirst($user->gender)}}</td>--}}
{{--                            <td>{{strtoupper($user->blood_group)}}</td>--}}
{{--                            <td>{{$user->phone_number}}</td>--}}
{{--                            <td>{{$user->address}}</td>--}}
{{--                        @endif--}}
                        @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                            <td><a class="btn btn-lg btn-info" role="button"
                                   href="{{url('attendances/0/'.$user->id.'/0')}}">View Attendance</a></td>
                        @endif
                        @if(Auth::user()->role == 'admin')
                            @if (!Session::has('section-attendance'))
                                <td>
                                    <a class="btn btn-lg btn-primary" href="{{url('edit/user/'.$user->id)}}"><i class="far fa-edit"></i></a>
                                    <button class="btn-danger btn btn-lg" onclick="removeUser()"><i class="far fa-trash-alt"></i></button>
                                    <a id="delete-form" href="{{url('user/deactivate/'.$user->id)}}"role=""></a>
                                </td>
                            @endif
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
                <div class="paginate123 mt-5 float-right">
                    {{ $users->links() }}
                </div>
        </div>
    </div>

</div>

@push('customjs')
    <script type="text/javascript">
        function removeUser() {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form').click();
                    } else {
                        swal("Your Delete Operation has been canceled");
                    }
                });
        }
    </script>
@endpush