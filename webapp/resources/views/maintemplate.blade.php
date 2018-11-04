<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>Darkest Dungeon Tracker</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('css/darkest.css')}}" rel="stylesheet">
  </head>

  <body class="text-center">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
          <h3 class="masthead-brand">Darkest Dungeon Tracker</h3>
          <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link active" href="{{route('dungeonRun')}}">Dungeon Runner</a>
            <a class="nav-link" href="{{route('statistics')}}">Statistics</a>
            <a class="nav-link" href="{{route('gameInformation')}}">Game Information</a>
          </nav>
        </div>
      </header>

      <main role="main" class="inner cover">
      @yield('content')
      </main>

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>Darkest Dungeon Stat Tracker and Planner.</p>
        </div>
      </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="{{asset('js/app.js')}}"></script>
    @yield('inline-scripts')
  </body>
</html>
