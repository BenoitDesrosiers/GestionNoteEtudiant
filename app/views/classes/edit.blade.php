@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Édition</h1>
			<p>Page d'édition d'une classe</p>
		</div>
	</div>
</section>

<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<h1>Édition d'une classe</h1>
			{{ Form::open(['action'=> array('ClassesController@update', $classe->id), 'method' => 'PUT', 'class' => 'form']) }}
			
			<div class="form-group">
				{{ Form::label('code', 'Code:') }} 
				{{ Form::text('code',$classe->code, ['class' => 'form-control']) }}
				{{ $errors->first('code') }}
			</div>
			<div class="form-group">
				{{ Form::label('nom', 'Nom:') }} 
				{{ Form::text('nom', $classe->nom, ['class' => 'form-control']) }}
				{{ $errors->first('nom') }}
			</div>
			<div class="form-group">
				{{ Form::label('session', 'Session:') }} 
				{{ Form::text('session', $classe->session, ['class' => 'form-control']) }}
				{{ $errors->first('session') }}
			</div>
			<div class="form-group">
				{{ Form::label('groupe', 'Groupe:') }} 
				{{ Form::text('groupe',$classe->groupe, ['class' => 'form-control']) }}
			</div>
			<div class="form-group">
				{{ Form::label('local', 'Local:') }} 
				{{ Form::text('local',$classe->local, ['class' => 'form-control']) }}
			</div>	
			<div class="form-group">
				{{ Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) }}
			</div>
			{{ Form::close() }}
		</div>
	</section>
</div>
@stop