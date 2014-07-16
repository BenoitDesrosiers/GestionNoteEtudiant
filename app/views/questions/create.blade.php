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
			
			{{ Form::open(['url'=> 'questions', 'class' => 'form']) }}
				@include('questions.createForm')
				<div class="form-group">
					{{ Form::submit('Créer', ['class' => 'btn btn-primary'])}}
				</div>
			{{ Form::close() }}
		</div>
	</section>
</div>
@stop