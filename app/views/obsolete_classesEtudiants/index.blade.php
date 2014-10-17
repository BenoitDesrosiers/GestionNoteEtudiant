@extends('layout')
@section('content')



	<div class="container">
		<section class="section-padding">
			<div class="jumbotron text-left">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1> Liste des étudiants pour la classe {{ $classe->code . ' ' . $classe->session }}</h1>
						<a href="{{ action('ClassesEtudiantsController@create', $classe->id) }}" class="btn btn-info">Créer un étudiant</a>	
						<a href="{{ action('ClassesEtudiantsController@connect', $classe->id) }}" class="btn btn-info">Associer un étudiant</a>						
											
						<?php //TODO: ajouter un bouton pour copier les Etudiants d'une autres classes?> 
					</div>
					
					@if ($etudiants->isEmpty())
						<p>Aucun étudiant d'inscrit!</p>
					@else
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Nom</th>
									<th>DA</th>
									<th> </th>
									<th> </th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								@foreach($etudiants as $etudiant)
									
									<tr>
										<td><a href="{{ action('ClassesEtudiantsController@show', [$classe->id, $etudiant->id]) }}">{{ $etudiant->id }}</a> </td>
										<td>{{ $etudiant->nom }} </td>
										<td>{{ $etudiant->da }} </td>										
										<td><a href="{{ action('ClassesEtudiantsController@edit', [$classe->id, $etudiant->id]) }}" class="btn btn-info">Éditer</a></td>
	                                    <td><a href="{{ action('ClassesEtudiantsController@disconnect', [$classe->id, $etudiant->id]) }}" class="btn btn-info">Déconnecter</a></td>
										<td>
											{{ Form::open(array('action' => array('ClassesEtudiantsController@destroy',$classe->id, $etudiant->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain? Il sera détaché de toutes les classes auquel il est associée')) }}
	                                        	<button type="submit" href="{{ URL::route('classes.etudiants.destroy', $classe->id, $etudiant->id) }}" class="btn btn-danger btn-mini">Effacer</button>
	                                        {{ Form::close() }}   
	                                    </td>
									</tr>
								@endforeach
							</tbody>
								
						</table>
					@endif
				</div>
			</div>
		</section>
	</div>

@stop