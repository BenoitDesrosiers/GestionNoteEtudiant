<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Gestion des notes</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
	{{ HTML::script('assets/js/script.js') }}
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<header>
	<nav class="navbar navbar-default" role="navigation">
		<div class="navbar-header">
	
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu-principal">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">Cégep de Drummondville</a>
		</div>
		<div class="collapse navbar-collapse" id="menu-principal">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="{{ action('ClassesController@index') }}">Home</a></li>
				<li><a href="./gestion">Gestion</a></li>
			</ul>
		</div>
	</nav>
</header>

@yield('content')
</body>



</html>