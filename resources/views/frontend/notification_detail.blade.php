@extends('frontend.layouts.app')
@section('title', 'Notification')

@section('content')
    <div class="notification">
        <div class="card">
            <div class="card-body py-5 d-flex flex-column justify-content-center align-items-center">
                <div class="img mb-5">
                    <img src="{{asset('images/noti.png')}}" alt="">
                </div>
                <h4 class="text-center">{{ $notification->data['title'] }}</h4>
                <p class="text-muted mb-1 text-center">{{ $notification->data['message'] }}</p>
                <small class="mb-1">{{ $notification->created_at->diffForHumans() }}</small>
                <a href="{{$notification->data['web_link']}}">Continue</a>
            </div>
        </div>
    </div>
@endsection
