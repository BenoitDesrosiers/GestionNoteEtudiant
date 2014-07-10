@extends('layout')
@section('content')

	{{-- affiche tous les questions et permet de les connecter au tp courante --}}


	<div class="container">
		<section class="section-padding">
			<div class="jumbotron text-left">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1> Liste des questions disponibles</h1>
					</div>
					@if ($tps->isEmpty())
						<p>Aucune question disponible!</p>
					@else
						{{ Form::open(['action'=>array('TPsQuestionsController@doConnectQuestion', $tp->id), 'method' => 'POST', 'class' => 'form']) }}
					
						<div class="form-group">
							{{ Form::submit('Appliquer', ['class' => 'btn btn-primary']) }}
						</div>
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Associé</th>
									<th>Nom</th>
									<th>Énoncé</th>
									<th>Sur</th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								@foreach($questions as $question)
									<?php $trouve = false; ?> 
								
									<tr>
										<td><a href="{{ action('TPsQuestionsController@show', [$tp->id, $question->id]) }}">{{ $question->id }}</a> </td>
										<td>@if ($question->tps->contains($tp)) 
												<?php $trouve = true; ?>
											@endif
											{{ Form::checkbox('selectionTP[]', $question->id, $trouve ) }}
										</td>
										<td>{{ $question->nom }} </td>
										<td>{{ $question->enonce }} </td>
										<td>{{ $question->sur }} </td>
										<td>{{ $question->poids }} </td>
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