@extends('layout')
@section('content')
	
	<div class="container-fluid">
		<section class="section-padding">
			<div class="jumbotron text-left">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1> Bienvenue dans le système de gestion de classes</h1>
						<a href="{{ action('ClassesController@index') }}" class="btn btn-info">Gestion des classes</a>	
						<a href="{{ action('TPsController@index') }}" class="btn btn-info">Gestion des travaus pratique (TPs)</a>						
											
					</div>
					
					
				</div>
			</div>
		</section>
	</div>
	
@stop