
<div class="form-group">
	{{ Form::label('nom', 'Nom:') }} 
	{{ Form::text('nom',null, ['class' => 'form-control']) }}
	{{ $errors->first('nom') }}
</div>
<div class="form-group">
	{{ Form::label('enonce', 'Énoncé:') }} 
	{{ Form::text('enonce',null, ['class' => 'form-control']) }}
	{{ $errors->first('enonce') }}
</div><div class="form-group">
	{{ Form::label('tag', 'Tag:') }} 
	{{ Form::text('tag',null, ['class' => 'form-control']) }}
	{{ $errors->first('tag') }}
</div>
<div class="form-group">
	{{ Form::label('sur', 'Sur:') }} 
	{{ Form::text('sur',null, ['class' => 'form-control']) }}
	{{ $errors->first('sur') }}
	
</div>

<div class="form-group">
	{{ Form::submit('Créer', ['class' => 'btn btn-primary'])}}
</div>