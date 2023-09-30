@extends('frontend.layouts.app');
@section('title', 'Transaction Detail');

@section('content')
    <div class="transaction_detail px-2">
        <div class="card mb-3 shadow">
            <div class="card-body">
                <div class="text-center">
                    <img class="mb-4" src="{{$transaction->type == 1 ? asset('images/receive.png') : asset('images/send.png')}}" alt="">
                </div>
                <h5 class="text-center {{$transaction->type ==1 ? 'text-success' : 'text-danger'}}">{{$transaction->amount}} MMK</h5>
                <div class="d-flex justify-content-between mt-5 px-2">
                    <p class="mb-0 text-muted">Trx ID</p>
                    <p class="mb-0">{{$transaction->trx_id}}</p>
                </div>
                <hr>

                <div class="d-flex justify-content-between px-2">
                    <p class="mb-0 text-muted">Reference Number</p>
                    <p class="mb-0">{{$transaction->ref_no}}</p>
                </div>
                <hr>

                <div class="d-flex justify-content-between px-2">
                    <p class="mb-0 text-muted">Type</p>
                    <p class="mb-0 badge rounded-pill pt-1  {{$transaction->type == 1 ? 'bg-success' : 'bg-danger'}}">{{$transaction->type == 1 ? 'Income' : 'Expense'}}</p>
                </div>
                <hr>

                <div class="d-flex justify-content-between px-2">
                    <p class="mb-0 text-muted">Amount</p>
                    <p class="mb-0">{{number_format($transaction->amount)}} MMK</p>
                </div>
                <hr>

                <div class="d-flex justify-content-between px-2">
                    <p class="mb-0 text-muted">Date & Time</p>
                    <p class="mb-0">{{date_format($transaction->created_at, 'd-m-Y H:s:i')}}</p>
                </div>
                <hr>

                <div class="d-flex justify-content-between px-2">
                    <p class="mb-0 text-muted">{{$transaction->type == 1 ? 'From' : 'To'}}</p>
                    <p class="mb-0">{{$transaction->source ? $transaction->source->name : ''}}</p>
                </div>
                <hr>

                <div class="d-flex justify-content-between px-2">
                    <p class="mb-0 text-muted">Description</p>
                    <p class="mb-0">{{$transaction->description ?? ''}}</p>
                </div>
                <hr>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
            $(document).ready(function() {

            })
    </script>
@endsection
