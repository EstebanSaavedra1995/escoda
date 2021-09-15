<div>
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" wire:click="llenarTabla('materiales')">Materiales</button>
            <button class="btn btn-primary" wire:click="llenarTabla('gomas')">Gomas</button>
            <button class="btn btn-primary" wire:click="llenarTabla('articulos')">Artículos Generales</button>
            <button class="btn btn-primary" wire:click="llenarTabla('piezas')">Piezas</button>
        </div>

        <div class="card body">
            <input type="text" wire:model="buscar" class="form-control"
                placeholder="Ingrese codigo o descripción del elemento">

            @switch($tipo)
                @case('materiales')
                    <table class="table table-striped table-scroll1 mt-2">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Stock</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos as $material)
                                <tr>
                                    <td>{{ $material->CodigoMaterial }} </td>
                                    <td>{{ $material->Material }} </td>
                                    <td>{{ $material->Stock }} </td>
                                    <td>
                                        <button class="btn btn-success mr-1"
                                            wire:click="cargarDetalles('{{ $material->CodigoMaterial }}')">Info</button>
                                        <button class="btn btn-primary">Egreso</button>
                                        <button class="btn btn-primary">Ingreso</button>
                                        <button class="btn btn-primary">Movimientos</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table table-striped table-scroll1 mt-2">
                        <thead>
                            <tr>
                                <th>Colada</th>
                                <th>Stock</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($detalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->Colada }} </td>
                                    <td>{{ $detalle->Stock }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @break
                @case('gomas')
                    <table class="table table-striped mt-2">
                        <thead>
                            <tr>
                                <th>Código Interno</th>
                                <th>Ø Interior</th>
                                <th>Ø Exterior</th>
                                <th>Altura</th>
                                <th>Código Goma</th>
                                <th>Stock</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos as $goma)
                                <tr>
                                    <td>{{ $goma->CodigoInterno }} </td>
                                    <td>{{ $goma->DiametroInterior }} </td>
                                    <td>{{ $goma->DiametroExterior }} </td>
                                    <td>{{ $goma->Altura }} </td>
                                    <td>{{ $goma->CodigoGoma }} </td>
                                    <td>{{ $goma->Stock }} </td>
                                    <td>
                                        <button class="btn btn-primary">Egreso</button>
                                        <button class="btn btn-primary">Ingreso</button>
                                        <button class="btn btn-primary">Movimientos</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @break
                @case('articulos')
                    <table class="table table-striped mt-2">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Stock</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos as $articulo)
                                <tr>
                                    <td>{{ $articulo->CodArticulo }} </td>
                                    <td>{{ $articulo->Descripcion }} </td>
                                    <td>{{ $articulo->Stock }} </td>
                                    <td>
                                        <button class="btn btn-primary">Egreso</button>
                                        <button class="btn btn-primary">Ingreso</button>
                                        <button class="btn btn-primary">Movimientos</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @break
                @case('piezas')
                    <table class="table table-striped table-scroll1 mt-2">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Stock</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos as $pieza)
                                <tr>
                                    <td>{{ $pieza->CodPieza }} </td>
                                    <td>{{ $pieza->NombrePieza }} </td>
                                    <td>{{ $pieza->Stock }} </td>
                                    <td>
                                        <button class="btn btn-success mr-1"
                                            wire:click="cargarDetalles('{{ $pieza->CodPieza }}')">Info</button>
                                        {{-- <button class="btn btn-primary">Egreso</button> --}}
                                        <a href="{{ route('stockEgreso', [$pieza->id,'4']) }}" class="btn btn-primary">Egreso</a> 
                                        <button class="btn btn-primary">Ingreso</button>
                                        <button class="btn btn-primary">Movimientos</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    <table class="table table-striped table-scroll1 mt-2">
                        <thead>
                            <tr>
                                <th>Nro. Orden Construcción</th>
                                <th>Stock</th>
                            </tr>
                        </thead>

                        <tbody>


                            @foreach ($detalles as $detalle)
                                @if ($detalle->Stock > '0')
                                    <tr>
                                        <td>{{ $detalle->NroOC }} </td>
                                        <td>{{ $detalle->Stock }} </td>
                                    </tr>

                                @endif
                            @endforeach

                        </tbody>
                    </table>

                @break
                @default '';

            @endswitch




        </div>
    </div>
</div>
