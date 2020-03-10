@extends('layouts.student-app')

@section('title', 'All Departments')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class='fas fa-microscope'></i>
            {{ __("text.All Department") }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __("text.All Department") }}</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card height-auto false-height">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(count($dpts) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered display text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('text.Name') }}</th>
                                    <th>{{ __("text.total_teacher") }}</th>
                                    <th>{{ __('text.Total Students') }}</th>
                                    <th>{{ __('text.teacher_list') }}</th>
                                    <th>{{ __('text.student_list') }}</th>
                                    <th>{{ __('text.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($adminWithDepartment->count() > 0)
                                    @foreach($adminWithDepartment as $index=>$dp)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $dp->department_name }}</td>
                                            <td>{{ $dp->teachers->count() }}</td>
                                            <td>{{ $dp->students->count() }}</td>
                                            <td>
                                                <a href="{{ url('admin/department-teachers', $dp->id) }}"
                                                   class="button btn-link text-teal">View Department Teachers</a>
                                            </td>
                                            <td>
                                                <a href="{{ url('admin/department-students', $dp->id) }}"
                                                   class="button btn-link text-teal">View Department Students</a>
                                            </td>
                                            <td>
                                                <a class="btn btn-lg btn-primary mr-3"
                                                   href="{{url('admin/department/'.$dp->id.'/edit')}}"><i
                                                            class="far fa-edit"></i></a>
                                                <button class="btn btn-danger btn-lg" type="button"
                                                        onclick="removeDepartment({{ $dp->id }})">
                                                    <i class="far fa-trash-alt"></i></button>
                                                <form id="delete-form-{{ $dp->id }}"
                                                      action="{{ url('admin/department/'.$dp->id) }}"
                                                      method="post" style="display: none;">
                                                    @csrf
                                                    {{ method_field('delete') }}
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    @foreach($dpts as $index=>$dp)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $dp->department_name }}</td>
                                            <td>{{ $dp->teachers->count() }}</td>
                                            <td>{{ $dp->students->count() }}</td>
                                            <td>
                                                <a href="{{ url('admin/department-teachers', $dp->id) }}"
                                                   class="button btn-link text-teal">View Department Teachers</a>
                                            </td>
                                            <td>
                                                <a href="{{ url('admin/department-students', $dp->id) }}"
                                                   class="button btn-link text-teal">View Department Students</a>
                                            </td>
                                            <td>
                                                <a class="btn btn-lg btn-primary mr-3"
                                                   href="{{url('admin/department/'.$dp->id.'/edit')}}"><i
                                                            class="far fa-edit"></i></a>
                                                <button class="btn btn-danger btn-lg" type="button"
                                                        onclick="removeDepartment({{ $dp->id }})">
                                                    <i class="far fa-trash-alt"></i></button>
                                                <form id="delete-form-{{ $dp->id }}" action="{{ route('delete-department', $dp->id) }}"
                                                      method="post" style="display: none;">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
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
                        <div class="card-body text-center">
                            <h6>No Department Found</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
