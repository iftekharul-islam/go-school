@extends('layouts.student-app')
@section('title', 'Fee Types')
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Fee Types</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Manage Accounts</li>
                <li>Fee Collection</li>
                <li>Fee Types</li>
            </ul>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card height-auto false-height">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3 class="float-left mb-5">Fee Types</h3>
                        <a href="{{ url(auth()->user()->role.'/fee-types/create') }}" class="button button--save float-right"><i class="fas fa-plus-circle"></i> Add Fee Type</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display text-wrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Year</th>
                            <th>Code</th>
                            <th width="40%">Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feeTypes as $feeType)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $feeType->name }}</td>
                                <td>{{ $feeType->year }}</td>
                                <td>{{ $feeType->code }}</td>
                                <td>{{ $feeType->description }}</td>
                                <td>
                                    @if($feeType->is_default == 0)
                                    <a href="{{ url(auth()->user()->role.'/fee-types/'.$feeType->id.'/edit') }}" class="button button--save mr-3"><i class="far fa-edit"></i></a>
                                    <button class="button button--cancel" onclick="feeTypes({{ $feeType->id }})"><i class="far fa-trash-alt"></i></button>
                                    <form id="delete-form-{{ $feeType->id }}" action="{{ url(auth()->user()->role.'/fee-types', $feeType->id) }}" method="POST">
                                        {!! method_field('delete') !!}
                                        {!! csrf_field() !!}
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
    <script type="text/javascript">
        function feeTypes(id) {
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
                        swal("Done! Your Selected file has been deleted!", {
                            icon: "success",
                        });
                    }
                });
        }
    </script>
@endpush
