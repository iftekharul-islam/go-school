@extends('layouts.student-app')

@section('title', 'Admins')

@section('content')
    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4>
            </a>&nbsp;&nbsp;All Admin
        </h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
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
                    <table class="table display data-table text-wrap">
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>About</th>
                            <th>Action</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>
                                    {{$admin->name}}
                                </td>
                                <td>{{$admin->student_code}}</td>
                                <td>{{$admin->email}}</td>
                                <td>{{$admin->phone_number}}</td>
                                <td>{{$admin->address}}</td>
                                <td>{{$admin->about}}</td>
                                <td>
                                    @if($admin->active == 0)
                                        <button class="btn btn-success btn-lg" type="button" onclick="removeUser({{ $admin->id }})">Active</button>
                                        <form id="delete-form-{{ $admin->id }}" action="{{url('master/activate-admin/'.$admin->id)}}" method="GET" style="display: none;">
                                            @csrf
                                            @method('GET')
                                        </form>
                                    @else
                                        <button class="btn btn-danger btn-lg" type="button" onclick="removeUser({{ $admin->id }})">Deactivate</button>
                                        <form id="delete-form-{{ $admin->id }}" action="{{url('master/activate-admin/'.$admin->id)}}" method="GET" style="display: none;">
                                            @csrf
                                            @method('GET')
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('edit/user/'.$admin->id)}}" class="btn btn-lg btn-info"
                                       role="button">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @else
        </div>
            <div class="card-body">
                No Related Data Found.
            </div>
        @endif
    </div>
    @push('customjs')
        <script type="text/javascript">
            function removeUser(id) {
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
                        } else {
                            swal("Your Delete Operation has been canceled");
                        }
                    });
            }
        </script>
    @endpush
@endsection