@extends('layouts.student-app')

@section('title', 'Attendees')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-users"></i>   {{ __('text.attendees') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" class="mr-2">
                    {{ __('text.Back') }}</a>|
                <a href="{{ route(current_user()->role . '.home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>
                {{ __('text.attendees') }}
            </li>
        </ul>
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
        <div class="col-md-8 mb-5">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="mb-5">
                        <table class="table table-borderless list display text-wrap">
                            <tbody>
                                <tr>
                                    <th>{{ __('text.Name') }}:</th>
                                    <td>{{ $data->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('text.Role') }}:</th>
                                    <td>{{ $data->role }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="mb-5">
                        @if(count($attendance) > 0)
                        <table class="table table-borderless list display text-wrap">
                            <thead>
                            <tr>
                                <th>{{ __('text.attendees') }} {{ __('text.Date') }} :</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($attendance as $item)
                                <tr>
                                    <td>{{ new_time_date_format($item->created_at) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                            <p class="text-center">{{ __('text.No_related_data_notification') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
