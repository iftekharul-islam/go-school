@extends('layouts.student-app')
@section('title', 'All GPA Systems')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-poll-h"></i>
            {{ __("text.grade_system") }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __("text.grade_system") }}</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        @if($gpa)
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <h4>
                    <i class="fas fa-poll text-teal"></i>
                    {{ __('text.grade_title') }}:
                    <strong>{{ $gpa->grade_system_name  }}</strong>
                    <a href="{{ route('gpa.system.edit', $gpa->id) }}" class="btn btn-primary ml-3">
                        <i class="far fa-edit"></i>
                    </a>
                </h4>
                <div class="card-body" style="padding-top: 0px;">
                    <div class="alert alert-info alert-dismissible mt-5" style="font-size:13px; margin-top: 10px;">
                            <ul>
                                <li>
                                    How to Create New Grade:
                                </li>
                                <li>
                                    <b>Grade added from bottom to top .Eg : F, D, C, B, A, A+ (Ascending Order)</b>.
                                </li>
                            </ul>
                        </div>
                    <div class="table-responsive">
                        <table class="table display table-bordered  text-nowraps">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('text.Grades') }}</th>
                                <th>{{ __('text.grade_point') }}</th>
                                <th>{{ __('text.from_mark') }}</th>
                                <th>{{ __('text.to_mark') }}</th>
                                <th width="15%">{{ __('text.action') }}</th>
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
                                                <a class="button button--edit" href="{{ url('admin/gpa/edit',$gpainfo->id ) }}"><i class="far fa-edit"></i></a>
                                            </div>
                                            <div class="col-6">
                                                <button  onclick="removeGrade({{ $gpainfo->id}})" class="button button--cancel" ><i class="far fa-trash-alt"></i></button>
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
        @else
            <div class="card mt-5 false-height">
                <div class="card-body">
                    <div class="card-body mt-5 text-center">
                        No Grade System Available!
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script type="text/javascript">
        function removeGrade(id) {
            swal({
                title: "{{ __('text.conform_msg') }}",
                text: "{{ __('text.conform_info') }}",
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
