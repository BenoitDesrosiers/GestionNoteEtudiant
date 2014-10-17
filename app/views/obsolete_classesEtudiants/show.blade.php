@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Affichage</h1>
			<p>Affichage d'un Étudiant</p>
		</div>
	</div>
</section>
<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<h1>Classe: {{ $classe->code ."   ". $classe->session." # étudiant: ".$etudiant->id}}</h1>
			@include('etudiants.editForm')
		</div>
		
		<a href="{{ action('ClassesEtudiantsController@index',$classe->id) }}" class="btn btn-info">Retour à la classe {{ $classe->code ."   ". $classe->session }}</a>
	</section>
</div>
@stop