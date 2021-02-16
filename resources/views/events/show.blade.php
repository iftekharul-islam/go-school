@extends('layouts.student-app')
@section('title', $event->title)
@section('content')
    <div class="container-fluid">
        <div class="breadcrumbs-area">
            <h3>
                {{ __('text.events') }}
            </h3>
            <ul>
                <li> <a href="{{ URL::previous() }}" class="text-color mr-2">
                        {{ __('text.Back') }}</a>|
                    <a href="{{ url(current_user()->role.'/home') }}" class="text-color">{{ __('text.Home') }}</a>
                </li>
                <li class="text-capitalize">{{ __('text.events') }}</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Student Details Area Start Here -->
        <div>
            @if (!empty($event))
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card dashboard-card-three equal-size-body" >
                            <div class="card-body" >
                                <div class="heading-sub fancy4">{{ $event->title }}</div>
                                <small>{{ date_with_month_name($event->created_at) }}</small>
                                @if($roles != null)
                                    @foreach($roles as $role)
                                        <small class="badge badge-primary mx-2">{{ ucfirst(roles_value($role)) }}</small>
                                    @endforeach
                                @endif
                                <h3 class="text-center">
                                    {{ $event->title }}
                                </h3>
                                <div class="">
                                    {!! $event->description ? $event->description : Null !!}
                                </div>
                                @if (!empty($event->file_path))
                                    <div class="mt-5">
                                    <a class="button button--save mr-2" href="{{url($event['file_path'])}}" target="_blank">Show Attachment</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card dashboard-card-six">
                            <div class="card-body">
                                <div class="heading-layout1 mg-b-17">
                                    <div class="item-title">
                                        <h3>{{ __('text.events') }}</h3>
                                    </div>
                                </div>
                                <div class="notice-box-wrap">
                                    @foreach ($events as $event)
                                        <div class="notice-list">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6 class="notice-title"><a href="{{ route('show.event', $event->id) }}">{{ $event->title }}</a></h6>
                                                    <small>{{ date_with_month_name($event->created_at) }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @else
            <div class="card mt-5 false-height">
                <div class="card-body">
                    <div class="card-body-body mt-5 text-center">
                        {{ __('text.No_related_data_notification') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

@endsection
