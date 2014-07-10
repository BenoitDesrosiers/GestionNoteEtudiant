@extends('layout')
@section('content')



	<div class="container">
		<section class="section-padding">
			<div class="jumbotron text-left">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1> Liste des questions pour le TP {{ $tp->id . ' ' . $tp->nom }}</h1>
						<a href="{{ action('TPsQuestionsController@create', $tp->id) }}" class="btn btn-info">Créer une question</a>	
						<a href="{{ action('TPsQuestionsController@connectQuestion', $tp->id) }}" class="btn btn-info">Associer un question</a>						
											
					</div>
					
					@if ($questions->isEmpty())
						<p>Aucun question de disponible!</p>
					@else
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Nom</th>
									<th>Énoncé</th>
									<th>Sur</th>
									<th>Sur local</th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								<?php $total = 0; $total_local = 0; ?> 
								@foreach($questions as $question)
									<?php $total += $question->sur;
										  $total_local += $question->pivot->sur_local?> 
									<tr>
										<td><a href="{{ action('TPsQuestionsController@show', [$tp->id, $question->id]) }}">{{ $question->id }}</a> </td>
										<td>{{ $question->nom }} </td>
										<td>{{ $question->enonce }} </td>
										<td>{{ $question->sur }} </td>										
										<td>{{ $question->pivot->sur_local }} </td>
										<td><a href="{{ action('TPsQuestionsController@edit', [$tp->id, $question->id]) }}" class="btn btn-info">Éditer</a></td>
	                                    <td><a href="{{ action('TPsQuestionsController@disconnectQuestion', [$tp->id, $question->id]) }}" class="btn btn-info">Déconnecter</a></td>
										<td><a href="{{ action('TPsQuestionsController@index',$tp->id) }}" class="btn btn-info">balist to do</a></td>
										<td>
											{{ Form::open(array('action' => array('TPsQuestionsController@destroy',$tp->id, $question->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain? Elle sera détachée de tous les TPs auquel elle est associée')) }}
	                                        	<button type="submit" href="{{ URL::route('tps.questions.destroy', $tp->id, $question->id) }}" class="btn btn-danger btn-mini">Effacer</button>
	                                        {{ Form::close() }}   
	                                    </td>
									</tr>
								@endforeach
								<tr>
									<td> </td>
									<td> </td>
									<td>total:</td>
									<td> {{ $total }} </td>
									<td> {{ $total_local }} </td>
									
								</tr>	
							</tbody>
								
						</table>
					@endif
				</div>
			</div>
		</section>
	</div>

@stop