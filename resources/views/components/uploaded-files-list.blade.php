<div class="table-responsive">
    <table class="table table-data-div table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ __('text.file_name') }}</th>
            @if($upload_type == 'syllabus' && $parent == 'class')
                <th>{{ __('text.Class') }}</th>
            @elseif($upload_type == 'routine' && $parent == 'section')
                <th>{{ __('text.Class') }}</th>
                <th>{{ __('text.Section') }}</th>
            @endif
            @if(Auth::user()->role == 'admin')
                <th>{{ __('text.is_active') }}</th>
                <th>{{ __('text.action') }}</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($files as $file)
            <tr>
                <td>{{($loop->index + 1)}}</td>
                <td><a class="text-teal" href="{{ route('show.event', $file->id) }}"  target="_blank">{{ $file->title }}</a></td>
                @if($upload_type == 'syllabus' && $parent == 'class')
                    <td>{{ $file->myclass['class_number'] }}</td>
                @elseif( $upload_type == 'routine' && $parent == 'section')
                    <td>{{ $file->section['class']['class_number'] }}</td>
                    <td>{{ $file->section['section_number'] }}</td>
                @endif
                @if(Auth::user()->role == 'admin')
                    <td>{{($file->active === 1)?'Yes':'No'}}</td>
                    @if($file->active ===1)
                        <td>
                            <button class="button button--cancel" type="button" onclick="removeFile({{ $file->id }})">
                                {{ __('text.deactivate') }}
                            </button>
                            <form id="delete-form-{{ $file->id }}"
                                  action="{{ url('admin/academic/'.$upload_type.'/'.'update/'.$file->id) }}"
                                  method="GET" style="display: none;">
                                @csrf
                                @method('GET')
                            </form>
                        </td>
                    @else
                        <td>
                            <button class="button button--save" type="button" onclick="activeFile({{ $file->id }})">
                                {{ __('text.active') }}
                            </button>
                            <form id="active-file-form-{{ $file->id }}"
                                  action="{{ url('admin/academic/'.$upload_type.'/'.'update/'.$file->id) }}"
                                  method="GET" style="display: none;">
                                @csrf
                                @method('GET')
                            </form>
                        </td>
                    @endif
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@push('customjs')
    <script type="text/javascript">
        function removeFile(id) {
            swal({
                title: "{{ __('text.conform_msg') }}",
                text: "{{ __('text.inactive_notification') }}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
        };

        function activeFile(id) {
            swal({
                title: "Are you sure?",
                text: "You are about to activate this item",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('active-file-form-' + id).submit();
                    }
                });
        }
    </script>
@endpush
