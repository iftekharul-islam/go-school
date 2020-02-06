
<div class="breadcrumbs-area">
    <h3>
    @if(count($users) > 0)
        @foreach($users as $user)
            @if($user->role == 'teacher')
                <i class='fas fa-chalkboard-teacher'></i>  All Teachers
                <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.teachers') }}">Inactive Teachers</a>
            @elseif($user->role == 'student')
                <i class="fas fa-users mr-2 "></i>   All Students
                <a class="btn btn-lg btn-secondary float-right font-bold ml-2" href="{{ route('student.export',['keys' => serialize(\Request::query())]) }}">Export Students</a>
                <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.students') }}">Inactive Students</a>
                
            @elseif($user->role == 'accountant')
                <i class="fas fa-users mr-2 "></i>  Accountants
                <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.accountants') }}">Inactive Accountants</a>
            @elseif($user->role == 'librarian')
                <i class="fas fa-users mr-2 "></i>   All Librarians
                <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.librarians') }}">Inactive Librarians</a>
            @else
                <i class="fas fa-users mr-2 "></i>    All Users
            @endif
            @break
        @endforeach 
    @else
        <i class="fas fa-users mr-2 "></i>   All Students
        <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.students') }}">Inactive Students</a>
    @endif
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
 @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@elseif(session('error-status'))
    <div class="alert alert-success">
        {{ session('error-status') }}
    </div>
@endif
<div class="card height-auto">
    <div class="card-body">
        @if(isset($type) && $type == 'Students')
        <form method='GET' action="">
        <div class="row border-bottom mb-3">
            <div class="form-group col-md-4">
                <input type="text" name="student_name" value="{{$searchData['student_name']}}" class="form-control form-control-sm" placeholder="Name" />
            </div>
            <div class="form-group col-md-3">
                <select name="class_id" onchange="getSections(this)" class="form-control form-control-sm">
                    <option value="" disabled selected>Class</option>
                     @foreach ($classes as $class)
                        <option value="{{$class->id}}" @if($class->id == $searchData['class_id']) selected @endif>{{$class->class_number}}</option>    
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <select name="section_id" id="section_id" class="form-control form-control-sm">
                    @if($searchData['section_id'])
                        <option value="{{$searchData['section_id']}}" >{{$searchData['section_number']}}</option>
                    @else 
                        <option value="" disabled selected >Section</option>
                    @endif
                </select>
            </div>
            <div class="form-group col-md-2">
                <input type="submit" class="form-control form-control-sm btn bg-primary text-white" value="Filter" />
            </div>
        </div>
        </form>
        @endif
        
         @if(count($users) > 0)
            <form id="userBulkAction" action="{{ route('user.bulk.action') }}" method="post"> {{ csrf_field() }}
            <div class="row">
                <div class="col-md-2 col-sm-12">
                    <div class="form-group">
                        <select id='action' name="action" class="form-control form-control-sm">
                            <option value="" disabled selected>Bulk Action</option>
                            @if($type == 'Students')
                            <option value="enable_sms">Enable SMS</option>
                            <option value="disable_sms">Disable SMS</option>
                            @endif
                            <option value="deactivate">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <table class="table table-bordered display text-wrap">
                    <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" id="checkAll" title="Select All"/></th>
                        <th>Code</th>
                        <th>Full Name</th>
                        <th>Roll No</th>
                        @foreach ($users as $user)
                            @if($user->role == 'student')
                                @if (!Session::has('section-attendance'))
                                    <th>Session</th>
                                    <th>Version</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>SMS</th>
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
                            <th scope="row"><input type="checkbox" name="user_ids[]" value="{{$user->id}}" /></th>
                            <td>{{$user->student_code}}</td>
                            <td>
                                <a class="text-teal" href="{{url('user/'.$user->student_code)}}">{{$user->name}}</a>
                            </td>
                            <td>{{ $user->studentInfo['roll_number'] }}</td>
                            @if($user->role == 'student')
                                @if (!Session::has('section-attendance'))
                                    <td>{{ $user->studentInfo['session'] }}</td>
                                    <td>{{ ucfirst($user->studentInfo['version']) }}</td>
                                    <td>{{ $user->section['class']['class_number'] }} {{!empty($user->group)? '- '.$user->group:''}}</td>
                                    <td style="white-space: nowrap;">{{$user->section['section_number'] }}</td>
                                    <td>
                                    @if($user->studentInfo['is_sms_enabled'] && $user->studentInfo['is_sms_enabled'] == true)
                                        <span class="badge badge-info">Yes</span>
                                    @else
                                        <span class="badge badge-warning">No</span>
                                    @endif
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
                                    </td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="paginate123 mt-5 float-right">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </form>
         @else
            <p class="text-center">No Related Data Found.</p>
        @endif
    </div>
    

</div>

@push('customjs')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            $("#checkAll").click(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $('#action').change(function(){
               let action = $(this).val();
               let user_ids = [];
               
                $("input[name='user_ids[]']").each(function () {
                   if($(this).is(":checked")){
                        user_ids.push($(this).val());
                   }
                });

                if(user_ids.length > 0){
                    submitForm('userBulkAction');
                } else {
                    showAlert();
                    $('#action').prop('selectedIndex',0);
                }
           });
        });

       function getSections(item) {
            let selectedClass = item.value;
            let classes = {!! json_encode($classes->toArray()) !!};
            let sections = [];
            classes.forEach((cls) => {
                if (cls.id == selectedClass) {
                    sections = cls.sections;
                }
            });
            $('#section_id').empty();
            sections.forEach((sec) => {
                $('#section_id').append($("<option />").val(sec.id).text(sec.section_number));
            });
        }

        function submitForm(formId) {
            swal({
                title: "Are you sure?",
                text: " You want to perform this action!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById(formId).submit();
                }
            });
        }

        function showAlert() {
            swal({
                title: "No Student Selected",
                text: "Please select at least one student",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: {
                    cancel: false,
                    confirm: true,
                },
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
@endpush
