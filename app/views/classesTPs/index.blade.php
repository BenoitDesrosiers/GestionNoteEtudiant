@extends('layout')
@section('content')



	<div class="container">
		<section class="section-padding">
			<div class="jumbotron text-left">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1> Liste des Travaux pratiques pour la classe {{ $classe->code . ' ' . $classe->session }}</h1>
						<a href="{{ action('ClassesTPsController@create') }}" class="btn btn-info">Créer un TP</a>						
						
					</div>
					
					@if ($tps->isEmpty())
						<p>Aucun travail pratique  disponible!</p>
					@else
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Numéro</th>
									<th>Nom</th>
									<th>Sur</th>
									<th>Poids</th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								@foreach($tps as $tp)
									<tr>
										<td>{{ $tp->id }}</a> </td>
										<td>{{ $tp->numero }} </td>
										<td>{{ $tp->nom }} </td>
										<td>{{ $tp->sur }} </td>
										<td>{{ $tp->poids }} </td>
										<td><a href="{{ action('ClassesTPsController@edit', $tp->id) }}" class="btn btn-info">Éditer</a></td>
										<td>
											{{ Form::open(array('action' => array('ClassesTPsController@destroy',$classe->id, $tp->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) }}
	                                        	<button type="submit" href="{{ URL::route('classes.destroy', $classe->id) }}" class="btn btn-danger btn-mini">Effacer</button>
	                                        {{ Form::close() }}   {{-- méthode pour faire le delete tel que décrit sur http://www.codeforest.net/laravel-4-tutorial-part-2 , 
	                                        						   un script js est appelé pour tous les form qui ont un "data-confirm" (voir assets/js/script.js) --}}
										</td>
										<td><a href="{{ action('ClassesTPsController@index',$classe->id) }}" class="btn btn-info">TPs</a></td>
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