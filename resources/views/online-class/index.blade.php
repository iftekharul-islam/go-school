@extends('layouts.student-app')

@section('title', 'Online Class Schedule')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.online_class_schedule') }}
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url( current_user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.online_class_schedule') }}</li>
        </ul>
        <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('class.schedule.create') }}">{{ __('text.create_schedule') }}</a>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
    <div class="row">
        <!-- All Notice Area Start Here -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card height-auto false-height">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>{{ __('text.online_class_notification') }}</h3>
                        </div>
                    </div>
                    <table class="table table-bordered display text-wrap">
                        <thead>
                            <th>{{ __('text.Class') }}</th>
                            <th>{{ __('text.Section') }}</th>
                            <th>{{ __('text.sent_date') }}</th>
                            <th>{{ __('text.action') }}</th>
                        </thead>
                        <tbody>
                        @foreach($items as $data)
                            <tr>
                                <td>{{ $data->section->class->class_number }}</td>
                                <td>{{ $data->section->section_number }}</td>
                                <td>{{ new_time_date_format($data->created_at) }}</td>
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
