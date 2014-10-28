@if ($lignes->isEmpty())
	<p>Aucune etudiant de disponible!</p>
@else
<div class="table-responsive">	{{-- voir http://getbootstrap.com/css/#tables-responsive --}}
	<table class="table">
		<thead>
			<tr>
				<th>Nom</th>
				<th>da</th>
				<th> </th>
				<th> </th>
				
			</tr>
		</thead>
		<tbody>
		@foreach($lignes as $etudiant)
		<tr>
			<td><a href="{{ action('EtudiantsController@show', [$etudiant->id]) }}">{{ $etudiant->nom }} </a></td>
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
</div>
@endif
