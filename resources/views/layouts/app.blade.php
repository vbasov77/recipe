<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        @isset($title)
            {{ $title }} |
        @endisset
        {{ config('app.name') }}
    </title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{--    Styles--}}
    <link href="https://fonts.googleapis.com/css?family=Oswald:400,700|Work+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('themes/funder/fonts/icomoon/style.css')}}">
    <link rel="stylesheet" href="{{asset('themes/funder/css/style.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>


</head>

<body>
<div class="site-wrap">
    <div class="site-mobile-menu">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->

    <div class="site-navbar-wrap js-site-navbar bg-white">
        <div class="container">
            <div class="site-navbar bg-light">
                <div class="row align-items-center">
                    <div class="col-2">
                        <h2 class="mb-0 site-logo"><a style="text-decoration: none;" href="{{route('front')}}"
                                                      class="font-weight-bold">RECIPE</a>
                        </h2>
                    </div>
                    <div class="col-10">
                        <nav class="site-navigation text-right" role="navigation">
                            <div class="container">
                                <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#"
                                                                                              class="site-menu-toggle js-menu-toggle text-black"><span
                                                class="icon-menu h3"></span></a></div>
                                <ul class="site-menu js-clone-nav d-none d-lg-block">
                                    @guest
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        </li>
                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        <li class="has-children">
                                            <a href="#">{{ Auth::user()->name }}</a>
                                            <ul class="dropdown arrow-top">
                                                @include('blocks.admin_menu')
                                            </ul>

                                        </li>
                                    @endguest
                                    <li>
                                        {{--                                        <a href="{{route('articles')}}">Заметки</a>--}}
                                        {{--                                        @include('blocks.tools')--}}
                                    </li>
                                    <li class="active"><a href="{{route('front')}}">{{__('Главная')}}</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <main class="py-4">
        @yield('content')
    </main>
</div>


<section>
    <footer style="padding: 35px; " class="footer bg-black small text-center">
        <div style="color: white" class="container px-4 px-lg-5">{{config('app.name')}} &copy; {{date('Y')}}</div>
    </footer>
</section>

<script src="{{asset('themes/funder/js/aos.js')}}"></script>
<script src="{{asset('themes/funder/js/main.js')}}"></script>
@stack('scripts')

</body>
</html>
