 <div class="row">
        <div class="col-md-4">
            <div class="item-img-round mt-5">
                @if(!empty($user->pic_path))
                    <img src="{{url($user->pic_path)}}" data-src="{{url($user->pic_path)}}" class="" id="my-profile"
                         alt="Profile Picture" width="100%">
                @else
                    @if(strtolower($user->gender) == 'male')
                        <img src="{{asset('template/img/user-default.png')}}"
                             class="img-thumbnail" width="100%">
                    @else
                        <img src="{{asset('template/img/female-default.png')}}"
                             width="100%">
                    @endif
                @endif
            </div>
            <div class="item-content">
            @if($user->role == "student")

                <!-- <td>Student's Name:</td> -->
                    <div class="profile-name">
                        <h3 class="mt-3">{{$user->name}}</h3>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-8">
            <div class="heading-sub fancy4 ">Basic Details 
                @if(Auth::user()->role == 'admin' && Auth::user()->id == $user->id)
                    <a href="{{ route('edit-information', $user->id) }}"><i class="fas fa-user-edit float-right"></i></a>
                @endif
            </div>
            <div class="item-content">
                @if($user->role == "student")
                    <div class="row">
                        <div class="col-md-6">
                            <div class=" table-responsive border-right">
                                <table class="text-wrap table-borderless table ">
                                    <tr>
                                        <td class="text-nowrap font-medium text-dark-medium">Student Code:</td>
                                        <td class="text-capitalize">{{$user->student_code}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap font-medium text-dark-medium">Student Id:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['student_indentification']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Version:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['version']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Gender:</td>
                                        <td class="text-capitalize">{{$user->gender}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Religion:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['religion']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Birthday :</td>
                                        <td class="text-left">
                                            {{Carbon\Carbon::parse($user->studentInfo['birthday'])->format('d/m/Y')}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">E-mail / Username:</td>
                                        <td class="text-left">{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Address:</td>
                                        <td class="text-capitalize">{{$user->address}}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" table-responsive">
                                <table class="text-wrap table-borderless table ">
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Class:</td>
                                        <td>{{$user->section['class']['class_number']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Section:</td>
                                        <td class="text-capitalize">{{$user->section['section_number']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Roll no:</td>
                                        <td class="text-capitalize">{{ $user->studentInfo['roll_number'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Shift:</td>
                                        <td class="text-capitalize">{{ $user->studentInfo['shift'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Session:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['session']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Group:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['group']}}</td>
                                        {{--                <td colspan="2"></td>--}}
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Nationality:</td>
                                        <td class="text-capitalize">{{$user->nationality}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Blood Group:</td>
                                        <td class="text-capitalize">{{$user->blood_group}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
                @if($user->role != 'student' && $user->role != 'master')
                    <div class="info-table table-responsive">
                        <table class="table text-wrap">
                            <tbody>
                            <tr>
                                <td class="font-medium text-dark-medium">Name</td>
                                <td>{{$user->name}}</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-dark-medium">User Type</td>
                                <td class="text-capitalize">{{$user->role}}</td>
                            </tr>
                            @if($user->role === 'teacher' && isset($user->department))
                                <tr>
                                    <td class="font-medium text-dark-medium">Department</td>
                                    <td class="text-capitalize"> {{ $user->department['department_name'] }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="font-medium text-dark-medium">Gender</td>
                                <td class="text-capitalize">{{ $user->gender }}</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-dark-medium">Nationality</td>
                                <td class="text-capitalize">{{ $user->nationality }}</td>
                            </tr>

                            <tr>
                                <td class="font-medium text-dark-medium">E-mail / Username</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-dark-medium">Blood Group</td>
                                <td>{{ $user->blood_group }}</td>
                            </tr>

                            <tr>
                            @if($user->role === 'teacher' && isset($user->section))
                                <tr>
                                    <td class="font-medium text-dark-medium">Class</td>
                                    <td class="text-capitalize">{{($user->section['class']['class_number'])}}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Section</td>
                                    <td class="text-capitalize">{{ ucfirst($user->section->section_number)}}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Class Teacher</td>
                                    <td class="text-capitalize">{{ ucfirst( $user->section->class_id ) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="font-medium text-dark-medium">Address</td>
                                <td>{{$user->address}}</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-dark-medium">Phone</td>
                                <td>{{$user->phone_number}}</td>
                            </tr>
                            @if($user->role == 'teacher')
                              <tr>
                                <td class="font-medium text-dark-medium">Shift</td>
                                <td>@if($user->shift){{ $user->shift['shift'] }}@endif</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="font-medium text-dark-medium">About</td>
                                <td>{{$user->about}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if($user->role == "student")
    <div class="row">
        <div class="col-12">
        <div class="heading-sub fancy4 ">Parent's Information</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="table-responsive border-right">
                <table class="text-wrap table-borderless table">
                    <th>Guardian's Information:</th>
                    <tr>
                        <td class="font-medium text-dark-medium">Name:</td>
                        <td class="text-capitalize">{{$user->studentInfo['guardian_name']}}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-nowrap text-dark-medium">Phone Number:</td>
                        <td>{{$user->studentInfo['guardian_phone_number']}}</td>
                    </tr>
                    <th>Father's Information:</th>
                    <tr>
                        <td class="font-medium text-dark-medium">Name:</td>
                        <td class="text-capitalize">{{$user->studentInfo['father_name']}}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-nowrap text-dark-medium">Phone Number:</td>
                        <td>{{$user->studentInfo['father_phone_number']}}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-dark-medium">National ID:</td>
                        <td>{{$user->studentInfo['father_national_id']}}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-dark-medium">Occupation:</td>
                        <td class="text-capitalize">{{$user->studentInfo['father_occupation']}}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-dark-medium">Annual Income:</td>
                        <td>{{$user->studentInfo['father_annual_income']}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="table-responsive">
                <table class="text-wrap table-borderless table">
                    <tr>
                        <td class="font-medium text-dark-medium">Designation:</td>
                        <td class="text-capitalize">{{$user->studentInfo['father_designation']}}</td>
                    </tr>
                    <th>Mother's Information:</th>
                    <tr>
                        <td class="font-medium text-dark-medium">Name:</td>
                        <td class="text-capitalize">{{$user->studentInfo['mother_name']}}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-nowrap text-dark-medium">Phone Number:</td>
                        <td>{{$user->studentInfo['mother_phone_number']}}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-nowrap text-dark-medium">National ID:</td>
                        <td class="">{{$user->studentInfo['mother_national_id']}}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-dark-medium">Occupation:</td>
                        <td class="text-capitalize">{{$user->studentInfo['mother_occupation']}}</td>

                    </tr>
                    <tr>
                        <td class="font-medium text-nowrap text-dark-medium">Annual Income:
                        </td>
                        <td>{{$user->studentInfo['mother_annual_income']}}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-dark-medium">Designation:</td>
                        <td class="text-capitalize">{{$user->studentInfo['mother_designation']}}</td>
                    </tr>
                </table>
            </div>
        </div>
    <div class="col-md-12">
        <button  type="button" class="btn btn-secondary float-right mb-3 mt-2" onclick="window.print()" ><i class="fa fa-print"></i> Print</button>
    </div>
    @endif
</div>
