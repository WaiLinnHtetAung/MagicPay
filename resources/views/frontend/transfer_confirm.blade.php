@extends('frontend.layouts.app');
@section('title', 'Transfer Confirmation');

@section('content')
    <div class="transfer_confirmation">
        <form action="{{url('transfer/complete')}}" method="POST" id="form">
            @csrf

            <input type="hidden" name="to_phone" value="{{$transfer_data->to_phone}}">
            <input type="hidden" name="to_user" value="{{$to_user->name}}">
            <input type="hidden" name="amount" value="{{$transfer_data->amount}}">
            <input type="hidden" name="description" value="{{$transfer_data->description}}">

            <div class="card m-3 shadow">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for=""><b>From</b></label>
                        <p class="mb-1 text-muted">{{auth()->user()->name}}</p>
                        <p class="mb-1 text-muted">{{auth()->user()->phone}}</p>
                    </div>

                    <div class="form-group mb-3">
                        <label for=""><b>To</b></label>
                        <p class="mb-1 text-muted">{{$to_user->name}}</p>
                        <p class="mb-1 text-muted">{{$transfer_data->to_phone}}</p>
                    </div>

                    <div class="form-group mb-3">
                        <label for=""><b>Amount (MMK)</b></label>
                        <p class="mb-1 text-muted">{{$transfer_data->amount}}</p>
                    </div>

                    <div class="form-group mb-3">
                        <label for=""><b>Description</b></label>
                        <p class="mb-1 text-muted">{{$transfer_data->description}}</p>
                    </div>

                    <button type="submit" class="btn btn-theme w-100 mt-3 confirm_btn">Confirm</button>
                </div>
            </div>
        </form>

    </div>
@endsection

@section('scripts')
    <script>
            $(document).ready(function() {
                $(document).on('click', '.confirm_btn', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Enter Your Password',
                        icon: 'info',
                        html: '<input type="password" class="form-control password text-center" autocomplete="off"/>',
                        showCancelButton: true,
                        focusConfirm: false,
                        confirmButtonText: 'Confirm',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if(result.isConfirmed) {
                            const password = $('.password').val();

                            $.ajax({
                                url: '/password/check?password='+password,
                                success: function(res) {
                                    if(res.status) {
                                        $('#form').submit();
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops....',
                                            text: res.message,
                                        })
                                    }
                                }
                            })
                        }
                    })
                })
            })
    </script>
@endsection
