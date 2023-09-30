@extends('frontend.layouts.app');
@section('title', 'Wallet');

@section('content')
    <div class="wallet">
        <div class="card mt-3 mb-3 shadow">
            <div class="card-body pe-0">
                <div class="mb-3">
                    <span>Balance</span>
                    <h3>{{auth()->user()->wallet ? number_format(auth()->user()->wallet->amount, 2) : '0'}} <span style="margin-bottom: -3px;">MMK</span></h3>
                </div>
                <div class="mb-3">
                    <span>Account Number</span>
                    <h4>{{auth()->user()->wallet ? auth()->user()->wallet->account_number : ''}}</h4>
                </div>
                <div>
                    <p>{{auth()->user()->name}}</p>
                </div>
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
