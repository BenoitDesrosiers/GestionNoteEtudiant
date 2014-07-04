@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Création</h1>
			<p>Page de création d'un travail pratique</p>
		</div>
	</div>
</section>

<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<h1>Création d'un travail pratique</h1>
			
			{{ Form::open(['url'=> 'classes/'.$classe->id.'/TPs', 'class' => 'form']) }}
			<div class="form-group">
				{{ Form::label('numero', 'Numero:') }} 
				{{ Form::text('numero',null, ['class' => 'form-control']) }}
				{{ $errors->first('numero') }}
			</div>
			<div class="form-group">
				{{ Form::label('nom', 'Nom:') }} 
				{{ Form::text('nom',null, ['class' => 'form-control']) }}
				{{ $errors->first('nom') }}
			</div>
			<div class="form-group">
				{{ Form::label('sur', 'Sur:') }} 
				{{ Form::text('sur',null, ['class' => 'form-control']) }}
				{{ $errors->first('sur') }}
				
			</div>
			<div class="form-group">
				{{ Form::label('poids', 'Poids:') }} 
				{{ Form::text('poids',null, ['class' => 'form-control']) }}
				{{ $errors->first('poids') }}
				
			</div>
			
			<div class="form-group">
				{{ Form::submit('Créer', ['class' => 'btn btn-primary'])}}
			</div>
			{{ Form::close() }}
		</div>
	</section>
</div>
@stop