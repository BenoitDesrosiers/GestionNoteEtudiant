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
						{{ Form::close() }}
					</div>
					
					<div id="belongsToSelect">						
						{{ Form::select('belongsToListSelect', $belongsToList, $belongsToSelectedId, array('id' => 'belongsToListSelect')) }}
					</div> <!-- belongsToSelect -->
					
					<div id="liste-items">
						<?php // cette div sera remplie par le code js ?>
					</div> <!-- liste-items -->
				</div>
			</div>
		</section>
	</div>

<script>	
	function afficheListeItems() {
		$.ajax({
			type: 'POST',
			url: '{{URL::action('TPsController@tpsPourClasse') }}',
			data: { belongsToId : document.getElementById('belongsToListSelect').value  },
			timeout: 1000,
			success: function(data){
				document.getElementById('liste-items').innerHTML=data;
				}
		});		
	}	

</script>
{{ HTML::script('assets/js/script_ajax.js') }}
@stop