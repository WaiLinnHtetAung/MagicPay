@extends('frontend.layouts.app')
@section('title', 'Notification')

@section('content')
    <div class="notification">
        @foreach ($notis as $noti)
            <div class="noti-card {{ $noti->read_at ? 'read' : '' }}">
                <a href="{{route('noti.show', [$noti->id])}}">
                    <h6 class="fw-bold ">{{$noti->data['title']}}</h6>
                    <p class=" mb-1 ">{{ $noti->data['message'] }}</p>
                    <small class="">{{ $noti->created_at->diffForHumans() }}</small>
                </a>
            </div>
        @endforeach
    </div>
@endsection
