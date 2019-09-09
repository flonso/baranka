<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Baranka - @yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
				<link href="css/app.css" rel ="stylesheet">
    </head>
    <body>
		@section('sidebar')
			<nav class="navbar navbar-dark bg-dark justify-content-md-center navbar-expand-sm">
				<ul class="navbar-nav">
			 		<li class="nav-item"><a class="nav-link" href="{{ url('game') }}">Jeu</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ url('players') }}">Joueurs</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ url('objects') }}">Objets</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ url('admin') }}">Admin</a></li>
				</ul>
			</nav>
		@show

		<div class="container">
			@yield('content')
		</div>
		@section('scripts')
			<script src="js/app.js" charset="utf-8"></script>
		@show
	</body>
</html>

