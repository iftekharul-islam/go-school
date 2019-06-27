@extends('layouts.student-app')
@section('title', 'All Active Examinations')
@section('content')
<div class="breadcrumbs-area">
    <h3>
        </a>All Active Exams
    </h3>
    <ul>
        <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                Back &nbsp;&nbsp;|</a>
            <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
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
                    <div class="card-body-customized">
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
