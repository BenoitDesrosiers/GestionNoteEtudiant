@extends('layout')
@section('content')

	<div class="container">
		<section class="section-padding">
			<div class="jumbotron text-left">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1> Liste des questions</h1>
						<a href="{{ action('QuestionsController@create') }}" class="btn btn-info">Créer une question</a>						
					</div>
					
					@if ($questions->isEmpty())
						<p>Aucune question de disponible!</p>
					@else
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Nom</th>
									<th>Enoncé</th>
									<th>Sur</th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								@foreach($questions as $question)
									<tr>
										<td><a href="{{ action('QuestionsController@show', [$question->id]) }}">{{ $question->id }}</a> </td>
										<td>{{ $question->nom }} </td>
										<td>{{ $question->enonce }} </td>
										<td>{{ $question->sur }} </td>
										<td><a href="{{ action('QuestionsController@edit', [$question->id]) }}" class="btn btn-info">Éditer</a></td>
										<td>
											{{ Form::open(array('action' => array('QuestionsController@destroy', $question->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) }}
	                                        	<button type="submit" href="{{ URL::route('questions.destroy', $question->id) }}" class="btn btn-danger btn-mini">Effacer</button>
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