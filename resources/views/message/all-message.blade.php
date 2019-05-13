@extends('layouts.student-app')

@section('title', 'Messages')
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Student Messages</h3>
            <ul>
                <li>
                    <a href="{{ url('home') }}">Home</a>
                </li>
                <li>Messages</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <div class="row">
            <!-- Student Attendence Area Start Here -->
            <div class="col-12" style="min-height: 700px;">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Messages</h3>
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
                        <div class="panel-body">
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
                            @if(count($messages) > 0)
                                <ul class="notifications">
                                    @foreach ($messages as $message)
                                        <li class="notification">
                                            <div class="media">
                                                <div class="media-left">
                                                    <div class="media-object">
                                                        @if(!empty($message->teacher->pic_path))
                                                            <img src="{{asset('01-progress.gif')}}" data-src="{{url($message->teacher->pic_path)}}" style="border-radius: 50%;" width="50px" height="50px">
                                                        @else
                                                            @if(strtolower($message->teacher->gender) == 'male')
                                                                <img src="{{asset('01-progress.gif')}}" data-src="https://png.icons8.com/dusk/50/000000/user.png" style="border-radius: 50%;" width="50px" height="50px">
                                                            @else
                                                                <img src="{{asset('01-progress.gif')}}" data-src="https://png.icons8.com/dusk/50/000000/user-female.png" style="border-radius: 50%;" width="50px" height="50px">
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <strong class="notification-title"><a href="#">{{$message->teacher->name}}</a> . {{$message->teacher->department->department_name ?? null}}
                                                        @if($message->active == 1)
                                                            <span class="label label-danger">New</span></strong>
                                                    @else
                                                        <span class="label label-default">Seen</span></strong>
                                                    @endif
                                                    <p class="notification-desc">{!!$message->message!!}</p>

                                                    <div class="notification-meta">
                                                        <small class="timestamp">{{$message->created_at}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                {{$messages->links()}}
                            @else
                                No message found
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Student Attendence Area End Here -->
    </div>
@endsection
