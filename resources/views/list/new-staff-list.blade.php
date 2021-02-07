@extends('layouts.student-app')

@section('title', 'Notices')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-users mr-2 "></i>   {{ __('text.staff_list') }}
            <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.staffs') }}">Inactive Staffs</a>
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>
                {{ __('text.staff_list') }}
            </li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @elseif(session('error-status'))
        <div class="alert alert-success">
            {{ session('error-status') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card height-auto">
        <div class="card-body">
            @if(count($users) > 0)
                <form id="userBulkAction" action="{{ route('user.bulk.action') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('post') }}
                    <div class="row">
                        @if (auth()->user()->role == 'admin')
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <select id='action' name="action" class="form-control form-control-sm">
                                        <option value="" disabled selected>Bulk Action</option>
                                        <option value="deactivate">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mb-5">
                        <table class="table table-bordered table-data-div list display text-wrap">
                            <thead>
                            <tr>
                                @if (auth()->user()->role == 'admin')
                                    <th scope="col"><input type="checkbox" id="checkAll" title="Select All"/></th>
                                @endif
                                <th>{{ __('text.Code') }}</th>
                                <th>{{ __('text.Name') }}</th>
                                <th>{{ __('text.designation') }}</th>
                                <th>{{ __('text.Attendance') }}</th>
                                <th>{{ __('text.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $key=>$user)
                                <tr>
                                    @if (auth()->user()->role == 'admin')
                                        <th scope="row"><input type="checkbox" name="user_ids[]" value="{{$user->id}}" /></th>
                                    @endif
                                    <td>{{$user->student_code}}</td>
                                    <td>
                                        <a class="text-teal" href="{{url('user/'.$user->student_code)}}">{{$user->name}}</a>
                                    </td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <a href="{{ url('admin/staff/attendance/'.$user->id) }}" class="btn-link text-teal">View</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-lg btn-primary" href="{{url('admin/edit/user/'.$user->id)}}" title="Update"><i class="far fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-5">
                            <div class="col-md-9 col-sm-12 text-right">
                                <div class="paginate123 float-right">
                                    {{ $users->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            @else
                <p class="text-center">{{ __('text.No_related_data_notification') }}</p>
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

            $('#action').change(function(){
                let action = $(this).val();
                let user_ids = [];

                $("input[name='user_ids[]']").each(function () {
                    if($(this).is(":checked")){
                        user_ids.push($(this).val());
                    }
                });

                if(user_ids.length > 0){
                    submitForm('userBulkAction');
                } else {
                    showAlert();
                    $('#action').prop('selectedIndex',0);
                }
            });
        });

        function submitForm(formId) {
            swal({
                title: "Are you sure?",
                text: " You want to perform this action!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById(formId).submit();
                    }else {
                        document.getElementById(formId).reset();
                    }
                });
        }
        function showAlert(formId) {
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
        function resetFilter() {
            $('#filter input[name=student_name]').val('');
            $("#filter select").empty();
            $("#filter").submit();
        }
        function deleteUser(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Message!",
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
