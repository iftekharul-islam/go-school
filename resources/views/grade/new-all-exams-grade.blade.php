@extends('layouts.student-app')

@section('title', 'Grade')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>All Grades</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Teacher Table Area Start Here -->
    <div class="card height-auto false-height">
        @if(count($classes) > 0)
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Marks and Grades of All Classes</h3>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                @foreach ($classes as $class)
                    <div class="card-header" style="background-color: #fff">
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-7">
                                <a class="" role="button" data-toggle="collapse" href="#collapse{{$class->id}}" aria-controls="collapse{{$class->id}}">
                                    <h5>
                                        {{$class->class_number}} {{$class->group}} <span class="float-right"><b>Sections under this Class+</b></span>
                                    </h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="collapse{{$class->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$class->id}}">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Section Name</th>
                                <th>View Each Student's Grade History</th>
                                <th>View all Students Marks under this Section</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sections as $section)
                                @if($class->id == $section->class_id)
                                    <tr>
                                        <td>
                                            <a href="{{url('grades/section/'.$section->id)}}">{{$section->section_number}}</a>
                                        </td>
                                        <td>
                                            <a href="{{url('section/students/'.$section->id)}}" class="btn btn-info btn-lg">View Each Student's Grade History</a>
                                        </td>
                                        <td>
                                            <a href="{{url('grades/section/'.$section->id)}}" role="button" class="btn btn-lg btn-warning">View all Students Marks under this Section</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card-body">
                No Related Data Found.
            </div>
        @endif
    </div>
@endsection
