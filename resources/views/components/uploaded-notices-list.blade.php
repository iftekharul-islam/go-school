<div class="table-responsive">
    <table class="table table-data-div table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ __('text.file_name') }}</th>
            <th>{{ __('text.is_active') }}</th>
            <th>{{ __('text.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($files as $file)
            <tr>
                <td>{{($loop->index + 1)}}</td>
                <td><a class="text-teal" href="{{ route('show.notice', $file->id) }}">{{$file->title}}</a></td>
                <td>{{ ($file->active === 1)?'Yes':'No' }}</td>
                
                <td>
                    @if($file->active ===1)
                        <button class="button button--edit" type="button" onclick="removeFile({{ $file->id }})">Deactivate</button>
                        <form id="delete-form-{{ $file->id }}" action="{{ url('admin/academic/'.$upload_type.'/'.'update/'.$file->id) }}" method="GET" style="display: none;">
                            @csrf
                            @method('GET')
                        </form>
                    @else
                        <button class="button button--save" type="button" onclick="activeFile({{ $file->id }})">Activate</button>
                        <form id="active-file-form-{{ $file->id }}" action="{{ url('admin/academic/'.$upload_type.'/'.'update/'.$file->id) }}" method="GET" style="display: none;">
                            @csrf
                            @method('GET')
                        </form>
                    @endif
                    <button class="button button--cancel ml-2" type="button" onclick="deleteNotice({{ $file->id }})"><i class="fas fa-trash"></i></button>
                    <form id="delete-file-{{ $file->id }}" action="{{ route('notice.delete',['id' => $file->id]) }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@push('customjs')
    <script type="text/javascript">
        function removeFile(id) {
            swal({
                title: "Are you sure?",
                text: "Are you sure, you want to deactivate this item!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-'+id).submit();
                    }
                });
        };

        function activeFile(id) {
            swal({
                title: "Are you sure?",
                text: "You are about to activated this syllabus",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('active-file-form-'+id).submit();
                    }
                });
        }

         function deleteNotice(id) {
            swal({
                title: "Are you sure?",
                text: "Are you sure, you want to delete this item!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        console.log(id);
                        document.getElementById('delete-file-'+id).submit();
                    }
                });
        }
    </script>
@endpush
