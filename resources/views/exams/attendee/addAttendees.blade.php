@extends('layouts.student-app')
@section('title', 'Add Attendee')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-users"></i>
            Add Attendees ({{ $exam->exam_name }})
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li><a href="{{ route('exams') }}">Manage Exams</a></li>
            <li><a href="{{ route('exams.attendees', ['exam_id' => $exam->id]) }}">Attendees</a></li>
            <li>Add Attendee </li>
        </ul>
    </div>
      @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card height-auto">
        <div class="card-body">
            @if(!$students->isEmpty())
                <div class="row mb-3">
                    <div class="form-group col-md-2">
                        <button onclick="addAttendee()" type="button" class="button button--save font-weight-bold"><i class="fas fa-plus"></i> Add</button>
                    </div>
                </div>
                <form id="attendeesForm" method="POST" action="{{ route('exams.store.attendees', ['exam_id' => $exam->id]) }}">
                {{ csrf_field() }}
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" id="checkAll" title="Select All"/></th>
                            <th>Student Code</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <th scope="row"><input type="checkbox" name="user_ids[]" value="{{$student->id}}" /></th>
                            <td class="text-capitalize">{{ $student->student_code }}</td>
                            <td><a href="{{ route('user.show', ['user_code' => $student->student_code]) }}" class="text-teal">{{ $student->name }}</a></td>
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
                <p class="text-center">No data found</p>
            @endif
        </div>
    </div>
@endsection
@push('customjs')
  <script type="text/javascript">
    jQuery(document).ready(function(){
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    });
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
    
    function addAttendee() {
        let user_ids = [];
        
        $("input[name='user_ids[]']").each(function () {
            if($(this).is(":checked")){
                user_ids.push($(this).val());
            }
        });

        if (user_ids.length > 0){
            $('#attendeesForm').submit();
        } else {
            showAlert();
        }
    }
    function showAlert() {
        swal({
            title: "No Student Selected",
            text: "Please select at least one student",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: {
                cancel: false,
                confirm: true,
            },
        })
        .then((willDelete) => {
            if (willDelete) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endpush
