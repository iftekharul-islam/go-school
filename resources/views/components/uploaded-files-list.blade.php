<div class="table-responsive">
  <table class="table table-bordered table-data-div table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>File Name</th>
        @if($upload_type == 'syllabus' && $parent == 'class')
          <th>Class</th>
        @elseif($upload_type == 'routine' && $parent == 'section')
          <th>Class</th>
          <th>section</th>
        @endif
        <th>Is Active</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($files as $file)
      <tr>
        <td>{{($loop->index + 1)}}</td>
        <td><a href="{{url($file->file_path)}}" target="_blank">{{$file->title}}</a></td>
        @if($upload_type == 'syllabus' && $parent == 'class')
          <td>{{$file->myclass['class_number']}}</td>
        @elseif($upload_type == 'routine' && $parent == 'section')
          <td>{{$file->section['class_id']}}</td>
          <td>{{$file->section['section_number']}}</td>
        @endif
        <td>{{($file->active === 1)?'Yes':'No'}}</td>
        <td>
          <button class="btn-danger btn" onclick="removeFile()">Remove</button>
          <a id="delete-form" href="{{url('academic/remove/'.$upload_type.'/'.$file->id)}}" role=""></a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@push('customjs')
  <script type="text/javascript">
    function removeFile() {
      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
              .then((willDelete) => {
                if (willDelete) {
                  document.getElementById('delete-form').click();
                } else {
                  swal("Your Delete Operation has been canceled");
                }
              });
    }
  </script>
@endpush
