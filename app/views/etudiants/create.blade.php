@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Création</h1>
			<p>Page de création d'un étudiant</p>
		</div>
	</div>
</section>

<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<h1>Création d'un étudiant</h1>
			
			{{ Form::open(['url'=> 'etudiants', 'class' => 'form']) }}
				@include('etudiants.createForm')
			{{ Form::close() }}
		</div>
	</section>
</div>
@stop