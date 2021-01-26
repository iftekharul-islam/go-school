@extends('layouts.student-app')

@section('title', 'Online Class Schedule')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Online class schedules
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Online class schedules</li>
        </ul>
        <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('class.schedule.create') }}">Create
            schedule</a>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <!-- All Notice Area Start Here -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card height-auto false-height">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Online Class notification</h3>
                        </div>
                    </div>
                    <table class="table table-bordered display text-wrap">
                        <thead>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Sent date</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($items as $data)
                            <tr>
                                <td>{{ $data->section->class->class_number }}</td>
                                <td>{{ $data->section->section_number }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($data->created_at)->format('d-m-Y') }}</td>
                                <td><a href="{{ route('class.schedule.show', $data->id) }}" class="btn btn-success"><i class="fas fa-eye"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
