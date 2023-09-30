@extends('frontend.layouts.app');
@section('title', 'Update Password');

@section('styles')
    <style>

        .account img {
            width: 300px;
        }
    </style>
@endsection

@section('content')
    <div class="account">
        <div class="card mt-3 mb-3 shadow">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{asset('images/pwchange.png')}}" alt="">
                </div>
                <form action="{{route('update.password.store')}}" method="POST" id="updatePassword">
                    @csrf

                    <div class="row py-4">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group mb-3">
                                <label for="">Old Password</label>
                                <input type="password" name="old_password" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group mb-3">
                                <label for="">New Password</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-block w-100" style=" background:#5842e3;color: #fff;">Update Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Frontend\UpdatePassword', '#updatePassword') !!}
    <script>

    </script>
@endsection


