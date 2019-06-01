<div class="table-responsive">
  <table class="table table-bordered table-data-div table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>File Name</th>
        @if($upload_type == 'syllabus' && $parent == 'class')
          <th>Class</th>
        @elseif($upload_type == 'routine' && $parent == 'section')
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
          <td>{{$file->myclass->class_number}}</td>
        @elseif($upload_type == 'routine' && $parent == 'section')
          <td>{{$file->section->section_number}}</td>
        @endif
        <td>{{($file->active === 1)?'Yes':'No'}}</td>
        <td>
          <a href="{{url('academic/remove/'.$upload_type.'/'.$file->id)}}" class="btn btn-danger btn-lg" role="button">Remove</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
