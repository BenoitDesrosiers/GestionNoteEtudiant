<?php if(!isset($tp)) {$tp = new TP;}?>
<div id="belongsToSelect" class="form-group">
	{{Form::label('dummy', "Associer à:", ['class' =>"col-sm-2 control-label"])}}
	<div class = 'col-sm-7'>
		{{ Form::select('belongsToListSelect[]', $belongsToList,$belongsToSelectedIds, 
						['id' => 'belongsToListSelect', 'size' =>5, 'multiple'=>'true',
						'class' => 'form-control']) }}
	</div>
	<div id="filtre1" class = 'col-sm-3'>
		{{Form::label('dummy', "Sessions", ['class' =>"col-sm-12 control-label"])}}
		{{ Form::select('filtre1Select', $filtre1SelectList, 0, ['class' =>"col-sm-12", 'id' => 'filtre1Select']) }}
	</div>
</div> <!-- belongsToSelect -->

<div class="form-group">
	{{ Form::label('nom', 'Nom:', ['class' => "col-sm-2 control-label"]) }} 
	<div class = 'col-sm-10'>
		{{ Form::text('nom', $tp->nom, ['class' => 'form-control']) }}
		{{--@if( $errors->first('nom') != null) 
				{{$errors->first('nom')}}
		@endif--}}
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

<script>
$("#filtre1Select").change(function(e) {
	var cat = [];
	<?php 
		foreach($filtre1Categories as $nomCategorie => $categorieItems) {
			echo "cat['".$nomCategorie. "'] = [";
			foreach($categorieItems as $items) {
				echo $items.", ";
			}
			echo "];\n";
		} 
	?>
	changeSelect("belongsToListSelect", cat[ document.getElementById("filtre1Select").value ], false);
	
});
</script>
{{ HTML::script('assets/js/script_ajax.js') }}
