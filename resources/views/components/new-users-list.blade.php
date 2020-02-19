
<div class="breadcrumbs-area">
    <h3>
    @if(count($users) > 0)
        @foreach($users as $user)
            @if($user->role == 'teacher')
                <i class='fas fa-chalkboard-teacher'></i>  {{ __('text.All Teacher') }}
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
            <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
        </li>
        <li>   @foreach($users as $user)
                @if($user->role == 'teacher')
                    {{ __('text.All Teacher') }}
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
 @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="card height-auto">
    <div class="card-body">
        @if(isset($type) && $type == 'Students')
        <form id="filter" method='GET' action="">
        <div class="row border-bottom mb-3">
            <div class="form-group col-md-5">
                <input type="text" name="student_name" value="{{$searchData['student_name']}}" class="form-control form-control-sm" placeholder="Name" />
            </div>
            <div class="form-group col-md-2">
                <select id="class_id" name="class_id" onchange="getSections(this)" class="form-control form-control-sm">
                    <option value="" selected>Class</option>
                    @foreach ($classes as $class)
                        <option value="{{$class->id}}" @if($class->id == $searchData['class_id']) selected @endif>{{$class->class_number}}</option>    
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <select name="section_id" id="section_id" class="form-control form-control-sm">
                    @if($searchData['class_id'])
                        @if($classes)
                            @foreach ($classes as $class)
                                @if($class->id == $searchData['class_id'])
                                    @if($class->sections)
                                        @foreach ( $class->sections as $section)
                                            <option value="{{$section['id']}}" @if($searchData['section_id'] == $section['id']) selected @endif>{{$section['section_number']}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @else 
                        <option value="" disabled selected >Section</option>
                    @endif
                </select>
            </div>
            <div class="form-group col-md-3">
                <button type="submit" class="button button--save font-weight-bold">Search</button>
                <button type="button" onclick="resetFilter()" class="button button--cancel font-weight-bold ml-md-3">Reset</button>
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
                <div class="col-md-2 col-sm-12 offset-md-8">
                    <div class="form-group">
                        <select id='records' name="records" class="form-control form-control-sm">
                            <option value="" disabled selected>Show</option>
                            <option value="20" @if(request()->get('show') == 20) selected @endif>20</option>
                            <option value="25" @if(request()->get('show') == 25) selected @endif>25</option>
                            <option value="30" @if(request()->get('show') == 30) selected @endif>30</option>
                            <option value="35" @if(request()->get('show') == 35) selected @endif>35</option>
                            <option value="40" @if(request()->get('show') == 40) selected @endif>40</option>
                            <option value="45" @if(request()->get('show') == 45) selected @endif>45</option>
                            <option value="50" @if(request()->get('show') == 50) selected @endif>50</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <table class="table table-bordered display text-wrap">
                    <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" id="checkAll" title="Select All"/></th>
                        <th>{{ __('text.Code') }}</th>
                        <th>{{ __('text.Name') }}</th>
                        @foreach ($users as $user)
                            @if($user->role == 'student')
                                @if (!Session::has('section-attendance'))
                                    <th>Roll No</th>
                                    <th>Session</th>
                                    <th>Version</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>SMS</th>
                                @endif
                            @elseif(Auth::user()->role == 'librarian' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin' || Auth::user()->role == 'accountant')
                                @if (!Session::has('section-attendance'))
                                    @if($user->role == 'teacher')
                                        <th>{{ __('text.course') }}</th>
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
                                    <th>{{ __('text.Attendance') }}</th>
                                @endif
                                <th>{{ __('text.action') }}</th>
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
                            @if($user->role == 'student')
                                @if (!Session::has('section-attendance'))
                                    <td>{{ $user->studentInfo['roll_number'] }}</td>
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
                                        <a class="btn btn-lg btn-primary mr-3" href="{{url('admin/edit/user/'.$user->id)}}" title="Update"><i class="far fa-edit"></i></a>
                                        @if($user->role == 'student')
                                            <a class="btn btn-lg btn-secondary mr-3 open-modal" data-id="{{$user->id}}" href="#" data-toggle="modal" data-target="#uploadImage" title="Upload Profile Picture"><i class="fas fa-upload"></i></a>
                                            @if(!empty($user->pic_path))
                                                <img src="{{ asset($user->pic_path) }}" data-src="{{url($user->pic_path)}}" class="rounded-circle border border-dark" style="max-width:31px">
                                            @else
                                                @if(strtolower($user->gender) == 'male')
                                                    <img src="{{asset('user/user-male.png')}}" class="rounded-circle border border-primary" width="23%">
                                                @else
                                                    <img src="{{asset('user/user-female.png')}}"  class="rounded-circle border border-success" width="23%">
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row mt-5">
                    <div class="col-md-2 col-sm-12">
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }}
                    </div>
                    <div class="col-md-10 col-sm-12 text-right">
                        <div class="paginate123 float-right">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
         @else
            <p class="text-center">No Related Data Found.</p>
        @endif
    </div>
</div>

<div class="modal fade" id="uploadImage" role="dialog" aria-labelledby="uploadImage">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Student Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form id ="user_pic_upload" class="new-added-form" action="{{ route('upload.student.pic') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password" class="col-sm-12 control-label">Select Image</label>
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="user_id" value="">
                            <input type="file" name="image" onchange="readURL(this);" class="form-control" id="image" accept=".jpg,.png,.jpeg" required>
                            <img id="takeImg" class="d-none" style="max-width:200px;"/>
                        </div>
                    </div>
                </div>
                <div class="form-group modal-footer pb-">
                    <div class="col-md-12">
                        <button type="submit" class="button button--save float-right">Upload</button>
                    </div>
                </div>
            </form>
        </div>
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

            $('.open-modal').click(function(){
               $('#user_pic_upload input[name=user_id]').val($(this).data('id'));
            });

            $('#records').change(function(){
                let records = $(this).val();
                updateQueryStringParam('show', records);
                let url = window.location.href;
                window.location.replace(url);
            });
        });

        var updateQueryStringParam = function (key, value) {

        var baseUrl = [location.protocol, '//', location.host, location.pathname].join(''),
            urlQueryString = document.location.search,
            newParam = key + '=' + value,
            params = '?' + newParam;

            if (urlQueryString) {
                var updateRegex = new RegExp('([\?&])' + key + '[^&]*');
                var removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

                if( typeof value == 'undefined' || value == null || value == '' ) { 
                    params = urlQueryString.replace(removeRegex, "$1");
                    params = params.replace( /[&;]$/, "" );

                } else if (urlQueryString.match(updateRegex) !== null) { 
                    params = urlQueryString.replace(updateRegex, "$1" + newParam);

                } else { 
                    params = urlQueryString + '&' + newParam;
                }
            }

            params = params == '?' ? '' : params;

            window.history.replaceState({}, "", baseUrl + params);
        };
        
        function getSections(item) {
            let selectedClass = item.value;
            if(selectedClass != ''){
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
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#takeImg')
                        .attr('src', e.target.result)
                        .removeClass('d-none');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        function resetFilter() {
            $('#filter input[name=student_name]').val('');
            $("#filter select").empty();
            $("#filter").submit();
        }
    </script>
@endpush
