@extends('layouts.student-app')

@section('title', 'All Classes and Sections')

@section('content')

    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;All Section</h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>All Sections</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Each Student's Grade</th>
                    <th>All Students Marks</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sections as $section)
                    <tr>
                        <td>
                            <a class="text-muted" href="{{url('grades/section/'.$section->id)}}">Section {{$section->section_number}}</a>
                        </td>
                        <td>
                            <a href="{{url('section/students/'.$section->id)}}" class="button2 button2--white button2--animation float-left">Each Student's Grade</a>
                        </td>
                        <td>
                            <a href="{{url('grades/section/'.$section->id)}}" role="button" class="button2 button2--white button2--animation float-left">All Students Marks</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection