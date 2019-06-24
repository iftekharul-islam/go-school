@extends('layouts.student-app')
@section('title', 'All Active Examinations')
@section('content')
    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">
                    Back</h4></a>&nbsp;&nbsp;All Active Exams
        </h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>All Active Exams</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            @if(count($exams) > 0)
                <div class="row">
                    @foreach($exams as $exam)
                        <div class="col-md-4">
                            <div class="card dashboard-card-two pd-b-20">
                                <div class="card-body">
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3 class="mb-4">{{$exam->exam_name}}</h3>
                                        </div>
                                    </div>
                                    <?php $total = 0 ?>
                                    @foreach($courses as $course)
                                        @if($exam->id == $course->exam_id)
                                            @php
                                                $total++;
                                            @endphp
                                        @endif
                                    @endforeach
                                    <p class="float-left">Courses Under exam : {{ $total }}</p>
                                    <a href="{{ url('/exams/details/'.$exam->id) }}"
                                       class="button2 button2--white button2--animation float-right">Courses Under Exam</a>

                                    {{--                                    @component('components.active-exams',['exam'=>$exam,'courses'=>$courses])--}}
                                    {{--                                    @endcomponent--}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
