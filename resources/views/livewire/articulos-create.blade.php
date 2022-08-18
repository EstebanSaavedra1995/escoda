<div>
    <select name="tipo" wire:model="tipo" class="">
        <option value=""></option>
        <option value="a">Artículo</option>
        <option value="g">Goma</option>
        <option value="m">Material</option>
    </select>

    @switch($tipo)
        @case('a')
            @if (session('info'))
                <strong>
                    <div class="alert-success">{{ session('info') }}</div>
                </strong>
            @endif

            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => ['datos.articulos.store']]) !!}
                    <div class="container">
                        <input type="text" name="tipo" value="a" hidden>
                        <div class="row mb-2">
                            <label class=" col mr-2">Codigo de Artículo :</label>
                            <input type="text" class=" col mr-2" name="codigo" maxlength="15">
                            @error('codigo')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Descripcion :</label>
                            <input type="text" class=" col mr-2" name="descripcion" maxlength="50">
                            @error('descripcion')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Stock :</label>
                            <input type="number" class=" col mr-2" name="stock" value="0">
                            @error('stock')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                    </div>
                    {!! Form::submit('Crear Artículo', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}

                    {{-- @livewire('personal-create') --}}
                </div>
            </div>
        @break

        @case('g')
            @if (session('info'))
                <strong>
                    <div class="alert-success">{{ session('info') }}</div>
                </strong>
            @endif

            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => ['datos.articulos.store']]) !!}
                    <div class="container">
                        <input type="text" name="tipo" value="g" hidden>
                        <div class="row mb-2">
                            <label class=" col mr-2">Codigo Interno :</label>
                            <input type="text" class=" col mr-2" name="codInterno" maxlength="15">
                            @error('codInterno')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Diametro Interior :</label>
                            <input type="number" class=" col mr-2" name="diaInt">
                            @error('diaInt')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Diametro Exterior :</label>
                            <input type="number" class=" col mr-2" name="diaExt">
                            @error('diaExt')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Altura :</label>
                            <input type="number" class=" col mr-2" name="altura">
                            @error('altura')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Stock :</label>
                            <input type="number" class=" col mr-2" name="stock" value="0">
                            @error('stock')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Codigo de Goma :</label>
                            <input type="text" class=" col mr-2" name="codGoma" maxlength="25">
                            @error('codGoma')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                    </div>
                    {!! Form::submit('Crear Goma', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}

                </div>
            </div>
        @break

        @case('m')
            @if (session('info'))
                <strong>
                    <div class="alert-success">{{ session('info') }}</div>
                </strong>
            @endif

            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => ['datos.articulos.store']]) !!}
                    <div class="container">
                        <input type="text" name="tipo" value="m" hidden>
                        <div class="row mb-2">
                            <label class=" col mr-2">Codigo de Material :</label>
                            <input type="text" class=" col mr-2" name="codigo" maxlength="50">
                            @error('codigo')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Material :</label>
                            <input type="text" class=" col mr-2" name="material" maxlength="20">
                            @error('material')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Dimension :</label>
                            <input type="text" class=" col mr-2" name="dim" maxlength="10">
                            @error('dim')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Calidad :</label>
                            <input type="text" class=" col mr-2" name="calidad" maxlength="10">
                            @error('calidad')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Stock :</label>
                            <input type="number" class=" col mr-2" name="stock" value="0">
                            @error('stock')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Stock Maximo :</label>
                            <input type="number" class=" col mr-2" name="stockMax" value="0">
                            @error('stockMax')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>


                    </div>
                    {!! Form::submit('Crear Material', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}

                </div>
            </div>
        @break

        @default
    @endswitch
</div>
