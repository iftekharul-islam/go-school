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
                <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
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
                    <table class="table table-data-div text-wrap">
                        <thead>
                            <tr>
                                <th width="10%">Name</th>
                                <th width="5%">Code</th>
                                <th width="10%">Email</th>
                                <th width="10%">Phone Number</th>
                                <th width="15%">Address</th>
                                <th width="30%">About</th>
                                <th width="5%">Edit</th>
                                <th width="5%">Activate/Deactivate</th>
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
                                <td>{{$admin->address}}</td>
                                <td>{{$admin->about}}</td>
                                <td>
                                    <a href="{{url('edit/user/'.$admin->id)}}" class="button button--edit"
                                       role="button">Edit</a>
                                </td>
                                <td class="text-center">
                                    @if($admin->active == 0)
                                        <button class="button button--save" type="button" onclick="removeUser({{ $admin->id }})">Active</button>
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
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
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
                        }
                    });
            }
        </script>
    @endpush
@endsection