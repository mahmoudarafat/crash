<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Your Website Title</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">


    @livewireStyles
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">{{ auth()->user()->email ?? 'Login, Please.' }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
             <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>


                </ul>

            
            @guest

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>

                </ul>

            @endguest
            @auth
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('feed')}}">Feed <span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('books.index')}}">My Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('books.create')}}">Add A Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('friends')}}">Friends</a>
                    </li>

                    <li class="nav-item">
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button class="nav-link">Logout</button>
                        </form>
                    </li>

                </ul>
            @endauth
        </div>
    </nav>

    @yield('content')

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    @livewireScripts

    <script>
        var current = '{{ request()->url() }}';
        $(document).find('a.nav-link').removeClass('active');
        $(document).find('a.nav-link').each(function(){
            if($(this).attr('href') == current){
                $(this).addClass('active');
            }
        });
        
    </script>

    @yield('scripts')
</body>

</html>
