@extends('layouts.student-app')
@section('title', 'All GPA Systems')
@section('content')

    <div class="breadcrumbs-area">
        <div class="breadcrumbs-area">
            <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;All GPA</h3>
            <ul style="margin-left: -100px !important;">
                <li>
                    <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
                </li>
                <li>All GPA</li>
            </ul>
        </div>
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
                <h4>{{$g->grade_system_name}}</h4>
                <div class="table-responsive">
                    <table class="table display text-nowraps">
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
