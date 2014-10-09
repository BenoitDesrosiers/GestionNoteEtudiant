<?php if(!isset($etudiant)) {$etudiant = new Etudiant;}?>
<div id="belongsToSelect">
	{{"Associer à:"}}
	{{ Form::select('belongsToListSelect[]', $belongsToList,$belongsToSelectedIds, array('id' => 'belongsToListSelect', 'size' =>5, 'multiple'=>'true')) }}
</div> <!-- belongsToSelect -->

<div class="form-group">
	{{ Form::label('nom', 'Nom:', ['class' => "col-sm-2 control-label"]) }} 
	<div class = 'col-sm-10'>
		{{ Form::text('nom', $etudiant->nom, ['class' => 'form-control']) }}
		{{ $errors->first('nom') }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('da', 'DA:', ['class' => "col-sm-2 control-label"]) }} 
	<div class = 'col-sm-10'>
		{{ Form::text('da', $etudiant->da, ['class' => 'form-control']) }}
		{{ $errors->first('da') }}
	</div>
</div>

