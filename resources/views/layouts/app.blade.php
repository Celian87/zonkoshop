<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'ZonkoShop'))</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stile.min.css') }}" rel="stylesheet">


    @yield('page-css')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">

                    <div class="col-md-3">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!--{{ config('app.name', 'ZonkoShop') }}-->
                    <img src={{ asset('images/zonkologo.png') }} style="width: 75%;">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                    </div>






                    <div class="col-md-4">
                        <div class="box_search" style="float: left; width: 100%;">
                        <form action="{{ action('StoreController@search') }}" method="get" style="/*display: inline-flex;*/">
                            <input type="text" name="prodotto" id="search" class="form-control" placeholder="Cerca">
                            <span class="fa fa-search" width="25" height="25" id="active_search"></span>
                        </form>
                    </div>
                    </div>








                    <div class="col-md-5">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if(Auth::check() && Auth::user()->isAdmin())
                        <span class="badge badge-success">MASTER</span>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @if ( !Auth::check() || !Auth::user()->isAdmin() )
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('CartPage') }}">
                                    @if (App\Cart::all()->count() > 0)
                                    <i class="fas fa-cart-arrow-down"></i>
                                    @else
                                    <i class="fas fa-shopping-cart"></i>
                                    @endif
                                </a>
                            </li>
                        @endif
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Accedi</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registrati</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="background-color: #ffdcdc">
                                    @if(Auth::user()->isAdmin())
                                        <a class="dropdown-item" href="{{ action('StoreController@dashboard') }}">
                                            DASHBOARD MASTER
                                        </a>
                                        <a class="dropdown-item" href="{{ action('StoreController@admindisabled') }}">
                                            PRODOTTI DISATTIVATI
                                        </a>
                                        <a class="dropdown-item" href="{{ action('StoreController@showRefill') }}">
                                            RIFORNIMENTO
                                        </a>
                                    @else
                                        <p class="dropdown-item disabled">
                                            <span id="user-money">@currency(Auth::user()->money)</span>
                                            <span><i class="fas fa-coins"></i></span>
                                        </p>
                                        <a class="dropdown-item" href="{{ route('CartPage') }}">
                                            <span>Il mio carrello</span>
                                        </a>
                                        <a class="dropdown-item" href="{{ route('OrdersPage') }}">
                                            I miei Ordini
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>

            </div>

            {{-- Barra categorie --}}
            <div class="container">
            <div class="row" style="padding-top: 10px">


            @php
                $categories = App\Category::orderBy('name')->get();
            @endphp
            @foreach ($categories as $category)
                <span class="col-md-3">
                    <a class="btn" href="{{ route("CategoryPage",$category->id) }}">{{ $category->name }}</a>
                </span>
            @endforeach

            </div>
            </div>




        </nav>



        <main class="py-4">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="content" style="margin-top: 15px; margin-bottom: 30px;">
                <!-- Alert bar for errors -->
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <h4 class="alert-heading">Si sono verificati alcuni errori</h4>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li><b>{{ $error }}</b></li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src={{ asset('js/zonkoshop.js') }}></script>
    @yield('page-javascript')

    <footer>
        <div class="container">
            <p>Copyright © 2019 AniOn S.R.L.  -  Tutti i diritti riservati</p>
        </div>
    </footer>


</body>
</html>
