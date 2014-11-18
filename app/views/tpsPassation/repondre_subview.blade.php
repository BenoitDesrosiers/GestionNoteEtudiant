<?php $i = $premiereQuestion; ?>
@foreach($questions as $question)
	 
	<div class='col-sm-1'><strong>{{'(sur '.$question->pivot->sur_local.')'}}</strong></div>	
	<div class='col-sm-9'><strong>{{$i . ") ".$question->nom}}</strong></div> 	
		
	{{ Form::submit('Sauvegarder', ['class' => 'btn btn-success col-sm-2', 'name' => 'sauvegarde']) }} {{-- TODO changer ce bouton pour un call ajax, sinon ca revient toujours au top de la page. --}}
	
	<div class = 'col-sm-12'>
		<div id="enonce" class="resizeDiv resizeDiv-height-2-rows" ">{{$question->enonce}}</div>
	</div>
<div class="form-group">
	{{ Form::label('reponse', 'Réponse', ['class' => "col-sm-12 "]) }} 	
	<div class = 'col-sm-12'>
		{{ Form::textarea('reponse['.$question->id.']', $reponses[$question->id], ['class' => 'form-control ckeditor', 'rows' => '3']) }}
	</div>
</div>
<?php $i++; ?>
@endforeach

