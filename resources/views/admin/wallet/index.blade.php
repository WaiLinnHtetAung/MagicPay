@extends('admin.layouts.app')
@section('title', 'Wallets')


@section('content')
    <div class="admin-title">
        <i class='bx bxs-wallet'></i>
        <div>Wallet</div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="DataTable">
                <thead>
                    <th>Account Number</th>
                    <th class="no-sort">Account Person</th>
                    <th>Amount (MMK)</th>
                    <th>Created at</th>
                    <th>Updated at</th>
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
                ajax: '/admin/wallet/datatable/ssd',
                columns: [{
                        data: 'account_number',
                        name: 'account_number'
                    },
                    {
                        data: 'account_person',
                        name: 'account_person'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                ],
                columnDefs: [{
                    targets: 'no-sort',
                    sortable: false,
                }],
                order: [
                    [4, 'desc']
                ]
            });
        })
    </script>
@endsection
