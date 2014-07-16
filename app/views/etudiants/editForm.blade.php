
<div class="form-group">
	{{ Form::label('classes_id_entete', 'Classes associées:') }}
		<?php  $id_classes = "";  ?>
		@foreach($etudiant->classes as $tp_local)
			<?php  
				if(!$id_classes == "") {
					$id_classes = $id_classes . ', ';
				}	
				$id_classes = $id_classes . $tp_local->id ; ?>
		@endforeach
		<?php if($id_classes == '') {$id_classes ="aucune";}?>
	{{ Form::label('classes_id',$id_classes) }}
</div>
<div class="form-group">
	{{ Form::label('nom', 'Nom:') }} 
	{{ Form::text('nom', $etudiant->nom, ['class' => 'form-control']) }}
	{{ $errors->first('nom') }}
</div>
<div class="form-group">
	{{ Form::label('da', 'DA:') }} 
	{{ Form::text('da', $etudiant->da, ['class' => 'form-control']) }}
	{{ $errors->first('da') }}
</div>

