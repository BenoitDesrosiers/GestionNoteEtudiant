@extends('layout')
@section('content')

	{{-- affiche tous les étudiants et permet de les connecter à la classe courante --}}


	<div class="container"> 
		<section class="section-padding">
			<div class="jumbotron text-left">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1> Liste des étudiants disponibles</h1>
					</div>
					@if ($etudiants->isEmpty())
						<p>Aucun étudiants d'inscrit!</p>
					@else
						{{ Form::open(['action'=>array('ClassesEtudiantsController@doConnect', $classe->id), 'method' => 'POST', 'class' => 'form']) }}
					
						<div class="form-group">
							{{ Form::submit('Appliquer', ['class' => 'btn btn-primary']) }}
						</div>
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Associé</th>
									<th>Nom</th>
									<th>DA</th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								@foreach($etudiants as $etudiant)
									<?php $trouve = false; ?> 
								
									<tr>
										<td><a href="{{ action('ClassesEtudiantsController@show', [$classe->id, $etudiant->id]) }}">{{ $etudiant->id }}</a> </td>
										<td>@if ($etudiant->classes->contains($classe)) 
												<?php $trouve = true; ?>
											@endif
											{{ Form::checkbox('selectionClasse[]', $etudiant->id, $trouve ) }}
										</td>
										<td>{{ $etudiant->nom }} </td>
										<td>{{ $etudiant->da }} </td>
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