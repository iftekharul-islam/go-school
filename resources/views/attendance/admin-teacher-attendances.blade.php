@extends('layouts.student-app')

@section('title', 'Staff Attendance Report')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Staff Attendance Report
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Staff Attendance Report</li>
        </ul>
    </div>
    @if(count($attendances) > 0)
        <div class="card height-auto mb-5">
            <div class="card-body">
                @foreach($attendances as $att)
                    <div class="row">
                        <div class="col">
                            <h5 class="text-teal"><strong><i class="fas fa-id-card-alt mr-2"></i>Name: </strong>{{ $att->stuff->name }}</h5>
                        </div>
                        <div class="col">
                            <h5 class="text-teal"><strong><i class="fas fa-sliders-h mr-2"></i>Staff ID: </strong>{{ $att->stuff->student_code }}</h5>
                        </div>
                        <div class="col">
                            <h5 class="text-teal"><strong><i class="fas fa-mail-bulk mr-2"></i>Email: </strong>{{ $att->stuff->email }}</h5>
                        </div>
                        <div class="col">
                            <h5 class="text-teal"><strong><i class="fas fa-mobile-alt mr-2"></i>Phone: </strong>{{ $att->stuff->phone_number }}</h5>
                        </div>
                        <div class="col">
                            <h5 class="text-teal text-capitalize"><strong><i class="fas fa-user-shield mr-2"></i>Role: </strong>{{ $att->stuff->role }}</h5>
                        </div>
                    </div>
                    @break
                @endforeach
            </div>
        </div>
        <div class="row information">
            <div class="col-4">
                <div class="dashboard-summery-two">
                    <div class="item-icon bg-light-blue-transparent">
                        <i class="fas fa-building text-light"></i>
                    </div>
                    <div class="item-content">
                        <div class="item-number"><span class="counter" data-num="{{ $total }}"></span></div>
                        <div class="item-title">Total Work Days</div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="dashboard-summery-two">
                    <div class="item-icon bg-light-teal-transparent">
                        <i class="fas fa-clipboard-check text-light"></i>
                    </div>
                    <div class="item-content">
                        <div class="item-number"><span class="counter" data-num="{{ $present }}"></span></div>
                        <div class="item-title">Total Attends</div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="dashboard-summery-two">
                    <div class="item-icon bg-light-red-transparent">
                        <i class="far fa-times-circle text-light"></i>
                    </div>
                    <div class="item-content">
                        <div class="item-number"><span class="counter" data-num="{{ $absent }}"></span></div>
                        <div class="item-title">Total Absent</div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-body false-height">
            @if(count($attendances) > 0)
                @include('layouts.teacher.attendances-table')
            @else
                No Related Data Found.
            @endif
        </div>
    </div>
    <!-- Student Attendence Area End Here -->
    {{--    </div>--}}
@endsection
