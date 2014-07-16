
<div class="form-group">
	{{ Form::label('nom', 'Nom:') }} 
	{{ Form::text('nom',null, ['class' => 'form-control']) }}
	{{ $errors->first('nom') }}
</div>
<div class="form-group">
	{{ Form::label('da', 'DA:') }} 
	{{ Form::text('da',null, ['class' => 'form-control']) }}
	{{ $errors->first('da') }}


