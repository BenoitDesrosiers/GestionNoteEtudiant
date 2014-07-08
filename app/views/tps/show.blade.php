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
			@include('tps.editTPForm')
		</div>
		
		<a href="{{ action('TPsController@index') }}" class="btn btn-info">Retour aux TPs</a>
	</section>
</div>
@stop