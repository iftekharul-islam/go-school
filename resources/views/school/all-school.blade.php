@extends('layouts.student-app')
@section('title','All School')
@section('content')
    <div class="breadcrumbs-area">
        <h3>All Schools</h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Schools</li>
        </ul>
    </div>
     @if (session('status'))
        <div class="alert alert-success mb-2">
            {{ session('status') }}
        </div>
    @endif
    <div class="card height-auto false-height">
        <div class="card-body-entire">
            <div class="row">
                @foreach($schools as $school)
                    <div class="col-12 school col-xl-6 col-lg-6 col-4-xxxl">
                        <div class="card dashboard-card-four pd-b-0 mt-4">
                            <div class="card-body border pb-5">
                                <div class="card-body-inner">
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3 class="mb-4 mt-2 ml-2 float-left hover-title">
                                                    @if($school->logo)
                                                     <img class="logo all-school-logo" src="{{ asset($school->logo) }}">
                                                    @else
                                                    <i class="fas fa-school mr-4"></i>
                                                    @endif
                                                    <a style="color: #269589" href="{{url('master/school/'.$school->id)}}">{{ str_limit($school->name, $limit = 40, $end = '.....') }}</a></h3>
                                            <p class="mb-4 ml-2 float-right" data-toggle="popover" data-trigger="hover" data-title="{{ $school->name }}" data-content="{{ $school->about }}">{{ str_limit($school->about, $limit = 70, $end = '........') }}</p>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered display text-wrap">
                                            <thead>
                                            <tr>
                                                <th>Medium</th>
                                                <th>Code</th>
                                                <th>Total Stds</th>
                                                <th>Total Dpts</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>{{ ucfirst($school->medium) }}</td>
                                                <td>{{ $school->code }}</td>
                                                <td>{{count($school->users->where('role', 'student'))}}</td>
                                                <td>{{count($school->departments)}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="{{route('sms.summary',['id' => $school->id])}}"
                                       class="button button--save font-weight-bold float-right mt-3">SMS Summary</a>
                                    <a href="{{url('master/school/'.$school->id)}}"
                                       class="button button--save font-weight-bold float-right mr-2 mt-3">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
