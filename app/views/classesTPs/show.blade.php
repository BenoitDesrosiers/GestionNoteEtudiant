@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Affichage</h1>
			<p>Affichage d'une classe</p>
		</div>
	</div>
</section>
<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<h1>Classe: {{ $classe->code ."   ". $classe->session }}</h1>
			<p>Nom: {{ $classe->nom }} </p>
			<p>Groupe: {{ $classe->groupe }} </p>
			<p>Local: {{ $classe->local }} </p>
			
		</div>
	</section>
</div>
@stop