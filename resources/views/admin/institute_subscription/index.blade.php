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
                <span class="text-primary fw-light">Institute</span> Subscriptions
            </h5>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.institute.subscriptions.create') }}"
               class="btn btn-primary">
                <i class="bx bx-plus"></i> Assign Subscription
            </a>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="subscriptionTable">
                    <thead>
                        <tr>
                            <th>Institute</th>
                            <th>Plan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Teacher Limit</th>
                            <th>Student Limit</th>
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

    $('#subscriptionTable').DataTable({
        processing: true,
        ajax: "{{ route('admin.institute.subscriptions.getall') }}",
        columns: [
            { data: 'institute_name' },
            { data: 'plan_name' },
            {
                data: 'start_date',
                render: data => moment(data).format('DD-MM-YYYY')
            },
            {
                data: 'end_date',
                render: data => moment(data).format('DD-MM-YYYY')
            },
            { data: 'teacher_count' },
            { data: 'student_count' },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (id) {
                    return `
                        <div class="action-btns">
                            <a href="{{ url('admin/institute-subscriptions/edit') }}/${id}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <button class="btn btn-danger btn-sm"
                                onclick="deleteSubscription(${id})">
                                Delete
                            </button>
                        </div>
                    `;
                }
            }
        ]
    });

});

// ================= DELETE =================
function deleteSubscription(id)
{
    if (!confirm('Are you sure you want to delete this subscription?')) {
        return;
    }

    $.ajax({
        url: "{{ url('admin/institute-subscriptions/delete') }}/" + id,
        type: "DELETE",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function () {
            toastr.success('Institute subscription deleted successfully');
            $('#subscriptionTable').DataTable().ajax.reload();
        },
        error: function () {
            toastr.error('Failed to delete subscription');
        }
    });
}
</script>
@endsection
