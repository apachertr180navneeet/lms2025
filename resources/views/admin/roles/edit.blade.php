@extends('admin.layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5>Edit Role</h5>

    <div class="card mt-3">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.roles.update',$role->id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Role Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ $role->name }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Permissions</label>
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-4 mb-2">
                                <label>
                                    <input type="checkbox"
                                           name="permissions[]"
                                           value="{{ $permission->name }}"
                                           {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button class="btn btn-primary">Update Role</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>
    </div>
</div>
@endsection
