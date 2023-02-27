@extends('layouts.student-app')

@section('title', 'Notices & Events')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.event_notice') }}
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a href="{{ url( current_user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.event_notice') }}</li>
        </ul>
    </div>

    <div class="row">
        <!-- All Notice Area Start Here -->
        <div class="col-xl-6 col-lg-6 col-md-12 col-12">
            <div class="card height-auto false-height">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>{{ __('text.notice_board') }}</h3>
                        </div>
                    </div>
                    <div class="notice-board-wrap">
                        @foreach($notices as $notice)
                            <div class="notice-list">
                                <div class="row">
                                    <div class="col-9">
                                        <h6 class="notice-title" style="display: inline-block; padding-left: 20px;">
                                            <a href="{{ route('show.notice', $notice->id) }}"> {{$notice->title}} </a>
                                        </h6>
                                    </div>
                                    <div class="col-3">
                                        <div  style="display: inline-block;">{{ date('d-m-Y', strtotime($notice->created_at)) }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-12">
            <div class="card height-auto false-height">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>{{ __('text.events') }}</h3>
                        </div>
                    </div>
                    <div class="notice-board-wrap">
                        @foreach($events as $event)
                            <div class="notice-list">
                                <div class="row">
                                    <div class="col-9">
                                        <h6 class="notice-title" style="display: inline-block; padding-left: 20px;">
                                            <a href="{{ route('show.event', $event->id) }}"> {{$event->title}} </a>
                                        </h6>
                                    </div>
                                    <div class="col-3">
                                        <div class="" style="display: inline-block;">{{ date('d-m-Y', strtotime($event->created_at)) }}</div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
