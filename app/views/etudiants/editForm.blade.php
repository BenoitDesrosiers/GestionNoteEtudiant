<?php if(!isset($etudiant)) {$etudiant = new Etudiant;}?>
<div id="belongsToSelect" class="form-group">
	{{Form::label('dummy', "Associer à:", ['class' =>"col-sm-2 control-label"])}}
	<div class = 'col-sm-7'>
		{{ Form::select('belongsToListSelect[]', $belongsToList,$belongsToSelectedIds, 
					['id' => 'belongsToListSelect', 'size' =>5, 'multiple'=>'true',
					'class' => 'form-control']) }}
	</div>
	<div  class = 'col-sm-3 form-group'>
		{{Form::label('dummy', "Filtre de Sessions", ['class' =>"col-sm-12 control-label"])}}
		<div id="filtre1" class = 'col-sm-12'>
			{{ Form::select('filtre1Select', $filtre1["selectList"], 0, ['class' =>"form-control", 'id' => 'filtre1Select']) }}
		</div>
	</div>
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

