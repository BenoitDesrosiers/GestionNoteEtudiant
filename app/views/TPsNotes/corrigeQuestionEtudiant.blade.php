@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Correction</h1>
			<p>Page de correction</p>
		</div>
	</div>
</section>

<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<h1>Correction de la question {{ $note->question->nom }} pour {{ $note->etudiant->nom . ' ' . $note->etudiant->da}}</h1>
			<h2>Énoncé</h2>		
			{{ Form::textarea('enonce', $note->question->enonce, ['class' => 'form-control', 'readonly' => 'readonly', 'rows' => '2']) }}
			<h2>Réponse</h2>
			{{ Form::textarea('reponse', $note->question->reponse, ['class' => 'form-control', 'readonly' => 'readonly', 'rows' => '2']) }}
			{{ Form::open(['action'=> array('TPsNotesController@update'), 'method' => 'PUT', 'class' => 'form']) }}
				{{ Form::hidden('noteId[]', $note->id) }}
				<div class="form-group">
					<?php $noteLocal = TP::find($note->tp->id)->questions->find($note->question->id)->pivot->sur_local; ?> 
					
					
					{{ Form::label('note[]', 'Note : (sur '. $noteLocal . ')') }} 
					{{ Form::text('note[]', $note->note, ['class' => 'form-control']) }}
					{{ $errors->first('note[]') }}
				</div>
				<div class="form-group">
					{{ Form::label('commentaire[]', 'commentaire') }} 
					{{ Form::textarea('commentaire[]', $note->commentaire, ['class' => 'form-control']) }}
					{{ $errors->first('commentaire[]') }}
				</div>
				<div class="form-group">
					{{ Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) }}
				</div>
			{{ Form::close() }}
		</div>
	</section>
</div>
@stop