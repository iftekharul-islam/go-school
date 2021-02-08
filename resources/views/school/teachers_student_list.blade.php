@extends('layouts.student-app')
@section('title','Dashboard')
@push('customcss')
    <style>
        .min-area {
            min-width: 110px;
        }
    </style>
@endpush
@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>
                {{ __('text.students_under_classes') }}
            </h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}">{{ __('text.Back') }} &nbsp;|</a>
                    <a href="{{ url(current_user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.student_list') }}</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card dashboard-card-eleven">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-data-div table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ __('text.Name') }}</th>
                                    <th>{{ __('text.course_name') }}</th>
                                    <th>{{ __('text.version') }}</th>
                                    <th>{{ __('text.Section') }}</th>
                                    <th>{{ __('text.Class') }}</th>
                                    <th class="min-area">{{ __('text.phone_number') }}</th>
                                    <th>{{ __('text.Attendance') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($student_courses as $course)
                                    @if($course['section']['users'] !== null)
                                        @foreach($course['section']['users'] as $user)
                                            <tr>
                                                <td><a class="text-teal"
                                                       href="{{url('user/'.$user->student_code)}}">{{$user->name}}</a>
                                                </td>
                                                <td>{{ $course['course_name'] }}</td>
                                                <td>{{ ucfirst($user['school']['medium']) }}</td>
                                                <td>{{ ucfirst($user['section']['section_number']) }} </td>
                                                <td>{{ ucfirst($user['section']['class']['class_number']) }} </td>
                                                <td>{{ $user['phone_number'] ?? 'N/A' }}</td>
                                                <td><b><a class="btn-link text-teal" role="button"
                                                          href="{{url('teacher/attendances/0/'.$user->id.'/0')}}">View</a></b>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
