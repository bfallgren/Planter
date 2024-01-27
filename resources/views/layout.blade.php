<!DOCTYPE html>
<html>

    <head>
        <title>PlantScape</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Scripts -->
        <!--<script src="{{ asset('js/app.js') }}" defer></script> --> 

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> 

        <!-- using font-awesome (free/solid) icons -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/solid.css" integrity="sha384-r/k8YTFqmlOaqRkZuSiE9trsrDXkh07mRaoGBMoDcmA58OHILZPsk29i2BsFng1B" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/fontawesome.css" integrity="sha384-4aon80D8rXCGx9ayDt85LbyUHeMWd3UiBaWliBlJ53yzm9hqN21A+o1pqoyK04h+" crossorigin="anonymous">

        <!-- Styles -->
        <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet" /> -->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

        <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

        <!-- added for datatable export -->
    
        <script src= "https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"> </script>
        <script src= "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
        <script src= "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> </script>
        <script src= "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"> </script>
        <script src= "https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"> </script>
        <script src= "https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"> </script>

        <!-- SweetAlert -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
        @yield('style')
        <style>
            .dropdown-toggle::after {
                 float: right;
                 margin-right: -10px;
                 margin-top: -15px;
            }
        </style>
    </head>
    <body>
  
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-green shadow-sm">
                <div class="container">
                    <a class="navbar-brand" style="color:green" href="{{ url('/home') }}">
                        
                    {{ env('APP_NAME') }} <i class="fas fa-leaf"></i>
                    </a>    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        @guest
                             <!-- not authenticated -->
                        @else
                            <a class="dropdown-item" href="{{URL::route('areas')}}" title="Start Here" style="position:relative;top:3px;color:green">Areas</a>    
                        @endguest
                            <!-- Right Side Of Navbar -->
                        @guest
                            <ul class="navbar-nav ml-auto" >
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            </ul>
                        @else
                        <ul class="navbar-nav ml-auto" >
                           
                           <ul class="navbar-nav mr-auto" >      
                               <a class="dropdown-item" href="{{URL::route('events')}}" style="position:relative;top:3px;color:green">Events </a>
                               <a class="dropdown-item" href="{{URL::route('tasks')}}" style="position:relative;top:3px;color:green">Tasks</a>
                               <a class="dropdown-item" href="{{URL::route('links')}}" title="Helpful Websites" style="position:relative;top:3px;color:green">Links</a>             
                           </ul>
                           <li class="dropdown">
                               <a id="navbarDropdown" class="btn dropdown-toggle" href="#" style="position:relative; top:0px; right:-10px; color:green" 
                               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> Help
                               </a>
                               <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                   <button class="dropdown-item btn btn-warning btn-sm" id="myBtn" data-toggle="modal" 
                                   data-target="#about">About</button>
                                   <button class="dropdown-item btn btn-warning btn-sm" id="buildBtn" data-toggle="modal" 
                                   data-target="#build">Build Info</button>
                                   <button class="dropdown-item btn btn-warning btn-sm" id="creditBtn" data-toggle="modal" 
                                   data-target="#credits">Credits</button>
                                   <button class="dropdown-item btn btn-warning btn-sm" id="feedbackBtn" data-toggle="modal" 
                                   data-target="#feedback">Feedback</button>
                                   <button class="dropdown-item btn btn-warning btn-sm" id="gsBtn" data-toggle="modal" 
                                   data-target="#gstarted">Getting Started</button>
                               </div>                
                           </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown" 
                                    style="position:relative; top:0px; right:-35px; color:green" >
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        
                         <!-- About Modal -->
                         <div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                               <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                       <div class="modal-header" style="background-color: lightgreen">
                                           
                                           <h4 class="modal-title w-100" id="myModalLabel">About {{ env('APP_NAME') }} (Version {{ env('APP_VER') }})</h4>
                                       </div>
                                       <div class="modal-body">
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <p> <h5> {{ env('APP_NAME') }} features:
                                               </div>
                                               <div class="col-md-12">
                                                   <p>Areas -- area name on property --></p>
                                                   <div class="col-md-12">
                                                       <p>Items -- plants within a given area --></p>
                                                           <div class="col-md-12">
                                                               <p>Needs -- plant requirements</p>
                                                               <p>Properties -- plant characteristics</p>
                                                           </div>
                                                   </div>
                                                   <p>Events -- completed tasks w/ calendar view </p>
                                                   <p>Tasks -- recommended plant care</p>
                                                   <p>Links -- useful plant reference</p>
                                               </div>
                                           </div>          
                                           <br> <br>
                                           <div class="modal-footer" style="background-color: lightgreen">
                                               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>

                            <!-- Build Modal -->
                            <div class="modal fade" id="build" tabindex="-1" role="dialog" aria-labelledby="buildModalLabel">
                               <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                       <div class="modal-header" style="background-color: lightgreen">
                                           
                                           <h4 class="modal-title w-100" id="myModalLabel">Build Info: {{ env('APP_NAME') }} (Version {{ env('APP_VER') }})</h4>
                                       </div>
                                       <div class="modal-body">   
                                           <div class="row">
                                               <div class="col-md-12">
                                                   <p>Laravel => {{ App::Version()}}</p>
                                                   <p>{!! get_package_json2('bootstrap')!!}</p>
                                                   <p>{!! get_package_json2('jquery')!!}</p>
                                                   <p>{!! get_package_json2('laravel-mix')!!}</p>
                                                   <p>{!! get_package_json2('vue')!!}</p>
                                                   <p>{!! php_ver() !!}
                                                   <p>FontAwesome => v.5.7.1</p>
                                                   {!! mysql_db_ver() !!}
                                               </div>
                                           </div>
                                           <div class="modal-footer" style="background-color: lightgreen">
                                               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>

                            <!-- Credits Modal -->
                            <div class="modal fade" id="credits" tabindex="-1" role="dialog" aria-labelledby="creditsModalLabel">
                               <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                       <div class="modal-header" style="background-color: lightgreen">
                                           
                                           <h4 class="modal-title w-100" id="creditsModalLabel">Credits: {{ env('APP_NAME') }} (Version {{ env('APP_VER') }})</h4>
                                       </div>
                                       <div class="modal-body">   
                                           <div class="row">
                                               <div class="col-md-12">
                                                   
                                               </div>
                                           </div>
                                           <div class="modal-footer" style="background-color: lightgreen">
                                               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>

                           <!-- Feedback Modal -->
                           <div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="feedbkModalLabel">
                               <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                       <div class="modal-header" style="background-color: lightgreen">
                                           
                                           <h4 class="modal-title w-100" id="feedbkModalLabel">Feedback: {{ env('APP_NAME') }} (Version {{ env('APP_VER') }})</h4>
                                       </div>
                                       <div class="modal-body">   
                                           <div class="row">
                                               <div class="col-md-12">
                                                   <h4> Please send feedback to rjfallgren@gmail.com </h4>
                                                   <br>
                                                   <br>  
                                               </div>
                                           </div>
                                           <div class="modal-footer" style="background-color: lightgreen">
                                               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           
                            <!-- Getting Started Modal -->
                            <div class="modal fade" id="gstarted" tabindex="-1" role="dialog" aria-labelledby="feedbkModalLabel">
                               <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                       <div class="modal-header" style="background-color: lightgreen">
                                           
                                           <h4 class="modal-title w-100" id="feedbkModalLabel">Getting Started: {{ env('APP_NAME') }} (Version {{ env('APP_VER') }})</h4>
                                       </div>
                                       <div class="modal-body">   
                                           <div class="row">
                                               <div class="col-md-12">
                                                   <p> Create areas in your landscape location (i.e. rose garden; azalea garden) </p>
                                                   <p> Select an area and define plants within that area </p>
                                                   <p> Select a plant (designated by the plant icon) and define needs and properties (designated by the 'question-mark' and 'binocular' icons respectively) </p>
                                                   <p> Create Events (Fertilizer, Growing, Planting, Trimming) as they occur </p>
                                                   <p> Create Tasks (Fertilizer, Flowering, Planting, Trimming) for recommended plant care </p>
                                                   <p> Create helpful Links including name, description and website address for reference </p>
                                                   <br>
                                                   <br>  
                                               </div>
                                           </div>
                                           <div class="modal-footer" style="background-color: lightgreen">
                                               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </ul>
                    </div>
                </div>
            </nav>
            <main class="py-4">
                @yield('content')
            </main>
        </div>
        @yield('script')
    </body>
</html>