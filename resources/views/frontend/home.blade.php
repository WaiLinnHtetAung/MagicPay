@extends('frontend.layouts.app')
@section('title', 'Magic Pay')

@section('content')
    <div class="home">
        <div class="row mt-4 m-2">
            <div class="col-12">
                <div class="profile mb-2">
                    <img src="https://ui-avatars.com/api/?background=5842e3&color=fff&name={{auth()->user()->name}}" alt="">
                    <h6>{{ucfirst(auth()->user()->name)}}</h6>
                    <p class="text-muted">{{ auth()->user()->wallet ? number_format(auth()->user()->wallet->amount) : '' }} MMK</p>
                </div>
            </div>
        </div>

        <div class="row mx-3 mb-3">
            <div class="col-6 p-0 pe-1">
                <div class="card pointer" onclick="location.href='{{route('scan')}}'">
                    <div class="card-body">
                        <img src="{{asset('images/scan.png')}}" alt="">
                        <span>Scan & Pay</span>
                    </div>
                </div>
            </div>
            <div class="col-6 p-0 ps-1">
                <div class="card pointer" onclick="location.href='{{route('qr')}}'">
                    <div class="card-body">
                        <img src="{{asset('images/qr.png')}}" alt="">
                        <span>Receive QR</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mx-3">
            <div class="card-body pe-0">
                <div class="d-flex justify-content-between action-btn pointer" onclick="location.href='{{route('transfer')}}'">
                    <span><img class="me-3" src="{{asset('images/transfer.png')}}" alt="">Transfer</span>
                    <span class="me-3"><i class="fa-solid fa-chevron-right"></i></i></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between action-btn pointer logout" onclick="location.href='{{route('wallet')}}'">
                    <span><img class="me-3" src="{{asset('images/wallet.png')}}" alt="">Wallet</span>
                    <span class="me-3"><i class="fa-solid fa-chevron-right"></i></i></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between action-btn pointer logout" onclick="location.href='{{route('transaction')}}'">
                    <span><img class="me-3" src="{{asset('images/transaction.png')}}" alt="">Transaction</span>
                    <span class="me-3"><i class="fa-solid fa-chevron-right"></i></i></span>
                </div>
            </div>
        </div>
    </div>
@endsection
