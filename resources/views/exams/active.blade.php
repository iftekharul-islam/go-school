@extends('layouts.student-app')
@section('title', 'All Active Examinations')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-alt"></i>
            {{ __('text.Active Exams') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.Active Exams') }}</li>
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
                                    <i style='font-size:24px;' class="text-teal fas fa-pencil-alt mr-2"></i>
                                    {{ __('text.term') }}:{{$exam->term}} ({{ $exam->exam_name }})</h5>
                                <div class="card-body-customized">
                                    <?php $total = 0 ?>
                                    @foreach($courses as $course)
                                        @if($exam->id == $course->exam_id)
                                            @php
                                                $total++;
                                            @endphp
                                        @endif
                                    @endforeach
                                    <p class="card-title float-left text-muted">{{ __('text.course_under_exam') }}: {{ $total }}</p>
                                    <a href="{{ url('admin/exams/details/'.$exam->id) }}"
                                       class="button button--primary float-right mt-5 font-weight-bold">{{ __('text.Details') }}</a>

                                    {{--                                    @component('components.active-exams',['exam'=>$exam,'courses'=>$courses])--}}
                                    {{--                                    @endcomponent--}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="card mt-5 false-height">
                    <div class="card-body">
                        <div class="card-body-body mt-5 text-center">
                            No exam active right now.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
