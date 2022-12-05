<div>
    <div class="card card-primary">
        <h1>Control de Pañol</h1>
        <div class="card-body">
            <section class="content">
                <div class="conteiner-fluid">
                    <div class="row">

                        <section class="col-6 connectedSortable ui-sortable">
                            <div class="container-fluid">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <th class="table-primary">Código</th>
                                        <th class="table-primary">Descripción</th>
                                        <th class="table-primary">Tipo</th>
                                        <th class="table-primary">Inserto</th>
                                        <th class="table-primary">Sentido</th>
                                        <th class="table-primary">Medida</th>
                                        <th class="table-primary">Stock</th>
                                        <th class="table-primary">Estado</th>
                                        <th class="table-primary"></th>
                                    </thead>
                                    <tbody>
                                        @foreach ($herramientas as $herramienta)
                                            <tr>
                                                <td>{{ $herramienta->codigo }}</td>
                                                <td>{{ $herramienta->descripcion }}</td>
                                                <td>{{ $herramienta->tipo }}</td>
                                                <td>{{ $herramienta->inserto }}</td>
                                                <td>{{ $herramienta->sentido }}</td>
                                                <td>{{ $herramienta->medida }}</td>
                                                <td>{{ $herramienta->stock }}</td>
                                                <td>{{ $herramienta->estado }}</td>
                                                <td>
                                                    @if ($herramienta->stock > 0)
                                                        <form action="{{ route('panol.prestar', $herramienta->id) }}"
                                                            method="get">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-primary">Prestar</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>


                        </section>

                        <section class="col-6 connectedSortable ui-sortable">
                            <div class="container-fluid">
                                <table class="table table-bordered table-hover" id="tabla">
                                    {{-- table table-hover text-nowrap" --}}
                                    <thead>
                                        <tr class="">
                                            <th scope="col" class="table-primary">Herramienta</td>
                                            <th scope="col" class="table-primary">Operario</td>
                                            <th scope="col" class="table-primary">Fecha/Hora</td>
                                            
                                            <th scope="col" class="table-primary">Accion</td>
                                        </tr>
                                    </thead>
                                    @foreach ($tablaPanol as $item)
                                        <tr>
                                            <td>{{$item["herramienta"]->descripcion}}</td>
                                            <td>{{$item["operario"]->name}}</td>
                                            <td>{{$item["panol"]->fechaSalida}}</td>
                                            
                                            <td>
                                                <button class="btn btn-primary" wire:click="devuelto({{$item["herramienta"]}},{{$item["panol"]->id}})">Devuelto</button>
                                                <button class="btn btn-primary" wire:click="perdida({{$item["herramienta"]}},{{$item["panol"]->id}})">Perdida</button>
                                                <button class="btn btn-primary" wire:click="rotura({{$item["herramienta"]}},{{$item["panol"]->id}})">Rotura</button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                        </section>
                    </div>
                </div>

            </section>


        </div>
    </div>
</div>
