@extends('layout') 
@section('content')
<section class="header section-padding">
	<div class="background">&nbsp;</div>
	<div class="container">
		<div class="header-text">
			<h1>Effacer</h1>
			<p>Page pour effacer une classe</p>
		</div>
	</div>
</section>
<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-center">
			<h1>Voulez-vous effacer cette classe {{ $classe->id }}?</h1>
			{{ Form::open(['action' => array('ClassesController@destroy', $classe->id), 'method' => DELETE, 'class'=>'form']) }} 
			{{ Form::hidden('id', $classe->id) }}
			<div class="form-group">
				{{ Form::submit('Effacer la classe', ['class' => 'btn btn-primary']) }} 
				<a href="{{ action('ClassesController@home') }}" class="btn btn-danger"> Non </a>
			</div>
			{{ Form::close() }}
		</div>
	</section>
</div>
@stop
