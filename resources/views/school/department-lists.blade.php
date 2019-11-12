@extends('layouts.student-app')

@section('title', 'List Of All Departments')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class='fas fa-microscope'></i>
            List Of All Departments
        </h3>
        <ul>
            <li><a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>List Of All Departments</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card height-auto false-height">
                <div class="card-body">
                    @if(count($departments) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered display text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($departments as $index=>$department)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $department->department_name }}</td>
                                        <td>
                                            <a class="btn btn-lg btn-primary mr-3"
                                               href="{{url('admin/department/'.$department->id.'/edit')}}"><i
                                                        class="far fa-edit"></i></a>
                                            <button class="btn btn-danger btn-lg" type="button"
                                                    onclick="removeDepartment({{ $department->id }})">
                                                <i class="far fa-trash-alt"></i></button>
                                            <form id="delete-form-{{ $department->id }}"
                                                  action="{{ url('admin/department/'.$department->id) }}"
                                                  method="post" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @push('customjs')
                                <script type="text/javascript">
                                    function removeDepartment(id) {
                                        swal({
                                            title: "Are you sure?",
                                            text: "Once deleted, you will not be able to recover this user!",
                                            icon: "warning",
                                            buttons: true,
                                            dangerMode: true,
                                        })
                                            .then((willDelete) => {
                                                if (willDelete) {
                                                    document.getElementById('delete-form-' + id).submit();
                                                }
                                            });
                                    }
                                </script>
                            @endpush
                        </div>
                    @else
                        No Department Found
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection