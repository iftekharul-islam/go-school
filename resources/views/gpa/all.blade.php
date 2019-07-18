@extends('layouts.student-app')
@section('title', 'All GPA Systems')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Grade System
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Grade System</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
                <h4><i class="fas fa-poll text-teal"></i> Grade Title: <strong>{{$gpa->grade_system_name   }}</strong></h4>
                <div class="table-responsive">
                    <table class="table display table-bordered  text-nowraps">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Grade</th>
                            <th>Point</th>
                            <th>From Mark</th>
                            <th>To Mark</th>
                            <th width="12%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($gpa->gradeSystemInfo as $gpainfo)
                            <tr>
                                <td>{{($loop->index + 1)}}</td>
                                <td>{{$gpainfo->grade}}</td>
                                <td>{{$gpainfo->grade_points}}</td>
                                <td>{{$gpainfo->marks_from}}</td>
                                <td>{{$gpainfo->marks_to}}</td>
                                <td>
                                  <div class="row text-center">
                                      <div class="col-6">
                                          <a class="button button--edit" href="{{ url('admin/gpa/edit',$gpainfo->id ) }}"><i class="far fa-edit"></i>&nbsp;Edit</a>
                                      </div>
                                      <div class="col-6">
                                          <button  onclick="removeGrade({{ $gpainfo->id}})" class="button button--cancel" ><i class="far fa-trash-alt"></i>Delete</button>
                                          <form id="delete-form-{{ $gpainfo->id }}" class="form-group" action="{{ url('admin/gpa/delete', $gpainfo->id) }}" method="post">
                                              {{ method_field('DELETE') }}
                                              {{ csrf_field() }}
                                          </form>
                                      </div>
                                  </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
    <script type="text/javascript">
        function removeGrade(id) {
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
                        setTimeout(5000);
                        swal("Poof! Your Selected data has been deleted!", {
                            icon: "success",
                        });
                    }
                });
        }
    </script>
@endsection
