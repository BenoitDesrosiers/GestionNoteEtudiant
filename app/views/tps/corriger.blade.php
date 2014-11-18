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
					
				<?php $infoSup = ['class' => 'btn btn-primary col-xs-6 col-sm-3 col-md-2', 'name'=>'etudiantPrecedent'];
						if(!$flagEtudiantPrecedent) {$infoSup['disabled'] = 'disabled';} ?>
					{{ Form::submit('étudiant précédent', $infoSup) }}

				<?php $infoSup = ['class' => 'btn btn-primary col-xs-6 col-sm-3 col-md-2', 'name'=>'etudiantSuivant'];
						if(!$flagEtudiantSuivant) {$infoSup['disabled'] = 'disabled';} ?>
					{{ Form::submit('étudiant suivant', $infoSup) }}
				
				<?php $infoSup = ['class' => 'btn btn-primary col-xs-6 col-sm-3 col-md-2', 'name'=>'questionPrecedente'];
						if(!$flagQuestionPrecedente) {$infoSup['disabled'] = 'disabled';} ?>
					{{ Form::submit('question précédente',$infoSup) }}

				<?php $infoSup = ['class' => 'btn btn-primary col-xs-6 col-sm-3 col-md-2', 'name'=>'questionSuivante'];
						if(!$flagQuestionSuivante) {$infoSup['disabled'] = 'disabled';} ?>
					{{ Form::submit('question suivante', $infoSup) }}
					
					{{ Form::submit('Terminer', ['class' => 'btn btn-primary col-xs-12  col-sm-3 col-md-2', 'name'=>'terminer']) }}
				</div>
			{{ Form::close() }}
			
			<div id="note-globale">
				<div class='col->sm-12'><strong>Sommaire pour cet étudiant pour ce TP</strong></div>
				@foreach($sommaireNotes as $i => $sommaireNote)
					<div class="col-xs-1">{{ $i.')'.$sommaireNote['note'].'/'.$sommaireNote['sur']}}</div>
				@endforeach
			</div>
			
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
	afficheAutreEtudiant('suivant');
	
});

</script>
@stop