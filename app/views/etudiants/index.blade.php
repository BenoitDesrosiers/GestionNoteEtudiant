@extends('layout')
@section('content')

	<div class="container">
		<section class="section-padding">
			<div class="jumbotron text-left">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1> Liste des etudiants</h1>
						<a href="{{ action('EtudiantsController@create') }}" class="btn btn-info">Créer une etudiant</a>						
					</div>
					
					@if ($etudiants->isEmpty())
						<p>Aucune etudiant de disponible!</p>
					@else
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Nom</th>
									<th>da</th>
									<th> </th>
									<th> </th>
									
								</tr>
							</thead>
							<tbody>
								@foreach($etudiants as $etudiant)
									<tr>
										<td><a href="{{ action('EtudiantsController@show', [$etudiant->id]) }}">{{ $etudiant->id }}</a> </td>
										<td>{{ $etudiant->nom }} </td>
										<td>{{ $etudiant->da }} </td>
										<td><a href="{{ action('EtudiantsController@edit', [$etudiant->id]) }}" class="btn btn-info">Éditer</a></td>
										<td>
											{{ Form::open(array('action' => array('EtudiantsController@destroy', $etudiant->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) }}
	                                        	<button type="submit" href="{{ URL::route('etudiants.destroy', $etudiant->id) }}" class="btn btn-danger btn-mini">Effacer</button>
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