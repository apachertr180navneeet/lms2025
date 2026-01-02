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
    .form-control, .form-select { background: #f5f5f5; }
    .is-invalid { border-color: #dc3545 !important; }
    .error-text { font-size: 12px; color: #dc3545; margin-top: 4px; }
</style>
@endsection

@section('content')

<div class="container mt-4">

    <h5>Assign Subscription to Institute</h5>

    <div class="form-card mt-3">
        <form id="subscriptionForm">
            @csrf

            {{-- Institute --}}
            <div class="mb-3">
                <label class="form-label">Institute</label>
                <select name="institute_id" class="form-select">
                    <option value="">Select Institute</option>
                    @foreach($institutes as $institute)
                        <option value="{{ $institute->id }}">
                            {{ $institute->name }}
                        </option>
                    @endforeach
                </select>
                <div class="error-text institute_id_error"></div>
            </div>

            {{-- Subscription Plan --}}
            <div class="mb-3">
                <label class="form-label">Subscription Plan</label>
                <select name="subscription_plan_id" class="form-select">
                    <option value="">Select Plan</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}"
                            data-duration="{{ $plan->duration_days }}">
                            {{ $plan->name }} (₹{{ $plan->price }})
                        </option>
                    @endforeach
                </select>
                <div class="error-text subscription_plan_id_error"></div>
            </div>

            {{-- Start Date --}}
            <div class="mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control">
                <div class="error-text start_date_error"></div>
            </div>

            {{-- End Date --}}
            <div class="mb-3">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control">
                <div class="error-text end_date_error"></div>
            </div>

            {{-- Teacher Count --}}
            <div class="mb-3">
                <label class="form-label">Teacher Limit</label>
                <input type="number" name="teacher_count" class="form-control" min="0">
                <div class="error-text teacher_count_error"></div>
            </div>

            {{-- Student Count --}}
            <div class="mb-3">
                <label class="form-label">Student Limit</label>
                <input type="number" name="student_count" class="form-control" min="0">
                <div class="error-text student_count_error"></div>
            </div>

            <button type="submit" class="btn btn-primary">
                Save Subscription
            </button>
        </form>
    </div>

</div>

@endsection

@section('script')
<script>
$(document).ready(function () {

    // ================= AUTO END DATE =================
    $('select[name="subscription_plan_id"], input[name="start_date"]').on('change', function () {

        let plan = $('select[name="subscription_plan_id"] option:selected');
        let duration = plan.data('duration');
        let startDate = $('input[name="start_date"]').val();

        if (duration && startDate) {
            let date = new Date(startDate);
            date.setDate(date.getDate() + parseInt(duration));
            let endDate = date.toISOString().split('T')[0];
            $('input[name="end_date"]').val(endDate);
        }
    });

    // ================= FORM SUBMIT =================
    $('#subscriptionForm').submit(function (e) {
        e.preventDefault();

        $('.error-text').text('');
        $('.form-control, .form-select').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('admin.institute.subscriptions.store') }}",
            type: "POST",
            data: $(this).serialize(),

            success: function (res) {
                if (res.status === true) {
                    toastr.success(res.message);
                    setTimeout(() => {
                        window.location.href =
                            "{{ route('admin.institute.subscriptions.index') }}";
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
