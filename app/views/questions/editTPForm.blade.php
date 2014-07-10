
<div class="form-group">
	{{ Form::label('tps_id_entete', 'Travaux pratiques associées:') }}
		<?php  $id_tps = "";  ?>
		@foreach($question->tps as $question)
			<?php  
				if(!$id_tps == "") {
					$id_tps = $id_tps . ', ';
				}	
				$id_tps = $id_tps . $question->id ; ?>
		@endforeach
	{{ Form::label('tps_id',$id_tps) }}
</div>
<div class="form-group">
	{{ Form::label('nom', 'Nom:') }} 
	{{ Form::text('nom', $question->nom, ['class' => 'form-control']) }}
	{{ $errors->first('nom') }}
</div>
<div class="form-group">
	{{ Form::label('enonce', 'Énoncé:') }} 
	{{ Form::text('enonce', $question->enonce, ['class' => 'form-control']) }}
	{{ $errors->first('enonce') }}
</div>
<div class="form-group">
	{{ Form::label('tag', 'Tag:') }} 
	{{ Form::text('tag', $question->tag, ['class' => 'form-control']) }}
	{{ $errors->first('tag') }}
</div>
<div class="form-group">
	{{ Form::label('sur', 'Sur:') }} 
	{{ Form::text('sur', $question->sur, ['class' => 'form-control']) }}
	{{ $errors->first('sur') }}
</div>
