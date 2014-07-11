@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Édition</h1>
			<p>Page d'édition d'un travail pratique</p>
		</div>
	</div>
</section>

<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<h1>Édition d'un TP</h1>
			{{ Form::open(['action'=> array('ClassesTPsController@update', $classe->id, $tp->id), 'method' => 'PUT', 'class' => 'form']) }}
				@include('tps.editForm')
				<div class="form-group">
					{{ Form::label('poids_local', 'Poids local:') }} 
					{{ Form::text('poids_local',$tp->pivot->poids_local, ['class' => 'form-control']) }}
				</div>
				<div class="form-group">
					{{ Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) }}
				</div>
			{{ Form::close() }}
		</div>
	</section>
</div>
@stop