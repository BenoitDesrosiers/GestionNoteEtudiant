@extends('layout')
@section('content')

	{{-- affiche tous les TPs et permet de les connecter à la classe courante --}}


	<div class="container">
		<section class="section-padding">
			<div class="jumbotron text-left">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1> Liste des travaux pratiques disponibles</h1>
					</div>
					@if ($tps->isEmpty())
						<p>Aucun travail pratique disponible!</p>
					@else
						{{ Form::open(['action'=>array('ClassesTPsController@doConnect', $classe->id), 'method' => 'POST', 'class' => 'form']) }}
					
						<div class="form-group">
							{{ Form::submit('Appliquer', ['class' => 'btn btn-primary']) }}
						</div>
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Associé</th>
									<th>Nom</th>
									<th>Sur (calculé)</th>
									<th>Poids</th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								@foreach($tps as $tp)
									<?php $trouve = false; ?> 
								
									<tr>
										<td><a href="{{ action('ClassesTPsController@show', [$classe->id, $tp->id]) }}">{{ $tp->id }}</a> </td>
										<td>@if ($tp->classes->contains($classe)) 
												<?php $trouve = true; ?>
											@endif
											{{ Form::checkbox('selectionClasse[]', $tp->id, $trouve ) }}
										</td>
										<td>{{ $tp->nom }} </td>
										<td>{{ $tp->questions()->sum('sur_local') }} </td>
										<td>{{ $tp->poids }} </td>
									
									</tr>
								@endforeach
								
									
							</tbody>
								
						</table>
						{{ Form::close() }}
					@endif
				</div>
			</div>
		</section>
	</div>

@stop