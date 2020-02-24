@extends('layouts.student-app')

@section('title', 'All Syllabus')

@section('content')
    <div class="breadcrumbs-area">
        <h3> <i class="fas fa-list"></i> Syllabus </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">Back &nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Syllabus</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if(!empty($syllabuses))
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>File Name</th>
                    <th>Class</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($syllabuses as $index => $syllabus)
                    <tr>
                        <td>{{ $index + $syllabuses->firstItem() }}</td>
                        <td>{{ $syllabus->title }}</td>
                        <td>{{ $syllabus['myclass']['class_number'] }}
                        <td>
                            <a class="text-teal" href="{{url($syllabus->file_path)}}" target="_blank" title="Download File">
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row mt-5">
                <div class="col-md-2 col-sm-12">
                    Showing {{ $syllabuses->firstItem() }} to {{ $syllabuses->lastItem() }} of {{ $syllabuses->total() }}
                </div>
                <div class="col-md-10 col-sm-12 text-right">
                    <div class="paginate123 float-right">
                        {{ $syllabuses->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
            @else
                <p class="text-center">No Related Data Found.</p>
            @endif
        </div>
    </div>
@endsection
