<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{URL::asset('font/css/all.css')}}">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ URL::asset('css/style.css'); }}">
        {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Jquery Lib -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
        <body class="antialiased">
            <div class="loader">
              <img src="https://s13.favim.com/orig/170530/gif-world-Favim.com-5195898.gif" alt="Loading...">
            </div>
            <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                  <div class="container-fluid">
                    <a class="navbar-brand" href="{{URL::to('/')}}">
                        <img src="https://i.pinimg.com/originals/0c/3b/3a/0c3b3adb1a7530892e55ef36d3be6cb8.png" width="40" height="40">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->can('admin.home'))
                                <li><a class="dropdown-item" href="{{ route('admin.home') }}">Management</a></li>                                  
                                @endif
                                <li><a class="dropdown-item" href="{{ route('submission.idea') }}">Contribute Idea</a></li>
                                <li><a class="dropdown-item" href="{{URL::to('/ideas')}}">View All Idea</a></li>
                                <li class="border-top border-2">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                              </ul>
                            </li>
                        @endguest
                      </ul>
                      {{-- <form class="d-flex">
                        <input class="form-control me-2 border border-info" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-info text-dark" type="submit">Search</button>
                      </form> --}}
                    </div>
                  </div>
                </nav>
            </header>

            <section>
                @yield('content')   
            </section>
            
            <footer>
                <div class="bg-dark text-secondary px-4 py-5 text-center mt-5">
                    <div class="py-5">
                      <h4 class="display-5 fw-bold text-white">EVERY INDIVIDUAL IN THE WORLD HAS A UNIQUE CONTRIBUTION</h4>
                      <div class="col-lg-6 mx-auto">
                        <p class="fs-5 mb-4">"There is no doubt that creativity is the most important human resource of all. Without creativity, there would be no progress, and we would be forever repeating the same patterns."</p>

                      </div> 
                    </div>
                  </div>

            </footer>
            <script type="text/javascript">
              window.addEventListener("load", function(){
                const loader = document.querySelector(".loader");
                loader.className += " hidden"; // class "loader hidden"
              });
            </script>

        </body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="{{asset('ckeditor/ckeditor.js')}}"></script>

    <script>
        CKEDITOR.replace('ckeditor');
        CKEDITOR.replace('ckeditor1');
        CKEDITOR.replace('ckeditor2');
    </script>

    @yield('JS')
</html>