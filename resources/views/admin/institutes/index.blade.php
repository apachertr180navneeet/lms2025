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
                <span class="text-primary fw-light">Institute</span> Management
            </h5>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.institutes.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Add Institute
            </a>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="instituteTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
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

        let table = $('#instituteTable').DataTable({
            processing: true,
            ajax: "{{ route('admin.institutes.getall') }}",
            columns: [
                { data: 'name' },
                { data: 'email' },
                { data: 'phone' },
                { data: 'city' },
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
                                <a href="{{ url('admin/institutes/edit') }}/${id}"
                                class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <button class="btn btn-danger btn-sm"
                                    onclick="deleteInstitute(${id})">
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
            let instituteId = checkbox.data('id');
            let status = checkbox.is(':checked') ? 1 : 0;

            checkbox.prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.institutes.status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: instituteId,
                    status: status
                },
                success: function (res) {
                    if (res.success) {
                        toastr.success('Institute status updated successfully');
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
    function deleteInstitute(id)
    {
        if (!confirm('Are you sure you want to delete this institute?')) {
            return;
        }

        $.ajax({
            url: "{{ url('admin/institutes/delete') }}/" + id,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (res) {
                toastr.success('Institute deleted successfully');
                $('#instituteTable').DataTable().ajax.reload();
            },
            error: function () {
                toastr.error('Failed to delete institute');
            }
        });
    }
</script>
@endsection

