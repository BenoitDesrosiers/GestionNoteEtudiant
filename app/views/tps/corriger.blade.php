@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>{{{$classe->nom}}} / {{{$tp->nom}}} / {{{$etudiant->prenom}}} {{{$etudiant->nom}}}</h1>
			<p>sur: {{$tp->questions()->sum('sur_local')}}  vaut: {{{$tp->pivot->poids_local}}}
		</div>
	</div>
</section>

<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			{{ Form::open(['route'=> array('tps.doCorriger', $etudiant->id, $classe->id, $tp->id, $question->id), 'method' => 'PUT', 'class' => 'form-horizontal form-compact', 'role'=>'form']) }}
				@include('tps.corriger_subview')
				<div class="form-group">
					{{ Form::submit('Terminer', ['class' => 'btn btn-primary', 'name'=>'terminer']) }}
				<?php if($flagEtudiantPrecedent) {$disabledState = ''; } else {$disabledState = 'disabled';} ?>
					{{ Form::submit('étudiant précédent', ['class' => 'btn btn-primary', 'name'=>'etudiantPrecedent', $disabledState=>$disabledState]) }}

				<?php if($flagEtudiantSuivant) {$disabledState = ''; } else {$disabledState = 'disabled';} ?>
					{{ Form::submit('étudiant suivant', ['class' => 'btn btn-primary', 'name'=>'etudiantSuivant', $disabledState=>$disabledState]) }}
				
				<?php if($flagQuestionPrecedente) {$disabledState = ''; } else {$disabledState = 'disabled';} ?>
					{{ Form::submit('question précédente', ['class' => 'btn btn-primary', 'name'=>'questionPrecedente', $disabledState=>$disabledState]) }}

				<?php if($flagQuestionSuivante) {$disabledState = ''; } else {$disabledState = 'disabled';} ?>
					{{ Form::submit('question suivante', ['class' => 'btn btn-primary', 'name'=>'questionSuivante', $disabledState=>$disabledState]) }}
				</div>
			{{ Form::close() }}
			
			
			<div id="autre-reponse">
				<?php // la section permettant de voir les réponses des autres étudiants. 
					  // Elle est remplie par un call Ajax ?>
			</div>
			
		</div>
	</section>
</div>

<script>

var controllerCallBackRoute ='{{URL::route('tps.afficheReponseAutreEtudiant') }}'

/*
 * change le contenu de "autreReponse" selon le bouton sélectionné. 
 */


function afficheAutreEtudiant(direction) {
		dataObject = { direction : direction };
		$.ajax({
			type: 'POST',
			url: controllerCallBackRoute,
			data: dataObject, 
			timeout: 1000,
			success: function(data){
				document.getElementById('autre-reponse').innerHTML=data;
				}
		});		
	}	
function changeAutreEtudiant(direction) {
	afficheAutreEtudiant(direction);	
}

$(document).ready(function() {
	changeAutreEtudiant('suivant');
});

</script>
@stop