@extends('admin.layouts.app')
@section('title', 'Create User')

@section('content')
    <div class="admin-title">
        <i class='bx bxs-user-plus' ></i>
        <div>Create Users</div>
    </div>

    <div class="card">
        <div class="card-body">

            @if (session('fail'))
                <div class="alert alert-danger alert-dismissible fade show my-3 mb-5" role="alert">
                    {{session('fail')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST" class="mt-3" id="create">
                @csrf

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" class="form-control" name="phone">
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreUsers', '#create') !!}

    <script>
        $(document).ready(function() {

        })
    </script>
@endsection
