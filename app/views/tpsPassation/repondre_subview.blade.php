<?php $i = 1; ?>
@foreach($questions as $question)
	 
<div class="form-group">
	{{ Form::label('surlocal','('.$question->pivot->sur_local.')', ['class' => "col-sm-1 "]) }} 	
	{{ Form::label('titre',$question->id.'   '.$i.') '.$question->nom, ['class' => "col-sm-9 "]) }} 	
	{{ Form::submit('Sauvegarder', ['class' => 'btn btn-success col-sm-2', 'name' => 'sauvegarde']) }} {{-- TODO changer ce bouton pour un call ajax, sinon ca revient toujours au top de la page. --}}
	<div class = 'col-sm-12'>
		<?php $rows = round(strlen($question->enonce)/80)+1?>
		{{ Form::textarea('enonce', $question->enonce, ['class' => 'form-control', 'disabled' => 'disabled', 'rows' => $rows]) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('reponse', 'Réponse', ['class' => "col-sm-12 "]) }} 	
	<div class = 'col-sm-12'>
		{{ Form::textarea('reponse['.$question->id.']', $reponses[$question->id], ['class' => 'form-control', 'rows' => '3']) }}
	</div>
</div>
<?php $i++; ?>
@endforeach

