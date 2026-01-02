@extends('admin.layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5>Create Permission</h5>

    <div class="card mt-3">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.permissions.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Permission Name</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary">Save</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>
    </div>
</div>
@endsection
