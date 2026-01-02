@extends('admin.layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Roles</h5>

        @can('manage roles')
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            + Create Role
        </a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Role Name</th>
                        <th>Permissions</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-dark">
                                    {{ $role->name }}
                                </span>
                            </td>
                            <td>
                                @foreach($role->permissions as $permission)
                                    <span class="badge bg-info text-dark mb-1">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('admin.roles.edit',$role->id) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('admin.roles.destroy',$role->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this role?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No roles found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
