@extends('layouts.student-app')

@section('title', 'Attendance Summary')

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>
                {{ __('text.Attendance Summary') }}
            </h3>
            <ul>
                <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.View Summary') }}</li>
            </ul>
        </div>
        <div class="false-height">
            <div class="card mb-3">
                <div class="card-body">
                    <form class="new-added-form" action="{{ route('teacher.summary') }}" method="get">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-7-xxxl col-lg-7 col-7 form-group">
                                <label>{{ __('text.attendance_date') }}</label>
                                <input name="start_date" type="date" class="form-control"  value="{{ $date ? $date : date('Y-m-d') }}">
                            </div>
                            <div class="col-7 form-group mg-t-2 float-right">
                                <button type="submit" class="button--save button float-right">{{ __('text.Search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-5">
                <div class="card-body">
                    <div class="card-header-title mt-5 ml-2">
                        <b>{{ __('text.Attendance') }}:</b> {{ $date ? date('d/m/Y',strtotime($date)) : Carbon\Carbon::now()->format('d/m/Y')}}
                    </div>
                    @if(count($users) > 0)
                    <div class="table-responsive">
                        <table class="table display table-bordered table-data-div text-nowrap">
                            <thead>
                            <tr>
                                <th>{{ __('text.Code') }}</th>
                                <th>{{ __('text.Name') }}</th>
                                <th>{{ __('text.status') }}</th>
                                <th>{{ __('text.enter_time') }}</th>
                                <th>{{ __('text.exit_time') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $key=>$user)
                            <tr>
                                <td>{{ $user->stuff->student_code}}</td>
                                <td>{{ $user->stuff->name }}</td>
                                <td>
                                    @if($user->present === 1)
                                        <span class="badge-primary attdState badge">{{ trans_choice('text.Present',2) }}</span>
                                    @elseif($user->present === 3)
                                        <span class="badge-danger attdState badge">{{ __('text.late') }}</span>
                                    @else
                                        <span class="badge-danger attdState badge">{{ __('text.Absent') }}</span>
                                    @endif
                                    &nbsp;&nbsp
                                </td>
                                <td>{{ $user->created_at->format('g:i A') }}</td>
                                <td>-</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div class="card-body-body mt-5 mb-5 text-center">
                            {{ __('text.No Related Data Found') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
