@extends('layout')
@section('content')

<section class="header section-padding">
	<div class="container">
		<div class="header-text">
			<h1>{{{$tp->nom}}}</h1>
			<p>sur: {{$tp->questions()->sum('sur_local')}}  vaut: {{{$tp->pivot->poids_local}}}
		</div>
	</div>
</section>

<div class="container">
	<section class="section-padding">
		<div class="jumbotron text-left">
			{{ Form::open(['route'=> array('tpsPassation.doRepondre', $etudiant_id, $classe_id, $tp->id ), 'method' => 'PUT', 'class' => 'form-horizontal form-compact', 'role'=>'form']) }}
				{{ Form::hidden('pageCourante', $pageCourante) }}
				
				@include('tpsPassation.repondre_subview')
				<div class="form-group">
					{{ Form::submit('Terminer', ['class' => 'btn btn-primary', 'name'=>'terminer']) }}
					@if($pagePrecedente <> null)
						{{ Form::submit('page '.$pagePrecedente, ['class' => 'btn btn-primary  col-sm-offset-1', 'name'=>'precedent']) }}
					
					@endif
					@if($pageSuivante <> null)
						{{ Form::submit('page '.$pageSuivante, ['class' => 'btn btn-primary'.($pagePrecedente==null?" col-sm-offset-2":""), 'name'=>'suivant']) }}
					@endif
						
					
				</div>
			{{ Form::close() }}
		</div>
	</section>
</div>
@stop