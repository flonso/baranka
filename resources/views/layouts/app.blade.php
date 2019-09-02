<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Baranka - @yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
		<link href="../public/css/app.css" rel ="stylesheet">
    </head>
    <body>
		@section('sidebar')
			<nav id="sidebar-nav">
				<ul class="nav nav-pills nav-stacked">
					<li><a href="{{ url('game') }}">Jeu</a></li>
					<li><a href="{{ url('players') }}">Joueurs</a></li>
					<li><a href="{{ url('objects') }}">Objets</a></li>
					<li><a href="{{ url('admin') }}">Admin</a></li>
				</ul>
			</nav>
		@show

		<div class="container">
			@yield('content')
		</div>
	</body>
</html>

