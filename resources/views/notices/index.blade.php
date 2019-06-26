@extends('layouts.student-app')

@section('content')
    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;Events && Notice
        </h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>Events && Notice</li>
        </ul>
    </div>

    <div class="row">
        <!-- All Notice Area Start Here -->
        <div class="col-6-xxxl col-6">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Notice Board</h3>
                        </div>
                    </div>
                    <div class="notice-board-wrap">
                        @foreach($notices as $notice)
                            <div class="notice-list">
                                <div class="post-date bg-skyblue" style="display: inline-block;">{{ date('d-m-Y', strtotime($notice->created_at)) }}</div>
                                <h6 class="notice-title" style="display: inline-block; padding-left: 20px;">
                                    <a href="{{ url($notice->file_path) }}"> {{$notice->title}} </a>
                                </h6>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6-xxxl col-6">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Events</h3>
                        </div>
                    </div>
                    <div class="notice-board-wrap">
                        @foreach($events as $event)
                            <div class="notice-list">
                                <div class="post-date bg-skyblue" style="display: inline-block;">{{ date('d-m-Y', strtotime($event->created_at)) }}</div>
                                <h6 class="notice-title" style="display: inline-block; padding-left: 20px;">
                                    <a href="{{ url($event->file_path) }}"> {{$event->title}} </a>
                                </h6>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection