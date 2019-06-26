@extends('layouts.student-app')

@section('title', 'Messages')
@section('content')
{{--    <div class="dashboard-content-one">--}}
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3><a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; font-size: 22px;">Back</h4>
                </a>&nbsp;&nbsp;Messages
            </h3>
            <ul style="margin-left: -100px !important;">
                <li>
                    <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
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
                                                            <img src="{{url($message->teacher->pic_path)}}" data-src="{{url($message->teacher->pic_path)}}" style="border-radius: 50%;" width="50px" height="50px">
                                                        @else
                                                            @if(strtolower($message->teacher->gender) == 'male')
                                                                <img src="{{asset('template/img/user-default.png')}}" style="border-radius: 50%;" width="50px" height="50px">
                                                            @else
                                                                <img src="{{asset('template/img/female-default.png')}}" style="border-radius: 50%;" width="50px" height="50px">
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <strong class="notification-title"><a href="{{url('user/'.$message->teacher->student_code)}}">
                                                            {{$message->teacher->name}}</a> . {{$message->teacher->department->department_name ?? null}}
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
                                <div class="no-message" style="text-align: center; margin-top: 200px;">
                                   <h2>No message found</h2>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Student Attendence Area End Here -->
{{--    </div>--}}
@endsection
