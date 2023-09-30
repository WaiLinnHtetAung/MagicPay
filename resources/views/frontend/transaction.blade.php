@extends('frontend.layouts.app');
@section('title', 'Transaction');

@section('content')
    <div class="transaction px-2" >
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex align-items-center gap-2 mb-2"><i class="fa-solid fa-filter fs-5"></i> <span class="fs-6">Filter</span></div>
                <div class="row">
                    <div class="col-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label for="" class="input-group-text">Date</label>
                            </div>
                            <input class="form-control" placeholder="YY-M-D" autocomplete="off" type="text" id="date" name="datetimes" value="{{request()->date ?? ''}}" />
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label for="" class="input-group-text">Type</label>
                            </div>
                            <select name="" id="" class="form-select type">
                                <option value="">All</option>
                                <option value="1" {{request()->type == 1 ? 'selected' : ''}}>Income</option>
                                <option value="2" {{request()->type == 2 ? 'selected' : ''}}>Expense</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ps-2 my-2 fs-6">Transactions</div>
        @foreach ($transactions as $transaction)
            <a href="{{ url('/transaction/' . $transaction->trx_id) }}">
                <div class="card mb-3 shadow">
                    <div class="card-body pe-0">
                        <div class="d-flex justify-content-between pe-3">
                            <h5 class="mb-3" style="font-size: 18px; font-weight: bold;">Trx Id :
                                {{ $transaction->trx_id }}</h5>
                            <p class="mb-0">
                                <span
                                    class="{{ $transaction->type == 1 ? 'text-success' : 'text-danger' }}">{{ $transaction->amount }}
                                    MMK</span>
                            </p>
                        </div>
                        <p class="mb-1">
                            @if ($transaction->type == 1)
                                From
                            @elseif($transaction->type == 2)
                                To
                            @endif
                            {{ $transaction->source ? ucfirst($transaction->source->name) : '' }}
                        </p>
                        <p class="mb-1">{{ date_format($transaction->created_at, 'd-m-Y H:s:i') }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('change', '.type', function() {
                let date = $('input[name="datetimes"]').val();
                let type = $('.type').val();

                history.pushState(null, '', `?date=${date}&type=${type}`);
                window.location.reload();
            })

            $(function () {
                let date = document.querySelector('#date');
                if(date) {
                    date.flatpickr({
                        dateFormat: "Y-m-d",
                    })
                }
            })

            $('#date').on('change', function() {
                let date = $('#date').val();
                let type = $('.type').val();

                history.pushState(null, '', `?date=${date}&type=${type}`);
                window.location.reload();
            })
        })
    </script>
@endsection
