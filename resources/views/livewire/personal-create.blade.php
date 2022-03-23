<div>
    <div class="container">
        <div class="row mb-2">
            <label class=" col mr-2">Apellido y Nombre :</label>
            <input type="text" class=" col mr-2" wire:model="nombre">
            @error('nombre')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>

        <div class="row mb-2">
            <label class=" col mr-2">Cargo :</label>
            <select name="" id="" class=" col mr-2" wire:model="cargo">
                <option value=""></option>
                @foreach ($cargos as $cargoE)
                    <option value="{{$cargoE->Cargo}}">{{$cargoE->Cargo}}</option>
                @endforeach
            </select>
        </div>

        <div class="row mb-2">
            <label class=" col mr-2">Fecha de Ingreso :</label>
            <input type="date" class=" col mr-2" wire:model="fecha">
        </div>

        <div class="row mb-2">
            <label class=" col mr-2">Estado :</label>
            <select name="" id="" class=" col mr-2" wire:model="estado">
                <option value=""></option>
                <option value="A">A</option>
                <option value="B">B</option>
            </select>
        </div>

        <div class="row mb-2">
            <button class="btn btn-primary" wire:click="save">Guardar</button>
        </div>
    </div>
    
    
</div>
