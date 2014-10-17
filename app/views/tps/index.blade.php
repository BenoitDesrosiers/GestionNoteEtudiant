@extends('layout')
@section('content')
	<div class="container">
		<section class="section-padding">
			<div class="jumbotron text-left">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1> Liste des travaux pratiques</h1>
						{{ Form::open(['action'=> ['TPsController@create'], 'class' => 'form', 'method' => 'get']) }}
							{{ Form::hidden('belongsToId', '1', array('id'=>'belongsToId')) }}
							{{ Form::submit('Créer un TP', ['class' => 'btn btn-primary'])}}					
							<div id="belongsToSelect">						
								{{ Form::select('belongsToListSelect', $belongsToList, $belongsToSelectedId, array('id' => 'belongsToListSelect')) }}
							</div> <!-- belongsToSelect -->
							<div id="filtre1">
								{{ Form::select('filtre1Select', $filtre1SelectList, 0, array('id' => 'filtre1Select')) }}
							</div>
						{{ Form::close() }}
					</div>
					<div id="liste-items">
						<?php // cette div sera remplie par le code js ?>
					</div> <!-- liste-items -->
				</div>
			</div>
		</section>
	</div>

<script>

	var controllerCallBackRoute ='{{URL::action('TPsController@tpsPourClasse') }}'

	/*
	 * change le contenu du "belongsToSelect" selon les filtres sélectionnés. 
	 */
	 
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
		changeSelect("belongsToListSelect", cat[ document.getElementById("filtre1Select").value ], true);
		afficheListeItems();
		updateCreateButton();
		
	});
</script>
{{ HTML::script('assets/js/script_ajax.js') }}
@stop