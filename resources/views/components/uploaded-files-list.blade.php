<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>File Name</th>
        @if($upload_type == 'syllabus' && $parent == 'class')
          <th>Class</th>
        @elseif($upload_type == 'routine' && $parent == 'section')
          <th>Class</th>
          <th>Section</th>
        @endif
        <th>Is Active</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($files as $file)
      <tr>
        <td>{{($loop->index + 1)}}</td>
        <td><a class="text-teal" href="{{url($file->file_path)}}" target="_blank">{{$file->title}}</a></td>
        @if($upload_type == 'syllabus' && $parent == 'class')
          <td>{{$file->myclass['class_number']}}</td>
        @elseif($upload_type == 'routine' && $parent == 'section')
          <td>{{$file->section['class_id']}}</td>
          <td>{{$file->section['section_number']}}</td>
        @endif
        <td>{{($file->active === 1)?'Yes':'No'}}</td>
        @if($file->active ===1)
        <td>
          <button class="btn btn-danger btn-lg" type="button" onclick="removeFile({{ $file->id }})">
            Deactivate</button>
          <form id="delete-form-{{ $file->id }}" action="{{ url('academic/remove/'.$upload_type.'/'.$file->id) }}" method="GET" style="display: none;">
            @csrf
            @method('GET')
          </form>
        </td>
          @else
          <td>
            <button class="btn btn-success btn-lg" type="button" onclick="activeFile({{ $file->id }})">
              Activate</button>
            <form id="active-file-form-{{ $file->id }}" action="{{ url('academic/activate/'.$upload_type.'/'.$file->id) }}" method="GET" style="display: none;">
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
                } else {
                  swal("Your Delete Operation has been canceled");
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
                } else {
                  swal("Syllabus activate Operation has been canceled");
                }
              });
    }
  </script>
@endpush
