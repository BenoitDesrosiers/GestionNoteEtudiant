@extends('layout')
@section('content')



	<div class="container">
		<section class="section-padding">
			<div class="jumbotron text-left">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1> Liste des travaux pratiques</h1>
						<a href="{{ action('TPsController@create') }}" class="btn btn-info">Créer un TP</a>						
					</div>
					
					@if ($tps->isEmpty())
						<p>Aucun travail pratique disponible!</p>
					@else
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Nom</th>
									<th>Sur (calculé)</th>
									<th>Poids</th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								@foreach($tps as $tp)
									<tr>
										<td><a href="{{ action('TPsController@show', [$tp->id]) }}">{{ $tp->id }}</a> </td>
										<td>{{ $tp->nom }} </td>
										<td>{{ $tp->questions()->sum('sur_local')}} </td>
										<td>{{ $tp->poids }} </td>
										<td><a href="{{ action('TPsController@edit', [$tp->id]) }}" class="btn btn-info">Éditer</a></td>
										<td>
											{{ Form::open(array('action' => array('TPsController@destroy', $tp->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) }}
	                                        	<button type="submit" href="{{ URL::route('tps.destroy', $tp->id) }}" class="btn btn-danger btn-mini">Effacer</button>
	                                        {{ Form::close() }}   
	                                    </td>
										<td><a href="{{ action('TPsQuestionsController@index', [$tp->id]) }}" class="btn btn-info">Questions</a></td>
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