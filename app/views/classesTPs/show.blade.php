@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Affichage</h1>
			<p>Affichage d'un TP</p>
		</div>
	</div>
</section>
<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<h1>Classe: {{ $classe->code ."   ". $classe->session." TP #"}}</h1>
			<p>Nom: {{ $tp->nom }} </p>
			<p>Sur: {{ $tp->sur }} </p>
			<p>Poids: {{ $tp->poids }} </p>
			
		</div>
		
		<a href="{{ action('ClassesTPsController@index',$classe->id) }}" class="btn btn-info">Retour à la classe {{ $classe->code ."   ". $classe->session }}</a>
	</section>
</div>
@stop