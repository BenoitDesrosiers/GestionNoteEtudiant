<?php $i = 1; ?>
@foreach($questions as $question)
	 
<div class="form-group">
	{{ Form::label('titre', $question->id.' --'.$question->pivot->ordre.'-- '.$i.') '.$question->nom, ['class' => "col-sm-12 "]) }} 	
	<div class = 'col-sm-12'>
		{{ Form::textarea('enonce', $question->enonce, ['class' => 'form-control', 'disabled' => 'disabled']) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('reponse', 'Réponse', ['class' => "col-sm-12 "]) }} 	
	<div class = 'col-sm-12'>
		{{ Form::textarea('reponse['.$question->id.']', "", ['class' => 'form-control']) }}
	</div>
</div>
<?php $i++; ?>
@endforeach

