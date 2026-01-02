@extends('admin.layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between mb-3">
        <h5>Permissions</h5>

        @can('manage permissions')
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
            + Create Permission
        </a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Permission</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <a href="{{ route('admin.permissions.edit',$permission->id) }}"
                                   class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('admin.permissions.destroy',$permission->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete permission?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
