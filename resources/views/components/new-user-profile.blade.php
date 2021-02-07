<div class="">
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
            <div class="heading-sub fancy4 ">{{ __('text.basic_details') }}
                @if(Auth::user()->role == 'admin' && Auth::user()->id == $user->id)
                    <a href="{{ route('edit-information', $user->id) }}"><i
                            class="fas fa-user-edit float-right"></i></a>
                @endif
            </div>
            <div class="item-content">
                @if($user->role == "student")
                    <div class="row">
                        <div class="col-md-6">
                            <div class=" table-responsive border-right">
                                <table class="text-wrap table-borderless table ">
                                    <tr>
                                        <td class="text-nowrap font-medium text-dark-medium">{{ __('text.student_code') }}:</td>
                                        <td class="text-capitalize">{{$user->student_code}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap font-medium text-dark-medium">{{ __('text.student_id') }}:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['student_indentification']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">{{ __('text.version') }}:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['version']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">{{ __('text.gender') }}:</td>
                                        <td class="text-capitalize">{{$user->gender}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">{{ __('text.religion') }}:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['religion']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">{{ __('text.birthday') }}:</td>
                                        <td class="text-left">
                                            {{Carbon\Carbon::parse($user->studentInfo['birthday'])->format('d/m/Y')}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">{{ __('text.email_username') }}:</td>
                                        <td class="text-left">{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">{{ __('text.address') }}:</td>
                                        <td class="text-capitalize">{{$user->address}}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" table-responsive">
                                <table class="text-wrap table-borderless table ">
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">{{ __('text.Class') }}:</td>
                                        <td>{{$user->section['class']['class_number']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">{{ __('text.Section') }}:</td>
                                        <td class="text-capitalize">{{$user->section['section_number']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">{{ __('text.roll_number') }}:</td>
                                        <td class="text-capitalize">{{ $user->studentInfo['roll_number'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">{{ __('text.Shift') }}:</td>
                                        <td class="text-capitalize">{{ $user->studentInfo['shift'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">{{ __('text.Session') }}:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['session']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">{{ __('text.group') }}:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['group']}}</td>
                                        {{--                <td colspan="2"></td>--}}
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">{{ __('text.nationality') }}:</td>
                                        <td class="text-capitalize">{{$user->nationality}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">{{ __('text.blood_group') }}:</td>
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
                                <td class="font-medium text-dark-medium">{{ __('text.Name') }}</td>
                                <td>{{$user->name}}</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-dark-medium">{{ __('text.user_type') }}</td>
                                <td class="text-capitalize">{{$user->role}}</td>
                            </tr>
                            @if($user->role === 'teacher' && isset($user->department))
                                <tr>
                                    <td class="font-medium text-dark-medium">{{ __('text.Department') }}</td>
                                    <td class="text-capitalize"> {{ $user->department['department_name'] }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="font-medium text-dark-medium">{{ __('text.gender') }}</td>
                                <td class="text-capitalize">{{ $user->gender }}</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-dark-medium">{{ __('text.nationality') }}</td>
                                <td class="text-capitalize">{{ $user->nationality }}</td>
                            </tr>

                            <tr>
                                <td class="font-medium text-dark-medium">{{ __('text.email_username') }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-dark-medium">{{ __('text.blood_group') }}</td>
                                <td>{{ $user->blood_group }}</td>
                            </tr>

                            <tr>
                            @if($user->role === 'teacher' && isset($user->section))
                                <tr>
                                    <td class="font-medium text-dark-medium">{{ __('text.Class') }}</td>
                                    <td class="text-capitalize">{{($user->section['class']['class_number'])}}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">{{ __('text.Section') }}</td>
                                    <td class="text-capitalize">{{ ucfirst($user->section->section_number)}}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">{{ __('text.class_teacher') }}</td>
                                    <td class="text-capitalize">{{ ucfirst( $user->section->class_id ) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="font-medium text-dark-medium">{{ __('text.address') }}</td>
                                <td>{{$user->address}}</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-dark-medium">{{ __('text.phone_number') }}</td>
                                <td>{{$user->phone_number}}</td>
                            </tr>
                            @if($user->role == 'teacher')
                                <tr>
                                    <td class="font-medium text-dark-medium">{{ __('text.shift') }}</td>
                                    <td>@if($user->shift){{ $user->shift['shift'] }}@endif</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="font-medium text-dark-medium">{{ __('text.about') }}</td>
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
                <div class="heading-sub fancy4 ">{{ __('text.parents_info') }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive border-right">
                    <table class="text-wrap table-borderless table">
                        <th>{{ __('text.guardians_info') }}:</th>
                        <tr>
                            <td class="font-medium text-dark-medium">{{ __('text.Name') }}:</td>
                            <td class="text-capitalize">{{$user->studentInfo['guardian_name']}}</td>
                        </tr>
                        <tr>
                            <td class="font-medium text-nowrap text-dark-medium">{{ __('text.phone_number') }}:</td>
                            <td>{{$user->studentInfo['guardian_phone_number']}}</td>
                        </tr>
                        <th>{{ __('text.fathers_info') }}:</th>
                        <tr>
                            <td class="font-medium text-dark-medium">{{ __('text.Name') }}:</td>
                            <td class="text-capitalize">{{$user->studentInfo['father_name']}}</td>
                        </tr>
                        <tr>
                            <td class="font-medium text-nowrap text-dark-medium">{{ __('text.phone_number') }}:</td>
                            <td>{{$user->studentInfo['father_phone_number']}}</td>
                        </tr>
                        <tr>
                            <td class="font-medium text-dark-medium">{{ __('text.national_id') }}:</td>
                            <td>{{$user->studentInfo['father_national_id']}}</td>
                        </tr>
                        <tr>
                            <td class="font-medium text-dark-medium">{{ __('text.father_occupation') }}:</td>
                            <td class="text-capitalize">{{$user->studentInfo['father_occupation']}}</td>
                        </tr>
                        <tr>
                            <td class="font-medium text-dark-medium">{{ __('text.father_income') }}:</td>
                            <td>{{$user->studentInfo['father_annual_income']}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="table-responsive">
                    <table class="text-wrap table-borderless table">
                        <tr>
                            <td class="font-medium text-dark-medium">{{ __('text.father_designation') }}:</td>
                            <td class="text-capitalize">{{$user->studentInfo['father_designation']}}</td>
                        </tr>
                        <th>Mother's Information:</th>
                        <tr>
                            <td class="font-medium text-dark-medium">{{ __('text.Name') }}:</td>
                            <td class="text-capitalize">{{$user->studentInfo['mother_name']}}</td>
                        </tr>
                        <tr>
                            <td class="font-medium text-nowrap text-dark-medium">{{ __('text.phone_number') }}:</td>
                            <td>{{$user->studentInfo['mother_phone_number']}}</td>
                        </tr>
                        <tr>
                            <td class="font-medium text-nowrap text-dark-medium">{{ __('text.national_id') }}:</td>
                            <td class="">{{$user->studentInfo['mother_national_id']}}</td>
                        </tr>
                        <tr>
                            <td class="font-medium text-dark-medium">{{ __('text.mother_occupation') }}:</td>
                            <td class="text-capitalize">{{$user->studentInfo['mother_occupation']}}</td>

                        </tr>
                        <tr>
                            <td class="font-medium text-nowrap text-dark-medium">{{ __('text.mother_income') }}:
                            </td>
                            <td>{{$user->studentInfo['mother_annual_income']}}</td>
                        </tr>
                        <tr>
                            <td class="font-medium text-dark-medium">{{ __('text.mother_designation') }}:</td>
                            <td class="text-capitalize">{{$user->studentInfo['mother_designation']}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <button type="button" class="btn btn-secondary float-right mb-3 mt-2" onclick="window.print()"><i
                        class="fa fa-print"></i> {{ __('text.print') }}
                </button>
            </div>
        </div>
    @endif
</div>
