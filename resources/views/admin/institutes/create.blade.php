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

    <h5>Create Institute</h5>

    <div class="form-card mt-3">
        <form id="instituteForm">
            @csrf

            <div class="mb-3">
                <label class="form-label">Institute Name</label>
                <input type="text" name="name" class="form-control">
                <div class="error-text name_error"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
                <div class="error-text email_error"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control">
                <div class="error-text phone_error"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control">
                <div class="error-text city_error"></div>
            </div>

            <button type="submit" class="btn btn-primary">
                Save Institute
            </button>
        </form>
    </div>

</div>

@endsection

@section('script')
<script>
$(document).ready(function () {

    $('#instituteForm').submit(function (e) {
        e.preventDefault();

        // Reset errors
        $('.error-text').text('');
        $('.form-control').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('admin.institutes.store') }}",
            type: "POST",
            data: $(this).serialize(),

            success: function (res) {

                // ✅ IMPORTANT: check `status` (not `success`)
                if (res.status === true) {

                    toastr.success(res.message);

                    $('#instituteForm')[0].reset();

                    setTimeout(function () {
                        window.location.href = "{{ route('admin.institutes.index') }}";
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
