@extends('layouts.student-app')

@section('title', 'Inactive Users')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-user-friends"></i>
            All Inactive {{ $type }}
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Inactive {{ $type }}</li>
        </ul>
    </div>

    <div class="card false-height">
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
            <div class="table-responsive">
                <table class="table table-data-div table-bordered display text-wrap">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th>Code</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $key=>$user)
                        <tr>
                            <th scope="row">{{ $loop->index+1 }}</th>
                            <td>{{$user->student_code}}</td>
                            <td>
                                <a class="text-teal" href="{{url('/user/'.$user->student_code)}}">{{$user->name}}</a>
                            </td>
                            <td>
                                {{$user->email}}
                            </td>
                            <td>
                                <button class="button button--save" type="button" onclick="removeUser({{ $user->id }})"><i class="fas fa-user-check"></i>  Activate</button>
                                    <form id="delete-form-{{ $user->id }}" action="{{ url('admin/user/activate/'.$user->id) }}" method="GET" style="display: none;">
                                        @csrf
                                        @method('GET')
                                    </form>
                                <button class="button ml-1 button--cancel " type="button" onclick="deleteUser({{ $user->id }})">
                                    <i class="far fa-trash-alt mr-1"></i>Delete</button>
                                <form id="delete-user-form-{{ $user->id }}" action="{{ route('delete-user', $user->id) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                </form>
                                </button>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>

    @push('customjs')
        <script type="text/javascript">
            function removeUser(id) {
                swal({
                    title: "Are you sure?",
                    text: "Selected user status will be changed to activate",
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
            function deleteUser(id) {
                swal({
                    title: "Are you sure?",
                    text: "Selected user will be deleted permanently",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            document.getElementById('delete-user-form-'+id).submit();
                        }
                    });
            }
        </script>
    @endpush
@endsection
