
<div class="form-group">
	{{ Form::label('tps_id_entete', 'Travaux pratiques associées:') }}
		<?php  $id_tps = "";  ?>
		@foreach($question->tps as $tp_local)
			<?php  
				if(!$id_tps == "") {
					$id_tps = $id_tps . ', ';
				}	
				$id_tps = $id_tps . $tp_local->id ; ?>
		@endforeach
		<?php if($id_tps == '') {$id_tps='aucun';}?>
	{{ Form::label('tps_id',$id_tps) }}
</div>
<div class="form-group">
	{{ Form::label('nom', 'Nom:') }} 
	{{ Form::text('nom', $question->nom, ['class' => 'form-control']) }}
	{{ $errors->first('nom') }}
</div>
<div class="form-group">
	{{ Form::label('enonce', 'Énoncé:') }} 
	{{ Form::textarea('enonce', $question->enonce, ['class' => 'form-control']) }}
	{{ $errors->first('enonce') }}
</div>
<div class="form-group">
	{{ Form::label('baliseCorrection', 'Balises de correction:') }} 
	{{ Form::textarea('baliseCorrection', $question->baliseCorrection, ['class' => 'form-control']) }}
	{{ $errors->first('baliseCorrection') }}
</div>
<div class="form-group">
	{{ Form::label('reponse', 'Réponse:') }} 
	{{ Form::textarea('reponse', $question->reponse, ['class' => 'form-control']) }}
	{{ $errors->first('reponse') }}
</div>
<div class="form-group">
	{{ Form::label('sur', 'Sur:') }} 
	{{ Form::text('sur', $question->sur, ['class' => 'form-control']) }}
	{{ $errors->first('sur') }}
</div>
