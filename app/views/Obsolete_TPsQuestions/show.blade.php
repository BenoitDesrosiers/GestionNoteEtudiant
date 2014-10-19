@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Affichage</h1>
			<p>Affichage d'une question</p>
		</div>
	</div>
</section>
<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<h1>TP: {{ $tp->id ."   ". $tp->nom}}</h1>
			@include('questions.editForm')
			<div class="form-group">
					{{ Form::label('sur_local', 'Sur (pour ce test):') }} 
					{{ Form::text('sur_local', $question->pivot->sur_local, ['class' => 'form-control']) }}
					{{ $errors->first('sur_local') }}
				</div>
				<div class="form-group">
					{{ Form::label('ordre', 'Ordre (pour ce test):') }} 
					{{ Form::text('ordre', $question->pivot->ordre, ['class' => 'form-control']) }}
					{{ $errors->first('ordre') }}
				</div>
		</div>
		
		<a href="{{ action('TPsQuestionsController@index',$tp->id) }}" class="btn btn-info">Retour au TP {{ $tp->nom }}</a>
	</section>
</div>
@stop