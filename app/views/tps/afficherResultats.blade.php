@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>Résultats de {{{$tp->nom}}} pour la classe {{{$classe->nom}}} </h1>
		</div>
	</div>
</section>

<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			<div class = "table-responsive">
				<table class="table table-hover" >
					<thead>
						<th>Nom</th>
					<?php $nombreQuestion = count($resultats[1]['notes']);
							$i = 1;?>
					@foreach($questions as $question)
						<th>Q{{$i++}} / {{$question->pivot->sur_local}}</th>
					@endforeach
					</thead>
					
					<tbody>
					
					@foreach($resultats as $resultat)
						<tr>
							<td>{{{$resultat['nom']}}}</td>
							@foreach($resultat['notes'] as $note)
							<td>{{{$note}}}</td>
							@endforeach
						</tr>
					@endforeach
					</tbody>
				</table>
					
			
			</div>
		
				
		</div>
	</section>
</div>
@stop