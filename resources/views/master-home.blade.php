@extends('layouts.student-app')

@section('content')
<div class="breadcrumbs-area">
    <h3>All Schools</h3>
    <ul>
        <li>
            <a href="{{ url('/home') }}">Home</a>
        </li>
        {{--            <li>Dashboard</li>--}}
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
                    <div class="card-body border" style="min-height: 300px">
                        <div class="card-body-inner">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3 class="mb-4 mt-2 ml-2">{{ $school->name }}</h3>
                                    <p class="mb-4 ml-2">{{ str_limit($school->about, $limit = 100, $end = '........') }}</p>
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
                            <a href="{{url('school/'.$school->id)}}"
                                class="button button--text font-weight-bold">Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

{{--    <div class="card height-auto false-height">--}}
{{--        <div class="card-body">--}}
{{--            <div class="heading-layout1">--}}
{{--                <div class="item-title">--}}
{{--                    <h3>All School Data</h3>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="table-responsive">--}}
{{--                <table class="table display data-table text-wrap">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>Name</th>--}}
{{--                        <th>Medium</th>--}}
{{--                        <th>Code</th>--}}
{{--                        <th>Total Student</th>--}}
{{--                        <th>Total Departments</th>--}}
{{--                        <th>About</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @foreach($schools as $school)--}}
{{--                        <tr>--}}
{{--                            <td>{{ $school->name }}</td>--}}
{{--                            <td>{{ $school->medium }}</td>--}}
{{--                            <td>{{ $school->code }}</td>--}}
{{--                            <td>{{count($school->users)}}</td>--}}
{{--                            <td>{{count($school->departments)}}</td>--}}
{{--                            <td>{{ $school->about }}</td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--<div class="container">--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="panel panel-default">--}}
{{--                <div class="page-panel-title">Dashboard</div>--}}

{{--                <div class="panel-body">--}}
{{--                    <a class="btn btn-danger btn-lg btn-block" href="{{url('create-school')}}" role="button">Manage
Schools</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
