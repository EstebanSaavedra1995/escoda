<div>
    <div class="card card-primary">
        <h1>Control de Pañol</h1>
        <div class="card-body">
            <section class="content">
                <div class="conteiner-fluid">
                    <div class="row">

                        <section class="col-lg-4 connectedSortable ui-sortable">
                            <div class="content">
                                <div class="row mb-2">
                                    <label for="herramienta" class="col-4">Herramienta:</label>
                                    <select class="form-control col" name="herramienta" id="">
                                        <option value=""></option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                    </select>
                                    {{-- <input type="text" class="form-control" name="material" readonly> --}}
                                </div>

                                <div class="row mb-2">
                                    <label for="operario" class="col-4">Operario:</label>
                                    <select class="form-control col" name="operario" id="">
                                        <option value=""></option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                    </select>
                                    {{-- <input type="text" class="form-control" name="material" readonly> --}}
                                </div>

                                <div class="row mb-2">
                                    <button class="btn btn-primary">Guardar</button>
                                    {{-- <input type="text" class="form-control" name="material" readonly> --}}
                                </div>
                            </div>


                        </section>

                        <section class="col-lg-8 connectedSortable ui-sortable">
                            <div class="conteiner-fluid">
                                <table class="table table-striped table-hover" id="tabla">
                                    {{-- table table-hover text-nowrap" --}}
                                    <thead>
                                        <tr class="">
                                            <td scope="col" class="table-primary">Herramienta</td>
                                            <td scope="col" class="table-primary">Operario</td>
                                            <td scope="col" class="table-primary">Fecha/Hora</td>
                                            <td scope="col" class="table-primary">Devuelto</td>
                                            <td scope="col" class="table-primary">Accion</td>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td>herramienta</td>
                                        <td>--------</td>
                                        <td>##/##/## ##:##</td>
                                        <td>si</td>
                                        <td>
                                            <button class="btn btn-primary">Devuelto</button>
                                            <button class="btn btn-primary">Perdida</button>
                                            <button class="btn btn-primary">Rotura</button>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>herramienta</td>
                                        <td>--------</td>
                                        <td>##/##/## ##:##</td>
                                        <td>no</td>
                                        <td>
                                            <button class="btn btn-primary">Devuelto</button>
                                            <button class="btn btn-primary">Perdida</button>
                                            <button class="btn btn-primary">Rotura</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>

            </section>


        </div>
    </div>
</div>
