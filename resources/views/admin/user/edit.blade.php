@extends('admin.layouts.app')
@section('title', 'Edit User')

@section('content')
    <div class="admin-title">
        <i class='bx bxs-user-check'></i>
        <div>Edit Users</div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" class="mt-3" id="edit">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password" disabled>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <button class="btn btn-secondary me-2 back-btn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateUser', '#edit') !!}

    <script>
        $(document).ready(function() {

        })
    </script>
@endsection
