@extends('layouts.student-app')
@section('title', 'Online class summary')
@section('content')
    <div class="container-fluid">
        <div class="breadcrumbs-area">
            <h3>
                Online class summary Details
            </h3>
            <ul>
                <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li class="text-capitalize"> Online class summary Details</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Student Details Area Start Here -->
        <div>
            @if (!empty($data))
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card dashboard-card-three equal-size-body">
                            <div class="card-body" >
                                <h4>Students of <b>Class:</b> {{ $data->section->class->class_number}}
                                    <b>Section:</b> {{ $data->section->section_number }} <br>
                                <b>Message: </b> <span>{{ $data->message }}</span>
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <th>Date</th>
                                        <th>Total sms</th>
                                    </thead>
                                    <tbody>
                                    @foreach($data->classSummary as $item)
                                        <tr>
                                            <td>{{ \Illuminate\Support\Carbon::parse($item->created_at)->format('d-m-Y h:i A') }}</td>
                                            <td>{{ $item->total_sms }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            @else
            <div class="card mt-5 false-height">
                <div class="card-body">
                    <div class="card-body-body mt-5 text-center">
                        No Related Data Found.
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

@endsection
