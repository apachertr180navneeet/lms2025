@extends('admin.layouts.app')

@section('style')
<style>
    .form-card {
        background: #fff;
        border-radius: 22px;
        padding: 30px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        max-width: 800px;
        margin: auto;
    }
    .form-label { font-weight: 600; }
    .form-control { background: #f5f5f5; }
    .is-invalid { border-color: #dc3545 !important; }
    .error-text { font-size: 12px; color: #dc3545; margin-top: 4px; }
</style>
@endsection

@section('content')

<div class="container mt-4">

    <h5>Create Subscription Plan</h5>

    <div class="form-card mt-3">
        <form id="planForm">
            @csrf

            {{-- Plan Name --}}
            <div class="mb-3">
                <label class="form-label">Plan Name</label>
                <input type="text" name="name" class="form-control">
                <div class="error-text name_error"></div>
            </div>

            {{-- Price --}}
            <div class="mb-3">
                <label class="form-label">Price (₹)</label>
                <input type="number" step="0.01" name="price" class="form-control">
                <div class="error-text price_error"></div>
            </div>

            {{-- Duration --}}
            <div class="mb-3">
                <label class="form-label">Duration (Days)</label>
                <input type="number" name="duration_days" class="form-control">
                <div class="error-text duration_days_error"></div>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
                <div class="error-text description_error"></div>
            </div>

            <button type="submit" class="btn btn-primary">
                Save Plan
            </button>
        </form>
    </div>

</div>

@endsection

@section('script')
<script>
$(document).ready(function () {

    $('#planForm').submit(function (e) {
        e.preventDefault();

        // Reset errors
        $('.error-text').text('');
        $('.form-control').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('admin.subscription.plans.store') }}",
            type: "POST",
            data: $(this).serialize(),

            success: function (res) {

                if (res.status === true) {

                    toastr.success(res.message);

                    $('#planForm')[0].reset();

                    setTimeout(function () {
                        window.location.href = "{{ route('admin.subscription.plans.index') }}";
                    }, 1200);

                } else {
                    toastr.error(res.message || 'Something went wrong');
                }
            },

            error: function (xhr) {

                if (xhr.status === 422) {

                    toastr.error('Please fix the errors below');

                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $('[name="'+key+'"]').addClass('is-invalid');
                        $('.'+key+'_error').text(value[0]);
                    });

                } else {
                    toastr.error('Server error, please try again');
                }
            }
        });
    });

});
</script>
@endsection
