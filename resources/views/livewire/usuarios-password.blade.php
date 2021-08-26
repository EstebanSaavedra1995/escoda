<div>
    {!! Form::label('password', 'Contraseña') !!}
    <input type="text" wire:model="contraseña" class="form-control" placeholder="Ingrese la contraseña del usuario" >
        {!! Form::text('password', null, ['class' => 'form-control', 'wire:model' => 'password','hidden']) !!}
        @error('password')
            <small class="text-danger">
                {{$message}}
            </small>
        @enderror
</div>
