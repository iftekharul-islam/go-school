@extends('layouts.student-app')
@section('title', 'Edit GPA System')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.edit') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.edit') }}</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form class="new-added-form" action="{{url('admin/update-gpa', $grade->id)}}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('grade') ? ' has-error' : '' }}">
                                <label>{{ __('text.Grades') }}</label>
                                <input id="grade" type="text" class="form-control" name="grade" value="{{ $grade->grade }}" required>

                                @if ($errors->has('grade'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('grade') }}</strong>
                                  </span>
                                @endif
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('point') ? ' has-error' : '' }}">
                                <label>{{ __('text.grade_point') }}</label>
                                <input id="point" type="text" class="form-control" name="point" value="{{ $grade->grade_points }}" placeholder="5.00, 4.50, ..." required>

                                @if ($errors->has('point'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('point') }}</strong>
                                  </span>
                                @endif
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('from_mark') ? ' has-error' : '' }}">
                                <label>{{ __('text.from_mark') }}</label>
                                <input id="from_mark" type="text" class="form-control" name="from_mark" value="{{ $grade->marks_from }}" placeholder="Example: 80" required>

                                @if ($errors->has('from_mark'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('from_mark') }}</strong>
                                  </span>
                                @endif
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('to_mark') ? ' has-error' : '' }}">
                                <label>{{ __('text.to_mark') }}</label>
                                <input id="to_mark" type="text" class="form-control" name="to_mark" value="{{ $grade->marks_to }}" placeholder="Example: 90" required>

                                @if ($errors->has('to_mark'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('to_mark') }}</strong>
                                  </span>
                                @endif
                            </div>

                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="button button--save float-right"><b>{{ __('text.Update') }}</b></button>
                                <a href="{{ URL::previous() }}" class="button button--cancel float-right mr-3"  role="button"><b>{{ __('text.Cancel') }}</b></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table display table-bordered  text-nowraps">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('text.Grades') }}</th>
                                <th>{{ __('text.grade_point') }}</th>
                                <th>{{ __('text.from_mark') }}</th>
                                <th>{{ __('text.to_mark') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($grades as $gpainfo)
                                <tr class="{{ $gpainfo->id == $grade->id ? 'bg-light-green' : '' }}">
                                    <td>{{($loop->index + 1)}}</td>
                                    <td>{{$gpainfo->grade}}</td>
                                    <td>{{$gpainfo->grade_points}}</td>
                                    <td>{{$gpainfo->marks_from}}</td>
                                    <td>{{$gpainfo->marks_to}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
