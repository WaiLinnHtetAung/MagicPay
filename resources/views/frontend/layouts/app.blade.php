<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- ajax token  --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- date picker  --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">

        @yield('styles')
    </head>
    <body class="py-4">

        <div class="header ">
            <div class="row justify-content-center header-bar">
                <div class="col-md-8">
                    <div class="row text-center px-2">
                        <div class="col-2 back-btn pointer">
                            @if (!request()->is('/'))
                                <i class="fa-solid fa-chevron-left"></i>
                            @endif
                        </div>
                        <div class="col-8">
                            <h2>@yield('title')</h2>
                        </div>
                        <div class="col-2 noti-icon">
                            <a href="/notification" class="position-relative">
                                <i class="fa-solid fa-bell"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                  {{$noti_count}}
                                </span>
                              </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @yield('content')
                </div>
            </div>
        </div>

        <div class="footer">
            <a href="{{ route('scan') }}" class="scan-tab">
                <div class="inside">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
            </a>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row text-center">
                        <div class="col-3">
                            <a href="{{route('home')}}">
                                <i class="fa-solid fa-house"></i>
                                <p>Home</p>
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="{{route('wallet')}}">
                                <i class="fa-solid fa-wallet"></i>
                                <p>Wallet</p>
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="{{route('transaction')}}">
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                <p>Transaction</p>
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="{{route('profile')}}">
                                <i class="fa-solid fa-user"></i>
                                <p>Profile</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    {{-- sweetalert 2  --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- laravel jsvalidation  --}}
    <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    {{-- date picker  --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <script>
        $(document).ready(function() {

            let token = $('meta[name="csrf-token"]').attr('content')
            if(token) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN' : token,
                    }
                });
            }

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{session('success')}}"
                })
            @endif

            @if(session('fail'))
                Toast.fire({
                    icon: 'error',
                    title: "{{session('fail')}}"
                })
            @endif

            $('.back-btn').on('click', function() {
                window.history.go(-1);
            })
        })
    </script>

    @yield('scripts')
</html>
