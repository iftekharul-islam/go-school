<div class="card mb-3" style="border-radius: 0 !important;">
  <div class="card-header" style="background-color: #28978B; color: white">{{ __('text.information') }}</div>
  <div class="card-body">
    {{ __('text.exam_manage_info') }}
  </div>
</div>
{{$exams->links()}}

<div class="table-responsive">
  @foreach ($exams as $exam)
    <form id="form{{$exam->id}}" action="{{url('admin/exams/activate-exam')}}" method="POST">
      {{csrf_field()}}
    </form>
  @endforeach
  <table class="table display text-nowrap mt-3">
    <thead>
    <tr>
      <th>#</th>
      <th>{{ __('text.term') }}</th>
      <th>{{ __('text.exam_name') }}</th>
      <th>{{ __('text.notice_published') }}</th>
      <th>{{ __('text.Start Date') }}</th>
      <th>{{ __('text.End Date') }}</th>
      <th>{{ __('text.result_published') }}</th>
      <th>{{ __('text.is_active') }}</th>
      <th>{{ __('text.action') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($exams as $exam)
      <tr>
        <th>{{($loop->index + 1)}}</th>
        <td class="text-capitalize">{{ $exam->term }}</td>
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
          @if($exam->active == 1)
            <label class="checkbox-label">
              <input type="checkbox" name="active" form="form{{$exam->id}}" checked />
              <span class="badge badge-info ml-1">Active</span>
              <span class="checkmark"></span>
            </label>
          @else
            @if($exam->result_published === 1)
              <span class="badge badge-success">Completed</span>
            @else
              <label class="checkbox-label">
                <input type="checkbox" name="active" form="form{{$exam->id}}" />
                <span class="badge badge-warning ml-1">Not Active</span>
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
          <a href="{{ route('exams.attendees',['exam_id' => $exam->id]) }}" class="btn btn-lg btn-primary text-white ml-3" title="Attendees"><i class="fas fa-users"></i></a>
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
        text: "Once deleted, you will not be able to recover this data!",
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
