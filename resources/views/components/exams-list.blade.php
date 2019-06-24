<div class="card mb-3">
    <div class="card-header" style="background-color: #28978B; color: white">Information</div>
    <div class="card-body">
      An Examination represents a Semester. All Courses of a Semester belong to an Examination. So, all Quiz, Class Test, Assignment, Attendance, Written, Practical, etc. in a Course are subjected to that specific Examination.
    </div>
</div>
{{$exams->links()}}
<div class="table-responsive">
  @foreach ($exams as $exam)
    <form id="form{{$exam->id}}" action="{{url('exams/activate-exam')}}" method="POST">
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
          <input type="submit" class="button2 button2--white button2--animation float-right" style="margin-left: 1%;" value="Save" form="form{{$exam->id}}"/>
        </span>
          @endif
        </td>
        <td>
          <button class="btn btn-danger btn-lg" onclick="removeExam()"><i class="fas fa-trash-alt"></i></button>
          <a id="delete-form" href="{{ url('exams/remove', ['id' => $exam->id]) }}"></a>
          <a href="{{ url('exams/edit', ['id' => $exam->id]) }}">
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
    function removeExam() {
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

{{--<div class="table-responsive">--}}
{{--  @foreach ($exams as $exam)--}}
{{--    <form id="form{{$exam->id}}" action="{{url('exams/activate-exam')}}" method="POST">--}}
{{--      {{csrf_field()}}--}}
{{--    </form>--}}
{{--  @endforeach--}}
{{--  <table class="table table-striped table-hover">--}}
{{--  <thead>--}}
{{--    <tr>--}}
{{--      <th scope="col">#</th>--}}
{{--      <th scope="col">Examination Name</th>--}}
{{--      <th scope="col">Notice Published</th>--}}
{{--      <th scope="col">Result Published</th>--}}
{{--      <th scope="col">Created At</th>--}}
{{--      <th scope="col">Set Active</th>--}}
{{--    </tr>--}}
{{--  </thead>--}}
{{--  <tbody>--}}
{{--    @foreach ($exams as $exam)--}}
{{--    <tr>--}}
{{--      <th scope="row">{{($loop->index + 1)}}</th>--}}
{{--      <td scope="row">{{$exam->exam_name}}</td>--}}
{{--      <td scope="row">--}}
{{--        @if($exam->notice_published === 1)--}}
{{--          Yes--}}
{{--        @else--}}
{{--          @if($exam->result_published === 1)--}}
{{--            No--}}
{{--          @else--}}
{{--            <label class="checkbox-label"> Yes--}}
{{--              <input type="checkbox" name="notice_published" form="form{{$exam->id}}" />--}}
{{--              <span class="checkmark"></span>--}}
{{--            </label>--}}
{{--          @endif--}}
{{--        @endif--}}
{{--      </td>--}}
{{--      <td scope="row">--}}
{{--        @if($exam->result_published === 1)--}}
{{--          Yes--}}
{{--        @else--}}
{{--          <label class="checkbox-label"> Yes--}}
{{--            <input type="checkbox" name="result_published" form="form{{$exam->id}}" />--}}
{{--            <span class="checkmark"></span>--}}
{{--          </label>--}}
{{--        @endif--}}
{{--      </td>--}}
{{--      <td scope="row">{{Carbon\Carbon::parse($exam->created_at)->format('d/m/Y')}}</td>--}}
{{--      <td scope="row">--}}
{{--        <input type="hidden" name="exam_id" value="{{$exam->id}}" form="form{{$exam->id}}"/>--}}
{{--        @if($exam->active === 1)--}}
{{--          <label class="checkbox-label">--}}
{{--              Active--}}
{{--            <input type="checkbox" name="active" form="form{{$exam->id}}" checked />--}}
{{--            <span class="checkmark"></span>--}}
{{--          </label>--}}
{{--        @else--}}
{{--          @if($exam->result_published === 1)--}}
{{--            Completed--}}
{{--          @else--}}
{{--            <label class="checkbox-label">--}}
{{--              Not Active--}}
{{--              <input type="checkbox" name="active" form="form{{$exam->id}}" />--}}
{{--              <span class="checkmark"></span>--}}
{{--            </label>--}}
{{--          @endif--}}
{{--        @endif--}}
{{--        @if($exam->result_published != 1)--}}
{{--        <span>--}}
{{--          <input type="submit" class="btn btn-info btn-xs pull-right" style="margin-left: 1%;" value="Save" form="form{{$exam->id}}"/>--}}
{{--        </span>--}}
{{--        @endif--}}
{{--      </td>--}}
{{--    </tr>--}}
{{--    @endforeach--}}
{{--  </tbody>--}}
{{--</table>--}}
{{--</div>--}}
{{--{{$exams->links()}}--}}
{{--<style>--}}
{{--.checkbox-label {--}}
{{--  position: relative;--}}
{{--  padding-left: 35px;--}}
{{--  cursor: pointer;--}}
{{--  -webkit-user-select: none;--}}
{{--  -moz-user-select: none;--}}
{{--  -ms-user-select: none;--}}
{{--  user-select: none;--}}
{{--}--}}

{{--.checkbox-label input {--}}
{{--  position: absolute;--}}
{{--  opacity: 0;--}}
{{--  cursor: pointer;--}}
{{--  height: 0;--}}
{{--  width: 0;--}}
{{--}--}}
{{--.checkmark {--}}
{{--  position: absolute;--}}
{{--  top: 0;--}}
{{--  left: 0;--}}
{{--  height: 25px;--}}
{{--  width: 25px;--}}
{{--  background-color: #0000004d;--}}
{{--  border-radius: 15px;--}}
{{--}--}}

{{--.checkbox-label:hover input ~ .checkmark {--}}
{{--  background-color: #ccc;--}}
{{--}--}}

{{--.checkbox-label input:checked ~ .checkmark {--}}
{{--  background-color: #E74C3C;--}}
{{--}--}}

{{--.checkmark:after {--}}
{{--  content: "";--}}
{{--  position: absolute;--}}
{{--  display: none;--}}
{{--}--}}

{{--.checkbox-label input:checked ~ .checkmark:after {--}}
{{--  display: block;--}}
{{--}--}}

{{--.checkbox-label .checkmark:after {--}}
{{--  left: 10px;--}}
{{--  top: 6px;--}}
{{--  width: 5px;--}}
{{--  height: 10px;--}}
{{--  border: solid #fff;--}}
{{--  border-width: 0 3px 3px 0;--}}
{{--  -webkit-transform: rotate(45deg);--}}
{{--  -ms-transform: rotate(45deg);--}}
{{--  transform: rotate(45deg);--}}
{{--}--}}
{{--</style>--}}
