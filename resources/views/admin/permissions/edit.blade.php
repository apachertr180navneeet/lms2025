@extends('admin.layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5>Edit Permission</h5>

    <div class="card mt-3">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.permissions.update',$permission->id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Permission Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ $permission->name }}">
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>
    </div>
</div>
@endsection
