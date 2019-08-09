@extends('layouts.student-app')
@section('title', 'All Active Examinations')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-alt"></i>
            All Active Exams
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
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
                            <div class="card mb-5">
                                <h5 class="card-sub-header text-muted text-left" style="text-transform: capitalize;">
                                    <i style='font-size:24px;margin-left:-20px;' class='flaticon-classmates text-teal'></i>
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
                                    <p class="card-title float-left text-muted">Courses Under exam: {{ $total }}</p>
                                    <a href="{{ url('admin/exams/details/'.$exam->id) }}"
                                       class="button button--primary float-right mt-5 font-weight-bold">Details</a>

                                    {{--                                    @component('components.active-exams',['exam'=>$exam,'courses'=>$courses])--}}
                                    {{--                                    @endcomponent--}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="panel-body">
                    No Exam Active right now!
                </div>
            @endif
        </div>
    </div>
@endsection
