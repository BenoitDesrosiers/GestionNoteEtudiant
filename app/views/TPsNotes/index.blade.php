@extends('layout')
@section('content')



	<div class="container">
		<section class="section-padding">
			<div class="jumbotron text-left">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1> Correction du TP {{ $tp->id . ' ' . $tp->nom }} pour la classe {{ $classe->nom . ' ' . $classe->session }}</h1>											
					</div>
					<div>
						{{ Form::open(['action'=> array('TPsNotesController@edit', $classe->id, $tp->id), 'method' => 'PUT', 'class' => 'form']) }}
						<div>
							<div class="form-group" style="float:left;">
								<p>Étudiants</p>
								
								
								<?php 
									
									if($etudiants->isEmpty() or $questions->isEmpty()) {
										$button_enabler = 'disabled';
									} else {
										$button_enabler = 'enabled';
									}
								$liste_etudiants = [];
									foreach ($etudiants as $etudiant) {
										$liste_etudiants[$etudiant->id] = $etudiant->nom . ', '. $etudiant->da;
									}
								?>
								{{Form:: select('etudiants', $liste_etudiants) }}
							</div>
							<div class="form-group" style="float:left;">
								<p>Questions</p>
								<?php $liste_questions = [];
									foreach ($questions as $question) {
										$liste_questions[$question->id] = $question->nom;
									}
								?>											
								{{Form:: select('questions', $liste_questions) }}
							</div>
							
						</div>
						<div class="form-group" style="clear:both">
							{{ Form::submit('Corriger cet étudiant', ['name' => 'corrigerEtudiant','class' => 'btn btn-info', $button_enabler => $button_enabler]) }}
							{{ Form::submit('Corriger cette question', ['name' => 'corrigerQuestion', 'class' => 'btn btn-info', $button_enabler => $button_enabler]) }}
							{{ Form::submit('Corriger cette question/étudiant', ['name' => 'corrigerQuestionEtudiant','class' => 'btn btn-info', $button_enabler => $button_enabler]) }}
						</div>		
						{{ Form::close() }}
					</div>
					
				</div>
			</div>
		</section>
	</div>

@stop