<div>
    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="container">
                <div class="row mb-2">
                    <label class=" col mr-2">Pieza</label>
                    {{-- <input type="text" list="piezasL">
                    <datalist id="piezasL" class="form-select">
                        @foreach ($piezas as $pieza)
                        <option value="{{ $pieza->CodPieza }}">
                            {{ $pieza->CodPieza }} -
                            {{ $pieza->NombrePieza }} -
                            {{ $pieza->Medida }}
                        </option>
                        @endforeach
                    </datalist> --}}
                    <select class=" col mr-2" name="piezas" id="piezas">
                        <option value="">Seleccione pieza</option>
                        @foreach ($piezas as $pieza)
                            <option value="{{ $pieza->CodPieza }}">
                                {{ $pieza->CodPieza }} -
                                {{ $pieza->NombrePieza }} -
                                {{ $pieza->Medida }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

        </div>
    </div>
</div>
