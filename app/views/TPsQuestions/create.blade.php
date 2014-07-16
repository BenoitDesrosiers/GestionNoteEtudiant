@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Création</h1>
			<p>Page de création d'une question</p>
		</div>
	</div>
</section>

<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<h1>Création d'une question</h1>
			
			{{ Form::open(['url'=> 'tps/'.$tp->id.'/questions', 'class' => 'form']) }}
				@include('questions.createForm')
				<div class="form-group">
					{{ Form::label('sur_local', 'Sur (pour ce test):') }} 
					{{ Form::text('sur_local', null, ['class' => 'form-control']) }}
					{{ $errors->first('sur_local') }}
				</div>
				<div class="form-group">
					{{ Form::label('ordre', 'Ordre (pour ce test):') }} 
					{{ Form::text('ordre', null, ['class' => 'form-control']) }}
					{{ $errors->first('ordre') }}
				</div>
				<div class="form-group">
					{{ Form::submit('Créer', ['class' => 'btn btn-primary'])}}
				</div>
			{{ Form::close() }}
		</div>
	</section>
</div>
@stop