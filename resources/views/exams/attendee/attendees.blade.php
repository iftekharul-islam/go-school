@extends('layouts.student-app')
@section('title', 'Attendees')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-users"></i>
            Attendees 
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li><a href="{{ route('exams') }}">Manage Exams</a></li>
            <li>Attendees</li>
        </ul>
    </div>
      @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card height-auto">
        <div class="card-body">
            <div class="row mb-3">
               
                <div class="form-group offset-md-10 col-md-2">
                    <a href="{{ route('exams.add.attendee', [ 'exam_id' => $exam->id ]) }}" class="button button--save font-weight-bold ml-md-3 float-right"><i class="fas fa-plus-circle"></i> Add Attendee</a>
                </div>
            </div>
            @if(!empty($students))
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Student Code</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Section</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td class="text-capitalize">{{ $student->student_code }}</td>
                            <td><a href="{{ route('user.show', ['user_code' => $student->student_code]) }}" class="text-teal">{{ $student->name }}</a></td>
                            <td>{{ $student->section['class']['class_number'] }}</td>
                            <td>{{ $student->section['section_number'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                
                <div class="row mt-5">
                    <div class="col-md-2 col-sm-12">
                        Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }}
                    </div>
                    <div class="col-md-10 col-sm-12 text-right">
                        <div class="paginate123 float-right">
                            {{ $students->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @else 
                <p class="text-center">No Attendee found</p>
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
    function resetFilter() {
            $('#filter input[name=student_name]').val('');
            $("#filter select").empty();
            $("#filter").submit();
        }
  </script>
@endpush
