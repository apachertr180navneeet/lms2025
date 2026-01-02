@extends('admin.layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5>Create Role</h5>

    <div class="card mt-3">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Role Name</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Assign Permissions</label>
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-4 mb-2">
                                <label class="form-check-label">
                                    <input type="checkbox"
                                           class="form-check-input"
                                           name="permissions[]"
                                           value="{{ $permission->name }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button class="btn btn-primary">Save Role</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>
    </div>
</div>
@endsection
