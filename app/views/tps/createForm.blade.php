
<div class="form-group">
	{{ Form::label('nom', 'Nom:') }} 
	{{ Form::text('nom',null, ['class' => 'form-control']) }}
	{{ $errors->first('nom') }}
</div>

<div class="form-group">
	{{ Form::label('poids', 'Poids:') }} 
	{{ Form::text('poids',null, ['class' => 'form-control']) }}
	{{ $errors->first('poids') }}
	
</div>
