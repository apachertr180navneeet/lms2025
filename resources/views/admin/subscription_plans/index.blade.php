@extends('admin.layouts.app')

@section('style')
<style>
    .table th {
        font-weight: 600;
        font-size: 13px;
        background: #f8f9fa;
    }
    .table td {
        font-size: 13px;
        vertical-align: middle;
    }

    .action-btns {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .action-btns .btn {
        font-size: 11px;
        padding: 5px 8px;
    }
</style>
@endsection

@section('content')

<div class="container-fluid flex-grow-1 container-p-y">

    {{-- PAGE HEADER --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h5>
                <span class="text-primary fw-light">Subscription</span> Plans
            </h5>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.subscription.plans.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Add Plan
            </a>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="planTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Duration (Days)</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
<script>
$(document).ready(function () {

    let table = $('#planTable').DataTable({
        processing: true,
        ajax: "{{ route('admin.subscription.plans.getall') }}",
        columns: [
            { data: 'name' },
            {
                data: 'price',
                render: data => '₹ ' + parseFloat(data).toFixed(2)
            },
            { data: 'duration_days' },
            {
                data: 'decscription',
                render: data => data ? data : '-'
            },
            {
                data: 'status',
                render: function (data, type, row) {
                    let checked = data == 1 ? 'checked' : '';
                    return `
                        <div class="form-check form-switch">
                            <input class="form-check-input toggleStatus"
                                type="checkbox"
                                data-id="${row.id}"
                                ${checked}>
                        </div>
                    `;
                }
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (id) {
                    return `
                        <div class="action-btns">
                            <a href="{{ url('admin/subscription-plans/edit') }}/${id}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <button class="btn btn-danger btn-sm"
                                onclick="deletePlan(${id})">
                                Delete
                            </button>
                        </div>
                    `;
                }
            }
        ]
    });

    // ================= STATUS TOGGLE =================
    $(document).on('change', '.toggleStatus', function () {

        let checkbox = $(this);
        let planId = checkbox.data('id');
        let status = checkbox.is(':checked') ? 1 : 0;

        checkbox.prop('disabled', true);

        $.ajax({
            url: "{{ route('admin.subscription.plans.status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: planId,
                status: status
            },
            success: function (res) {
                if (res.success) {
                    toastr.success('Plan status updated successfully');
                } else {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    toastr.error(res.message || 'Failed to update status');
                }
            },
            error: function () {
                checkbox.prop('checked', !checkbox.prop('checked'));
                toastr.error('Something went wrong');
            },
            complete: function () {
                checkbox.prop('disabled', false);
            }
        });
    });

});

// ================= DELETE =================
function deletePlan(id)
{
    if (!confirm('Are you sure you want to delete this plan?')) {
        return;
    }

    $.ajax({
        url: "{{ url('admin/subscription-plans/delete') }}/" + id,
        type: "DELETE",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function () {
            toastr.success('Subscription plan deleted successfully');
            $('#planTable').DataTable().ajax.reload();
        },
        error: function () {
            toastr.error('Failed to delete plan');
        }
    });
}
</script>
@endsection
