@extends('layouts.student-app')

@section('title', 'Attendance Summary')

@section('content')

    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
        <h3>
            Attendance Summary
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>View Summary</li>
        </ul>
        </div>
        <div class="false-height">
            <div class="card mb-3">
                <div class="card-body">
                <form class="new-added-form" action="{{ route('attendance.summary', $students[0]->section->id) }}" method="get">
                    {{ csrf_field() }}
                    <input type="hidden" name="section_id" value="{{ $students[0]->section->id }}" >
                    <div class="row">
                        <div class="col-6-xxxl col-lg-6 col-6 form-group">
                            <label>Start Date</label>
                            <input name="start_date" type="date" class="form-control" value="{{ $start_display ?? $start_display }}">
                        </div>
                        <div class="col-6-xxxl col-lg-6 col-6 form-group">
                            <label>End Date</label>
                            <input name="end_date" type="date" class="form-control" value="{{ $end_display ?? $end_display }}">
                        </div>
                        <div class="col-12 form-group mg-t-2 float-right">
                            <button type="submit" class="button--save button float-right">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
            <div class="card mb-5">
                <div class="card-body">
                    <h1 class="text-teal text-center">Student Attendance Summary</h1>
                    <div class="card-header-title mt-5 ml-2">
                        <b>Attendance:</b> {{ $start_display }}&nbsp; <b>to</b> &nbsp {{ $end_display }} &nbsp
                    </div>
                    <div class="table">
                        <div class="table-scroll">
                            <table class="table-main table-bordered">
                                <thead>
                                    <tr>
                                        <th class="fix-col">Name</th>
                                        @foreach ($period as $dt)
                                            <th class="text-center">{{ $dt->format("d") }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($final as $student)
                                    <tr>
                                        <td class="text-left fix-col" data-toggle="tooltip" data-placement="top" title="{{ $student['name'] }}"> {{ $student['name'] }} </td>

                                        @foreach ($student['attendances'] as $item)
                                            @if ($item >= 0)
                                                <td class="px-5">
                                                    @if ($item == '0')
                                                        <i class="fa fa-times text-danger"></i>
                                                    @elseif($item == '1')
                                                        <i class="fa fa-check text-success"></i>
                                                    @elseif($item == '2')
                                                        <i class="fa fa-running text-danger"></i>
                                                    @elseif($item == null)
                                                        <i class="fa fa-circle text-info"></i>
                                                    @endif
                                                </td>
                                            @else
                                                <td></td>
                                            @endif

                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
