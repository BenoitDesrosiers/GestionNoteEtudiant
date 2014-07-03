@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Création</h1>
			<p>Page de création d'une classe</p>
		</div>
	</div>
</section>

<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<h1>Création d'une classe</h1>
			{{ Form::open(['url'=> 'classes', 'class' => 'form']) }}
			<div class="form-group">
				{{ Form::label('code', 'Code:') }} 
				{{ Form::text('code',null, ['class' => 'form-control']) }}
				{{ $errors->first('code') }}
			</div>
			<div class="form-group">
				{{ Form::label('nom', 'Nom:') }} 
				{{ Form::text('nom',null, ['class' => 'form-control']) }}
				{{ $errors->first('nom') }}
				
			</div>
			<div class="form-group">
				{{ Form::label('session', 'Session:') }} 
				{{ Form::text('session',null, ['class' => 'form-control']) }}
				{{ $errors->first('session') }}
				
			</div>
			<div class="form-group">
				{{ Form::label('groupe', 'Groupe:') }} 
				{{ Form::text('groupe',null, ['class' => 'form-control']) }}
			</div>
			<div class="form-group">
				{{ Form::label('local', 'Local:') }} 
				{{ Form::text('local',null, ['class' => 'form-control']) }}
			</div>	
			<div class="form-group">
				{{ Form::submit('Créer', ['class' => 'btn btn-primary'])}}
			</div>
			{{ Form::close() }}
		</div>
	</section>
</div>
@stop