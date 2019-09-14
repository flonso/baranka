<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<meta http-equiv="cache-control" content="no-cache" />

        <title>Baranka - @yield('title')</title>

        <!-- Fonts -->


        <!-- Styles -->
				<link href="css/app.css" rel ="stylesheet">
    </head>
    <body>
		<div aria-live="polite" aria-atomic="true" style="position: relative; right: 30px; top: 30px; z-index: 100000">
			<!-- Position it -->
			<div style="position: absolute; top: 0; right: 0;" id="toastContainer">
			</div>
		</div>

		@section('sidebar')
			<nav class="navbar navbar-dark bg-dark justify-content-md-center navbar-expand-sm">
				<ul class="navbar-nav">
			 		<li class="nav-item"><a class="nav-link" href="{{ url('game') }}">Jeu</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ action('PlayersViewController@get') }}">Joueurs</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ action('ItemsViewController@get') }}">Objets</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ action('AdminViewController@get') }}">Admin</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ action('RankingViewController@get') }}">Classement</a></li>
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

