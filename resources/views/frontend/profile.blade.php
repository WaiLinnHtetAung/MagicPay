@extends('frontend.layouts.app');
@section('title', 'Profile');

@section('content')
    <div class="account">
        <div class="profile">
            <img src="https://ui-avatars.com/api/?background=5842e3&color=fff&name={{auth()->user()->name}}" alt="">
        </div>

        <div class="card mt-3 mb-3 shadow">
            <div class="card-body pe-0">
                <div class="d-flex justify-content-between">
                    <span>Name</span>
                    <span class="me-3">{{ auth()->user()->name }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Email</span>
                    <span class="me-3">{{ auth()->user()->email }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Phone</span>
                    <span class="me-3">{{ auth()->user()->phone }}</span>
                </div>
            </div>
        </div>

        <div class="card mb-3 shadow">
            <div class="card-body pe-0">
                <div class="d-flex justify-content-between action-btn pointer" onclick="location.href='{{route('update.password')}}'">
                    <span>Update Password</span>
                    <span class="me-3"><i class="fa-solid fa-circle-chevron-right"></i></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between action-btn pointer logout">
                    <span>Logout</span>
                    <span class="me-3"><i class="fa-solid fa-circle-chevron-right"></i></span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
            $(document).ready(function() {
                $(document).on('click', '.logout', function() {
                    Swal.fire({
                        title: 'Are you sure to logout ?',
                        showCancelButton: true,
                        confirmButtonText: 'Confirm',
                        denyButtonText: `Don't save`,
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{route('user.logout')}}",
                                success: function() {
                                    window.location.replace("{{route('profile')}}");
                                }
                            })
                        }
                    })
                })
            })
    </script>
@endsection
