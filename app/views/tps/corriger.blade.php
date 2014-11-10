@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>{{{$classe->nom}}} / {{{$tp->nom}}} / {{{$etudiant->prenom}}} {{{$etudiant->nom}}}</h1>
			<p>sur: {{$tp->questions()->sum('sur_local')}}  vaut: {{{$tp->pivot->poids_local}}}
		</div>
	</div>
</section>

<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			{{ Form::open(['route'=> array('tps.doCorriger', $etudiant->id, $classe->id, $tp->id, $question->id), 'method' => 'PUT', 'class' => 'form-horizontal form-compact', 'role'=>'form']) }}
				@include('tps.corriger_subview')
				<div class="form-group">
					{{ Form::submit('Terminer', ['class' => 'btn btn-primary', 'name'=>'terminer']) }}
					@if($flagEtudiantPrecedent)
						{{ Form::submit('étudiant précédent', ['class' => 'btn btn-primary  col-sm-offset-1', 'name'=>'etudiantprecedent']) }}
					@endif
					@if($flagEtudiantSuivant)
						{{ Form::submit('étudiant suivant', ['class' => 'btn btn-primary', 'name'=>'etudiantsuivant']) }}
					@endif*/
						?>
					
				</div>
			{{ Form::close() }}
		</div>
	</section>
</div>
@stop