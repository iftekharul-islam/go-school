@extends('layouts.student-app')

@section('title', 'Inactive Users')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-user-friends"></i>
            All Inactive Staff
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Inactive Staff</li>
        </ul>
    </div>

    <div class="card false-height">
        @if (count($users) > 0)
            <div class="card-body">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @elseif(session('error-status'))
                    <div class="alert alert-success">
                        {{ session('error-status') }}
                    </div>
                @endif
                <form id="userBulkAction" action="{{ route('user.bulk.action') }}" method="post"> {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group">
                                <select id='action' name="action" class="form-control form-control-sm">
                                    <option value="" disabled selected>Bulk Action</option>
                                    <option value="activate">Activate</option>
                                    <option value="delete">Delete Permanently</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered display text-wrap">
                            <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" id="checkAll" title="Select All"/></th>
                                <th>Code</th>
                                <th>Full Name</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $key=>$user)
                                <tr>
                                    <th scope="row"><input type="checkbox" name="user_ids[]" value="{{$user->id}}" /></th>
                                    <td>{{$user->student_code}}</td>
                                    <td>
                                        <a class="text-teal" href="{{url('/user/'.$user->student_code)}}">{{$user->name}}</a>
                                    </td>
                                    <td>
                                        {{$user->email}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        @else
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <p class="text-center pt-3">No Data Found</p>
                </div>
            </div>
        @endif
    </div>
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
                        }
                    });
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
@endsection
