@extends('layouts.student-app')

@section('title', 'Grade')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
           {{ __('text.marks_and_grade') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.marks_and_grade') }}</li>
        </ul>
    </div>
    @if(count($students) > 0)
        <div class="card height-auto mb-5">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3><i class="fas fa-users mr-2"></i>Students of Section:
                            <strong> {{$section->section_number}}</strong></h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display table-bordered table-data-div text-wrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('text.Code') }}</th>
                            <th>{{ __('text.Name') }}</th>
                            <th>{{ __('text.Email') }}</th>
                            <th>{{ __('text.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ ($loop->index+1) }}</td>
                                <td>{{ $student['student_code'] }}</td>
                                <td><a class="text-teal"
                                       href="{{ route('user.show',$student->student_code) }}">{{$student->name}}</a>
                                </td>
                                <td>{{ $student->email }}</td>
                                <td><a class="btn-link text-teal" role="button"
                                       href="{{ route('student.grades',$student->id) }}">View Grade History</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>{{ __('text.marks_and_grade_details') }}</h3>
                </div>
            </div>
            @if(count($grades) > 0)
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="mb-5">
                    @foreach($grades as $grade)
                        <b>Class:</b> {{$grade->course->class->class_number}} &nbsp;
                        <b>Section:</b> {{$grade->student ? $grade->student->section->section_number : ''}}
                        @break
                    @endforeach
                </div>
                <div class="table-responsive">
                    <table class="table display table-data-div text-wrap">
                        <thead>
                        <tr>
                            <th>{{ __('text.Exams') }} {{ __('text.Name') }}</th>
                            <th>{{ __('text.course') }} {{ __('text.Name') }}</th>
                            <th>{{ __('text.students_code') }}</th>
                            <th>{{ __('text.students_name') }}</th>
                            <th>{{ __('text.total_mark') }}</th>
                            <th>{{ __('text.Grades') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($grades as $grade)
                            <tr>
                                <td>{{$grade->exam->exam_name ?? ''}}</td>
                                <td>{{$grade->course->course_name ?? ''}}</td>
                                <td>{{$grade->student['student_code'] ?? ''}}</td>
                                <td>
                                    @isset($grade->student)
                                        <a class="text-teal btn-link"
                                           href="{{ url('user/'.$grade->student['student_code'])}}">{{$grade->student['name']}}</a>
                                    @endisset
                                </td>
                                <td>{{$grade->marks ?? '' }}</td>
                                <td>{{$grade->gpa ?? ''}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center">
                    {{ __('text.No_related_data_notification') }}
                </div>
            @endif
        </div>
    </div>
@endsection
