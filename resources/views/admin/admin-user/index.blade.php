@extends('admin.layouts.app')
@section('title', 'Admin User')


@section('content')
    <div class="admin-title">
        <i class='bx bxs-user-rectangle' ></i>
        <div>Admin Users</div>
    </div>

    <div class="card">
        <div class="d-flex justify-content-end m-3">
            <a href="{{ route('admin.admin-users.create') }}" class="btn btn-primary text-decoration-none text-white"><i class='bx bxs-plus-circle me-2'></i> Create New User</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="DataTable">
                <thead>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>IP</th>
                    <th class="no-sort">User Agent</th>
                    <th>Updated Time</th>
                    <th class="no-sort">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const table = new DataTable('#DataTable', {
                            processing: true,
                            serverSide: true,
                            ajax: '/admin/admin-users/datatable/ssd',
                            columns: [
                                {
                                    data: 'name',
                                    name: 'name'
                                },
                                {
                                    data: 'email',
                                    name: 'email'
                                },
                                {
                                    data: 'phone',
                                    name: 'phone'
                                },
                                {
                                    data: 'ip',
                                    name: 'ip'
                                },
                                {
                                    data: 'user_agent',
                                    name: 'user_agnet',
                                },
                                {
                                    data: 'updated_at',
                                    name: 'updated_at'
                                },
                                {
                                    data: 'action',
                                    name: 'action'
                                }
                            ],
                            columnDefs: [{
                                targets: 'no-sort',
                                sortable: false,
                            }],
                            order: [
                                [5, 'desc']
                            ]
                        });

            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure to delete ?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    denyButtonText: `Don't save`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/admin-users/"+id,
                            type: "DELETE",
                            success: function() {
                                table.ajax.reload();
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection
