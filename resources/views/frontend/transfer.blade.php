@extends('frontend.layouts.app');
@section('title', 'Transfer');

@section('content')
    <div class="transfer">
        <form action="{{url('transfer/confirm')}}" method="POST" id="transfer_form" autocomplete="off">
            @csrf

            <div class="card m-3 shadow">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for=""><b>From</b></label>
                        <p class="mb-1 text-muted">{{auth()->user()->name}}</p>
                        <p class="mb-1 text-muted">{{auth()->user()->phone}}</p>
                    </div>

                    <div class="form-group mb-3">
                        <label for=""><b>To</b> <span class="account_name "></span></label>
                        <div class="input-group">
                            <input type="text" class="form-control to_phone" name="to_phone" value="{{old('to_phone', $receive_phone ?? '')}}">
                            <div class="input-group-append pointer check_account">
                                <span class="input-group-text h-100"><i class="fa-solid fa-circle-check"></i></span>
                              </div>

                        </div>
                        @error('to_phone')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for=""><b>Amount (MMK)</b></label>
                        <input type="number" class="form-control" name="amount" value="{{old('amount')}}">
                        @error('amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for=""><b>Description</b></label>
                        <textarea name="description" id="" cols="30" rows="3" class="form-control">{{old('description')}}</textarea>
                    </div>

                    <button type="submit" class="btn btn-theme w-100 mt-3">Continue</button>
                </div>
            </div>
        </form>

    </div>
@endsection

@section('scripts')
    <script>
            $(document).ready(function() {
                $(document).on('click', '.check_account', function() {
                    $phone_number = $('.to_phone').val();

                    $.ajax({
                        url: "/to-account-verify?phone="+$phone_number,
                        type: 'GET',
                        success: function(res) {
                            if(res.status) {
                                $('.account_name').removeClass('text-danger').addClass('text-success').html('('+res.data.name+')');
                            } else {
                                $('.account_name').addClass('text-danger').html('('+res.message+')')
                            }
                        }
                    })
                })
            })
    </script>
@endsection
