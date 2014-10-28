@if ($lignes->isEmpty())
	<p>Aucun travail pratique disponible!</p>
@else
	<div class="table-responsive">	{{-- voir http://getbootstrap.com/css/#tables-responsive --}}
		<table class="table">
			<thead>
				<tr>
					<th>Nom</th>
					<th class="text-right">Sur (calculé)</th>
					<th class="text-right">Poids</th>
					<th class="text-right @if($belongsToId == 0) {{ "text-muted" }} @endif" >Poids local</th>
					<th> </th>
				</tr>
			</thead>
			<tbody>
				<?php 	
					$total_sur = 0; 
					$poids = 0; 
					$poids_local = 0; 
				?> 
				
				@foreach($lignes as $tp)
				
						<?php 
							$poids += $tp->poids;
							if($belongsToId <>0) {$poids_local += $tp->pivot->poids_local;}
							$unTotalSur = $tp->questions()->sum('sur_local');
							$total_sur += $unTotalSur;
						?> 	
									
					<tr>
						<td><a href="{{ action('TPsController@show', [$tp->id]) }}">{{ $tp->nom }}</a> </td>
						<td class="text-right">{{ $tp->questions()->sum('sur_local')}} </td>
						<td class="text-right">{{ $tp->poids }} </td>										
						<td class="text-right">@if($belongsToId <> 0) {{ $tp->pivot->poids_local }}  @endif </td>
						<td><a href="{{ action('TPsController@edit', [$tp->id]) }}" class="btn btn-info">Éditer</a></td>
						<td>
						
						{{ Form::open(array('action' => array('TPsController@destroy', $tp->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) }}
							<button type="submit" href="{{ URL::route('tps.destroy', $tp->id) }}" class="btn btn-danger btn-mini">Effacer</button>
						{{ Form::close() }}
						</td>
						<td><a href="{{ action('QuestionsController@index', ['belongsToId' => $tp->id]) }}" class="btn btn-info">Questions</a></td>						
						
					</tr>
					
				@endforeach
				<tr>
					<td>total:</td>
					<td class="text-right"> {{ $total_sur }}</td>					
					<td class="text-right"> {{ $poids }}</td>
					<td class="text-right"> @if($belongsToId <> 0) {{ $poids_local }}   @endif</td>
				</tr>	
			</tbody>
		</table>
	</div>
@endif