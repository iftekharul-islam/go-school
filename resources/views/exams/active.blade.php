@extends('layouts.student-app')
@section('title', 'All Active Examinations')
@section('content')
<div class="breadcrumbs-area">
    <h3><a href="javascript:history.back()" class="float-left">
            <h4 style="color: #fea801; font-size: 22px;">
                Back</h4>
        </a>&nbsp;&nbsp;All Active Exams
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
            <div class="col-md-3">
                <div class="card mb-4">
                    <h5 class="card-header text-teal text-center" style="text-transform: uppercase;">
                        {{$exam->exam_name}}</h5>
                    <div class="card-body">
                        <?php $total = 0 ?>
                        @foreach($courses as $course)
                        @if($exam->id == $course->exam_id)
                        @php
                        $total++;
                        @endphp
                        @endif
                        @endforeach
                        <p class="card-title float-left text-muted">Courses Under exam : {{ $total }}</p>
                        <a href="{{ url('/exams/details/'.$exam->id) }}"
                            class="button2 button2--white button2--animation float-right mt-5">Details</a>

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
