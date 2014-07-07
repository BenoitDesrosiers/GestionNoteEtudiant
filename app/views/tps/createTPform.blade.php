
<div class="form-group">
	{{ Form::label('numero', 'Numero:') }} 
	{{ Form::text('numero',null, ['class' => 'form-control']) }}
	{{ $errors->first('numero') }}
</div>
<div class="form-group">
	{{ Form::label('nom', 'Nom:') }} 
	{{ Form::text('nom',null, ['class' => 'form-control']) }}
	{{ $errors->first('nom') }}
</div>
<div class="form-group">
	{{ Form::label('sur', 'Sur:') }} 
	{{ Form::text('sur',null, ['class' => 'form-control']) }}
	{{ $errors->first('sur') }}
	
</div>
<div class="form-group">
	{{ Form::label('poids', 'Poids:') }} 
	{{ Form::text('poids',null, ['class' => 'form-control']) }}
	{{ $errors->first('poids') }}
	
</div>

<div class="form-group">
	{{ Form::submit('Créer', ['class' => 'btn btn-primary'])}}
</div>