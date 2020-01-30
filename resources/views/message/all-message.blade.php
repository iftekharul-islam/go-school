@extends('layouts.student-app')

@section('title', 'Messages')
@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>
            Messages
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Messages</li>
        </ul>
    </div>

    <div class="card false-height">
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
                                        <div class="media-object mt-5">
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
                                    <div class="media-body border p-4 mt-5">
                                        <strong class="notification-title"><a href="{{url('user/'.$message->teacher->student_code)}}">
                                                {{$message->teacher->name}}</a> . {{$message->teacher->department->department_name ?? null}}
                                            @if($message->active == 1)
                                                <span class="label label-danger">New</span></strong>
                                        @else
                                            <span class="label label-default">Seen</span></strong>
                                        @endif

                                        <button class="btn btn-danger btn-lg float-right text-white" type="button" onclick="deleteMsg({{ $message->id }})"><i class="fas fa-trash-alt"></i></button>
                                        <form id="delete-form-{{ $message->id }}" action="{{ route('message.delete', $message->id) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
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
    <!-- Student Attendence Area End Here -->
@endsection

@push('customjs')
    <script type="text/javascript">
        function deleteMsg(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this user!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-'+id).submit();
                    }
                });
        }
    </script>
@endpush
