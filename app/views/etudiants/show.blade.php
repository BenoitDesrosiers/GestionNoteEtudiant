@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Affichage</h1>
			<p>Affichage d'un étudiant</p>
		</div>
	</div>
</section>
<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			@include('etudiants.editForm')
		</div>
		
		<a href="{{ action('EtudiantsController@index') }}" class="btn btn-info">Retour aux étudiants</a>
	</section>
</div>
@stop