<?php if(!isset($tp)) {$tp = new TP;}?>
<div id="belongsToSelect">
	{{"Associer à:"}}
	{{ Form::select('belongsToListSelect[]', $belongsToList,$belongsToSelectedIds, array('id' => 'belongsToListSelect', 'size' =>5, 'multiple'=>'true')) }}
</div> <!-- belongsToSelect -->

<div class="form-group">
	{{ Form::label('nom', 'Nom:', ['class' => "col-sm-2 control-label"]) }} 
	<div class = 'col-sm-10'>
		{{ Form::text('nom', $tp->nom, ['class' => 'form-control']) }}
		{{ $errors->first('nom') }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('poids', 'Poids:', ['class' => "col-sm-2 control-label"]) }} 
	<div class = 'col-sm-10'>
		{{ Form::text('poids',$tp->poids, ['class' => 'form-control']) }}
	</div>	
</div>
<div class="form-group">
	{{ Form::label('sur', 'Sur (calculé):', ['class' => "col-sm-2 control-label"]) }} 
	<div class = 'col-sm-10'>
		{{ Form::text('sur',$tp->questions()->sum('sur_local') , ['class' => 'form-control', 'readonly'=>'readonly']) }}
	</div>
</div>