@extends('layouts.student-app')

@section('title', 'Admins')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            All Admin
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Admin</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if(count($admins) > 0)
                <div class="table-responsive">
                    <table class="table table-data-div">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                            <tr>
                                <td>
                                    {{$admin->name}}
                                </td>
                                <td>{{$admin->student_code}}</td>
                                <td>{{$admin->email}}</td>
                                <td>{{$admin->phone_number}}</td>
                                <td width="25%">{{$admin->address}}</td>
                                <td class="text-center">
                                    <a href="{{url('master/edit/admin/'.$admin->id)}}" class="button button--edit mr-3" role="button"><i class="fas fa-edit"></i></a>
                                    @if($admin->active == 0)
                                        <button class="button button--save" type="button" onclick="activeUser({{ $admin->id }})">Active</button>
                                        <form id="delete-form-{{ $admin->id }}" action="{{url('master/activate-admin/'.$admin->id)}}" method="GET" style="display: none;">
                                            @csrf
                                            @method('GET')
                                        </form>
                                    @else
                                        <button class="button button--cancel" type="button" onclick="removeUser({{ $admin->id }})">Deactivate</button>
                                        <form id="delete-form-{{ $admin->id }}" action="{{url('master/activate-admin/'.$admin->id)}}" method="GET" style="display: none;">
                                            @csrf
                                            @method('GET')
                                        </form>
                                    @endif
                                    <button class="button button--cancel ml-3" type="button" onclick="deleteUser({{ $admin->id }})">Delete</button>
                                    <form id="delete-admin-form-{{ $admin->id }}" action="{{ route('delete-admin', $admin->id) }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
        </div>
            <div class="card-body mt-5 text-center">
                No Related Data Found.
            </div>
        @endif
    </div>
    @push('customjs')
        <script type="text/javascript">
            function removeUser(id) {
                swal({
                    title: "Are you sure?",
                    text: "You are about to deactivate an Admin!",
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
            function activeUser(id) {
                swal({
                    title: "Are you sure?",
                    text: "Do you really want to activate this user?",
                    icon: "success",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            document.getElementById('delete-form-'+id).submit();
                        }
                    });
            } function deleteUser(id) {
                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to delete this user? Once deleted you won't be able to recover this data",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            document.getElementById('delete-admin-form-'+id).submit();
                        }
                    });
            }
        </script>
    @endpush
@endsection
