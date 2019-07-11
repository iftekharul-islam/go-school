@extends('layouts.student-app')
@section('title','Dashboard')
@section('content')
<div class="breadcrumbs-area">
    <h3>All Schools</h3>
    <ul>
        <li>
            <a href="{{ url('/home') }}">Home</a>
        </li>
    </ul>
</div>

<div class="card height-auto false-height">
    <div class="card-body-entire">
        <div class="heading-layout1">
            <div class="item-title">
                {{--                    <h3>All School</h3>--}}
            </div>
        </div>
        <div class="row">
            @foreach($schools as $school)
            <div class="col-12 col-xl-4 col-4-xxxl">
                <div class="card dashboard-card-four pd-b-0">
                    <div class="card-body border pb-5">
                        <div class="card-body-inner">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3 class="mb-4 mt-2 ml-2 float-left hover-title"><i class="fas fa-school mr-4"></i><a style="color: #269589" href="{{url('school/'.$school->id)}}">{{ $school->name }}</a></h3>
                                    {{--<a href="#" title="Header" data-toggle="popover" data-trigger="hover" data-content="Some content">Hover over me</a>--}}
                                    <p class="mb-4 ml-2 float-right" data-toggle="popover" data-trigger="hover" data-title="{{ $school->name }}" data-content="{{ $school->about }}">{{ str_limit($school->about, $limit = 100, $end = '........') }}</p>
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
                                            <td>{{count($school->users)}}</td>
                                            <td>{{count($school->departments)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{url('master/school/'.$school->id)}}"
                                class="button button--primary font-weight-bold">Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
