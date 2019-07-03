@extends('layouts.student-app')

@section('title', 'All Classes and Sections')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            All Sections
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
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
                            <a href="{{url('section/students/'.$section->id)}}" class="button button--text float-left"><b>Each Student's Grade</b></a>
                        </td>
                        <td>
                            <a href="{{url('grades/section/'.$section->id)}}" role="button" class="button button--text float-left"><b>All Students Marks</b></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection