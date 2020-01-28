@extends('layouts.student-app')
@section('title', 'Examination Results')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-alt"></i>
           Results
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Results</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if(!$exams->isEmpty())
           <div class="table-responsive">
                
                <table class="table display text-nowrap">
                    <thead>
                        <tr>
                            <th>Term</th>
                            <th>Examination Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Publish</th>
                            <th>Active</th>
                            <th>File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($exams as $exam)
                        <tr>
                            <td class="text-capitalize">{{ $exam->term }}</td>
                            <td>{{ $exam->exam_name }}</td>
                            <td>{{ Carbon\Carbon::parse($exam->start_date)->format('d/m/Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($exam->end_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($exam->result_published == 1)
                                   <span class="badge badge-info">Yes</span>
                                @else
                                    <span class="badge badge-warning">No</span>
                                @endif
                            </td>
                            <td>
                                @if($exam->active == 1)
                                   <span class="badge badge-info">Yes</span>
                                @else
                                    <span class="badge badge-warning">No</span>
                                @endif
                            </td>
                            <td>
                                @if ($exam->result_file)
                                    <a href="{{route('exams.download.result',['exam_id' => $exam->id])}}" title="Download" class="btn btn-info btn-lg"><i class="fas fa-download"></i></a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-danger btn-lg" type="button" onclick="removeExam({{ $exam->id }})"><i class="far fa-trash-alt"></i></button>
                                <form id="delete-form-{{ $exam->id }}" action="{{ route('exams.remove.result', ['exam_id' => $exam->id]) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                <a href="{{ route('exams.edit.result', ['exam_id' => $exam->id]) }}">
                                    <button class="btn btn-info btn-lg ml-3"><i class="fa fa-upload"></i></button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                
                <div class="float-right">{{ $exams->links() }}</div>
                
            @endif
        </div>
    </div>
@endsection
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
