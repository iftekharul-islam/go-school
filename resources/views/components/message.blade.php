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
                                <img src="{{asset('template/img/user-default.png')}}" style="border-radius: 50%;" width="50px" height="50px">
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

                        @if(current_user()->role == 'student')
                            <a class="btn btn-danger btn-lg float-right text-white ml-2" type="button" onclick="deleteMsg({{ $message->id }})"><i class="fas fa-trash-alt"></i></a>
                        @endif
                        @if(!empty($message->file_path) && ($message->file_path) !== null)
                            <a class="btn btn-info btn-lg float-right" href="{{asset($message->file_path)}}" target="_blank"><i class="fas fa-paperclip"></i></a>
                        @endif
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
        <h2>{{ __('text.No Related Data Found') }}</h2>
    </div>
@endif
