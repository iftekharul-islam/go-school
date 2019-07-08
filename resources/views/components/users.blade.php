
<div class="card height-auto">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table display table-data-div text-nowrap">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Code</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    @foreach ($users as $user)
                        @if($user->role == 'student')
                            @if (!Session::has('section-attendance'))
                                <th>Session</th>
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
                                <th>Phone Number</th>
                                <th>Email</th>
                            @endif
                        @endif
                        @break($loop->first)
                    @endforeach
                    @foreach ($users as $user)
                        @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
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
                        <th scope="row">{{ ($current_page-1) * $per_page + $key + 1 }}</th>
                        <td>{{$user->student_code}}</td>
                        <td>

                            @if(!empty($user->pic_path))
                                {{--                                <img src="{{url($user->pic_path)}}" data-src="{{url($user->pic_path)}}" style="border-radius: 50%;" width="25px" height="25px">--}}
                            @else
                                {{--                                @if(strtolower($user->gender) == 'male')--}}
                                {{--                                    <img src="{{asset('01-progress.gif')}}"--}}
                                {{--                                         data-src="https://png.icons8.com/dusk/50/000000/user.png"--}}
                                {{--                                         style="border-radius: 50%;" width="25px" height="25px">&nbsp;--}}
                                {{--                                @else--}}
                                {{--                                    <img src="{{asset('01-progress.gif')}}"--}}
                                {{--                                         data-src="https://png.icons8.com/dusk/50/000000/user-female.png"--}}
                                {{--                                         style="border-radius: 50%;" width="25px" height="25px">&nbsp;--}}
                                {{--                                @endif--}}
                            @endif
                            <a class="text-teal" href="{{url('user/'.$user->student_code)}}">
                                {{$user->name}}</a>
                        </td>
                        <td>{{$user->email}}</td>
                        @if($user->role == 'student')
                            @if (!Session::has('section-attendance'))
                                <td>{{$user->studentInfo['session']}}</td>
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

                                        <a class="text-teal" href="{{url('courses/'.$user->id.'/0')}}">All Courses</a>

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
                        {{--                        @if (!Session::has('section-attendance'))--}}
                        {{--                            <td>{{ucfirst($user->gender)}}</td>--}}
                        {{--                            <td>{{strtoupper($user->blood_group)}}</td>--}}
                        {{--                            <td>{{$user->phone_number}}</td>--}}
                        {{--                            <td>{{$user->address}}</td>--}}
                        {{--                        @endif--}}
                        @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                            @if($user->role == 'student')<td><a class="button button--text" role="button"
                                                                href="{{url('attendances/0/'.$user->id.'/0')}}"><b>View Attendance</b></a></td>@endif
                        @endif
                        @if(Auth::user()->role == 'admin')
                            @if (!Session::has('section-attendance'))
                                <td>
                                    <a class="btn btn-lg btn-primary mr-3" href="{{url('edit/user/'.$user->id)}}"><i class="far fa-edit"></i></a>
                                    <button class="btn btn-danger btn-lg" type="button" onclick="removeUser({{ $user->id }})">
                                        <i class="far fa-trash-alt"></i>
                                        <form id="delete-form-{{ $user->id }}" action="{{ url('/user/deactivate/'.$user->id) }}" method="GET" style="display: none;">
                                            @csrf
                                            @method('GET')
                                        </form>
                                    {{--                                    <button class="btn-danger btn btn-lg" onclick="removeUser({{$user->id}})"><i class="far fa-trash-alt"></i></button>--}}
                                    {{--                                    <a id="delete-form" href="{{url('user/deactivate/'.$user->id)}}"role=""></a>--}}
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