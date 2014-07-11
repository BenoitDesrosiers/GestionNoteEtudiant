@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Édition</h1>
			<p>Page d'édition d'une question</p>
		</div>
	</div>
</section>

<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<h1>Édition d'une question</h1>
			{{ Form::open(['action'=> array('TPsQuestionsController@update', $tp->id, $question->id), 'method' => 'PUT', 'class' => 'form']) }}
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
				<div class="form-group">
					{{ Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) }}
				</div>
			{{ Form::close() }}
		</div>
	</section>
</div>
@stop