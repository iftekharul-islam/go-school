<div class="table-responsive">
    <table class="table table-data-div table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>File Name</th>
            <th>Is Active</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($files as $file)
            <tr>
                <td>{{($loop->index + 1)}}</td>
                <td><a class="text-teal" href="{{ route('show.notice', $file->id) }}">{{$file->title}}</a></td>
                <td>{{($file->active === 1)?'Yes':'No'}}</td>
                @if($file->active ===1)
                    <td>
                        <button class="button button--cancel" type="button" onclick="removeFile({{ $file->id }})">
                            Deactivate</button>
                        <form id="delete-form-{{ $file->id }}" action="{{ url('admin/academic/'.$upload_type.'/'.'update/'.$file->id) }}" method="GET" style="display: none;">
                            @csrf
                            @method('GET')
                        </form>
                    </td>
                @else
                    <td>
                        <button class="button button--save" type="button" onclick="activeFile({{ $file->id }})">
                            Activate</button>
                        <form id="active-file-form-{{ $file->id }}" action="{{ url('admin/academic/'.$upload_type.'/'.'update/'.$file->id) }}" method="GET" style="display: none;">
                            @csrf
                            @method('GET')
                        </form>
                    </td>
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
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this file!",
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
    </script>
@endpush