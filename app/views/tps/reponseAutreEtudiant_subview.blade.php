<div>
	{{ Form::label('msg','Corrections déjà faites pour les autres étudiants', ['class' => "col-sm-12 "]) }} 
	
	<div class="form-group">
		{{ Form::label('autreEtudiant','Réponse de: '.$nom."&nbsp;&nbsp;&nbsp;valant ".$pointage.' points', ['class' => "col-sm-12 "]) }} 
		<div class = 'col-sm-12'>
			<?php $rows = round(strlen($reponse)/130)+1?>
			{{ Form::textarea('reponse1', $reponse, ['class' => 'form-control', 'disabled' => 'disabled', 'rows' => $rows]) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('commentaire1', 'Commentaires de correction', ['class' => "col-sm-12 "]) }} 	
		<div class = 'col-sm-12'>
			{{ Form::textarea('commentaire1', $commentaire, ['class' => 'form-control', 'rows' => '4', 'disabled' => 'disabled']) }}
		</div>
	</div>
	
	<?php if($flagBoutonEtudiantPrecedent) {$disabledState = ''; } else {$disabledState = 'disabled';} ?>
		{{ Form::submit('étudiant précédent', ['class' => 'btn btn-primary', 'name'=>'etudiantPrecedent', $disabledState=>$disabledState, 
				"onclick" => "changeAutreEtudiant('precedent')"]) }}
	<?php if($flagBoutonEtudiantSuivant) {$disabledState = ''; } else {$disabledState = 'disabled';} ?>
		{{ Form::submit('étudiant suivant', ['class' => 'btn btn-primary', 'name'=>'etudiantSuivant', $disabledState=>$disabledState,
				"onclick" => "changeAutreEtudiant('suivant')"]) }}
</div>