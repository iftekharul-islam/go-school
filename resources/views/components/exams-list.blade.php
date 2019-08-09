<div class="card mb-3" style="border-radius: 0 !important;">
  <div class="card-header" style="background-color: #28978B; color: white">Information</div>
  <div class="card-body">
    An Examination represents a term. All Courses of a term belong to an Examination. So, all Quiz, Class Test, Assignment, Attendance, Written, Practical, etc. in a Course are subjected to that specific Examination.
  </div>
</div>
{{$exams->links()}}
<div class="table-responsive">
  @foreach ($exams as $exam)
    <form id="form{{$exam->id}}" action="{{url('admin/exams/activate-exam')}}" method="POST">
      {{csrf_field()}}
    </form>
  @endforeach'
  <table class="table display text-nowrap">
    <thead>
    <tr>
      <th>#</th>
      <th>Examination Name</th>
      <th>Notice Published</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Result Published</th>
      <th>Set Active</th>
      <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($exams as $exam)
      <tr>
        <th>{{($loop->index + 1)}}</th>
        <td>{{$exam->exam_name}}</td>
        <td>
          @if($exam->notice_published === 1)
            Yes
          @else
            @if($exam->result_published === 1)
              No
            @else
              <label class="checkbox-label">
                <input type="checkbox" name="notice_published" form="form{{$exam->id}}" />
                Yes
                <span class="checkmark"></span>
              </label>
            @endif
          @endif
        </td>
        <td>{{Carbon\Carbon::parse($exam->start_date)->format('d/m/Y')}}</td>
        <td>{{Carbon\Carbon::parse($exam->end_date)->format('d/m/Y')}}</td>
        <td>
          @if($exam->result_published === 1)
            Yes
          @else
            <label class="checkbox-label">
              <input type="checkbox" name="result_published" form="form{{$exam->id}}" />
              Yes
              <span class="checkmark"></span>
            </label>
          @endif
        </td>
        <td>
          <input type="hidden" name="exam_id" value="{{$exam->id}}" form="form{{$exam->id}}"/>
          @if($exam->active === 1)
            <label class="checkbox-label">
              <input type="checkbox" name="active" form="form{{$exam->id}}" checked />
              Active
              <span class="checkmark"></span>
            </label>
          @else
            @if($exam->result_published === 1)
              Completed
            @else
              <label class="checkbox-label">
                <input type="checkbox" name="active" form="form{{$exam->id}}" />
                Not Active
                <span class="checkmark"></span>
              </label>
            @endif
          @endif
          @if($exam->result_published != 1)
            <span>
          <input type="submit" class="button button--save float-right" style="margin-left: 1%;" value="Save" form="form{{$exam->id}}"/>
        </span>
          @endif
        </td>
        <td>
          <button class="btn btn-danger btn-lg" type="button" onclick="removeExam({{ $exam->id }})"><i class="far fa-trash-alt"></i></button>
          <form id="delete-form-{{ $exam->id }}" action="{{ url('admin/exams/remove', ['id' => $exam->id]) }}" method="GET" style="display: none;">
            @csrf
            @method('GET')
          </form>
          <a href="{{ url('admin/exams/edit', ['id' => $exam->id]) }}">
            <button class="btn btn-info btn-lg ml-3"><i class="far fa-edit"></i></button>
          </a>

        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>

@push('customjs')
  <script type="text/javascript">
    function removeExam(id) {
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
    }
  </script>
@endpush