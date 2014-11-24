<div class='col-xs-12'>
@foreach($toutesLesReponses as $reponse)
	<p class='col-xs-1 alert @if($reponse->reponse) alert-success @else alert-warning @endif '>{{$reponse->ordre}}</p>
@endforeach
</div>

<?php $i = $premiereQuestion; ?>
@foreach($reponsesPageCourante as $reponse)
	<?php $laQuestion=$toutesLesQuestions->find($reponse->question_id);?>
	<div class='col-sm-1'><strong>{{'(sur '.$laQuestion->pivot->sur_local.')'}}</strong></div>	
	<div class='col-sm-9'><strong>{{$i . ") ".$laQuestion->nom}}</strong></div> 	
		
	{{ Form::submit('Sauvegarder', ['class' => 'btn btn-success col-sm-2', 'name' => 'sauvegarde']) }} {{-- TODO changer ce bouton pour un call ajax, sinon ca revient toujours au top de la page. --}}
	
	<div class = 'col-sm-12'>
		<div id="enonce" class="resizeDiv resizeDiv-height-2-rows" ">{{$laQuestion->enonce}}</div>
	</div>
<div class="form-group">
	{{ Form::label('reponse', 'Réponse', ['class' => "col-sm-12 "]) }} 	
	<div class = 'col-sm-12'>
		{{ Form::textarea('reponse['.$laQuestion->id.']', $reponse->reponse, ['class' => 'form-control ckeditor', 'rows' => '3']) }}
	</div>
</div>
<?php $i++; ?>
@endforeach

