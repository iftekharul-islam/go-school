@extends('layouts.student-app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('home') }}">Home</a>
            </li>
            <li>Notices</li>
        </ul>
    </div>

    <div class="row">
        <!-- All Notice Area Start Here -->
        <div class="col-12-xxxl col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Notice Board</h3>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-expanded="false">...</a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                            </div>
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
    </div>
@endsection