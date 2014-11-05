@if (empty($lignes))
	<p>Aucun travail pratique disponible!</p>
@else
	<div class="table-responsive">	{{-- voir http://getbootstrap.com/css/#tables-responsive --}}
		<table class="table">
			<thead>
				<tr>
					<th>Classe</th>
					<th>Nom</th>
					<th class="text-right">Sur (calculé)</th>
					<th class="text-right">Poids</th>
					<th class="text-right">Poids local</th>
					<th> </th>
				</tr>
			</thead>
			<tbody>
				<?php 	
					$total_sur = 0; 
					$poids = 0; 
					$poids_local = 0; 
					$ancienNomClasse = "";
				?> 
				@foreach($lignes as $classeNom => $tps)
				@foreach($tps as $tp)
				
						<?php 
							$poids += $tp->poids;
							if(!$tp->classes->isempty()) {$poids_local += $tp->pivot->poids_local;}								
							$unTotalSur = $tp->questions()->sum('sur_local');
							$total_sur += $unTotalSur;
						?> 	
									
					<tr @if($ancienNomClasse <> $classeNom) {{'class ="success"'}} @endif>
						<td>@if($ancienNomClasse <> $classeNom) {{{$classeNom}}} @endif</td>
					
						<td><a href="{{ action('TPsController@show', [$tp->id]) }}">{{ $tp->nom }}</a> </td>
						<td class="text-right">{{ $tp->questions()->sum('sur_local')}} </td>
						<td class="text-right">{{ $tp->poids }} </td>										
						<td class="text-right">@if(!$tp->classes->isempty()) {{ $tp->pivot->poids_local }} @endif </td>
						<td><a href="{{ action('TPsController@edit', [$tp->id]) }}" class="btn btn-info">Éditer</a></td>
						<td>
						{{ Form::open(array('action' => array('TPsController@destroy', $tp->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) }}
							<button type="submit" href="{{ route('tps.destroy', $tp->id) }}" class="btn btn-danger btn-mini">Effacer</button>
						{{ Form::close() }}
						</td>
						<td><a href="{{ action('QuestionsController@index', ['belongsToId' => $tp->id]) }}" class="btn btn-info">Questions</a></td>	
						<td><a href="{{ route('tps.format', [$tp->id]) }}" class="btn btn-info">Format</a></td>	
											
						<td><a href="{{ route('tps.distribuer',  [$tp->id]) }}" class="btn btn-info">Distribuer</a></td>						
												
					</tr>
					<?php $ancienNomClasse = $classeNom; ?>
				@endforeach	
				@endforeach
				<tr>
					<td>total:</td>
					<td class="text-right"> {{ $total_sur }}</td>					
					<td class="text-right"> {{ $poids }}</td>
					<td class="text-right"> </td>
				</tr>	
			</tbody>
		</table>
	</div>
@endif