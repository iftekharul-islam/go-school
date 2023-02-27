@if(count($messages) > 0)
    <ul class="notifications">
        @foreach ($messages as $message)
            <li class="notification">
                <div class="media">
                    <div class="media-left">
                        <div class="media-object mt-5">
                            @if(!empty($message->teacher->pic_path))
                                <img src="{{url($message->teacher->pic_path)}}" data-src="{{url($message->teacher->pic_path)}}" class="user-image">
                            @else
                                <img src="{{asset('template/img/user-default.png')}}" class="user-image">
                            @endif
                        </div>
                    </div>
                    <div class="media-body border p-4 mt-5">
                        <strong class="notification-title">
                        @isset($message->teacher)
                            <a href="{{url('user/'.$message->teacher->student_code)}}" class="mr-2">{{$message->teacher->name}}</a>
                        @endisset
                        @if($message->active == 1 && current_user()->role == 'student')
                            <span class="badge badge-danger">New</span>
                        @endif
                        </strong>

{{--                        @if( in_array(current_user()->role, ['student', 'teacher']))--}}
                            <a class="btn btn-danger btn-lg float-right text-white ml-2" type="button" onclick="deleteMsg({{ $message->id }})"><i class="fas fa-trash-alt"></i></a>
{{--                        @endif--}}
                        @if(!empty($message->file_path) && ($message->file_path) !== null)
                            <a class="btn btn-info btn-lg float-right" href="{{asset($message->file_path)}}" target="_blank"><i class="fas fa-paperclip"></i></a>
                        @endif
                        <form id="delete-form-{{ $message->id }}" action="{{ route('message.delete', $message->id) }}" method="POST">
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
    <div class="paginate123 pagination-position">
        {{$messages->links()}}
    </div>
@else
    <div class="no-message text-center">
        <h2>{{ __('text.No_related_data_notification') }}</h2>
    </div>
@endif
