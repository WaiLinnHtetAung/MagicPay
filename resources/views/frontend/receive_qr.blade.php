@extends('frontend.layouts.app');
@section('title', 'Receive QR');

@section('content')
    <div class="receive-qr p-3">
        <div class="card mt-3 mb-3 shadow">
            <div class="card-body">
                <h6>Scan to pay me</h6>
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(256)->merge(public_path('images/logo.png'), 0.3, true)->generate(auth()->user()->phone)) !!} ">
                <h5>{{ auth()->user()->name }}</h5>
                <div class="fw-bold">{{ auth()->user()->phone }}</div>
                <a class="text-primary" href="{{ route('download.qr') }}">Download QR</a>
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
