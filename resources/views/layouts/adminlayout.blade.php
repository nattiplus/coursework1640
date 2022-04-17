<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accusoft admin</title>
    <link href="{{URL::asset('css/custom_style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    {{-- Modal Bootstrap --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <a href="{{URL::to('/admin')}}">
                <h2><span class="lab la-accusoft"></span>
                    <span> Accusoft</span>
                </h2>
            </a>
        </div>

        <div class="sidebar-menu">
            @yield('sidebar-menu')
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>

<!--                 Dashboard -->
            </h2>

            {{-- <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Seach here">
            </div> --}}

            <div class="user-wrapper">
                <nav>
                    <ul>
                        <li>
                            <a href="#"><span class="las la-user"></span> {{ Auth::user()->name }}</a>
                            <ul>
                                <li><a href="{{ route('home') }}"><i class="las la-undo-alt"></i> User HomePage</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="las la-sign-out-alt"></i>
                                         {{ __('Logout') }}
                                     </a>

                                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                         @csrf
                                     </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- <a href="#"><img src="img/2.png" width="40px" height="40px" alt="" class="img-dropdown"></a> -->
                <!-- <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn">
                        <span><a href="#"><img src="img/2.png" width="40px" height="40px" alt="" class="logo"></a> </span>
                    </button>
                    <div id="myDropdown" class="dropdown-content">
                      <a href="#"><i class="las la-undo-alt"></i> HomePage</a>
                      <a href="#"><i class="las la-undo-alt"></i> Logout</a>
                    </div>
                  </div> -->
                <!-- <div>
                    <h4>Naruto H</h4>
                    <small>Super admin</small>
                </div> -->
            </div>
        </header>

        <main>
            @yield('AdminContent')
        </main>
    </div>
    <script src="main.js"></script>
        <!-- Bootstrap core JavaScript-->
    <script src="{{URL::asset('vendor/jquery/jquery.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{URL::asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{URL::asset('vendor/chart.js/Chart.js')}}"></script>

    <!-- Loader Animation -->
    {{-- <script type="text/javascript">
        window.addEventListener("load", function(){
          const loader = document.querySelector(".loader");
          loader.className += " hidden"; // class "loader hidden"
        });
    </script> --}}

    <!-- CRUD Message Time Out -->
    <script type="text/javascript">
        $("document").ready(function() {
            setTimeout(function() {
                $("div.alert").remove();
            },3000);
        });
    </script>

    @yield('JS')
</body>
</html>