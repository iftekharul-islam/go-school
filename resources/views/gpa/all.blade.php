@extends('layouts.student-app')
@section('title', 'All GPA Systems')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Grade System
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Grade System</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <?php
            $gpaName = "";
            ?>
            @foreach($gpas as $g)
                <?php
                if($g->grade_system_name != $gpaName){
                    $gpaName = $g->grade_system_name;
                } else {
                    continue;
                }
                ?>
            <br>
                <h4><i class="fas fa-poll text-teal"></i> Grade Title: <strong>{{$g->grade_system_name}}</strong></h4>
                <div class="table-responsive">
                    <table class="table display table-bordered  text-nowraps">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Grade</th>
                            <th>Point</th>
                            <th>From Mark</th>
                            <th>To Mark</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($gpas as $gpa)
                            @if($gpa->grade_system_name != $gpaName)
                                @continue
                            @endif
                            <tr>
                                <td>{{($loop->index + 1)}}</td>
                                <td>{{$gpa->grade}}</td>
                                <td>{{$gpa->point}}</td>
                                <td>{{$gpa->from_mark}}</td>
                                <td>{{$gpa->to_mark}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
@endsection
