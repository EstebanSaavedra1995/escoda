<div>
    <div class="card">
        <div class="card-header">
            <h2>Registro de Egresos</h2>
        </div>
    
        <div class="card-body">
            <h3>Código: {{$pieza->CodPieza}} </h3>
            <h3>Pieza: {{$pieza->NombrePieza}} </h3>
            <h3>Medida: {{$pieza->Medida}} </h3>
            <h3>Stock: {{$pieza->Stock}} </h3>
            <div class="container">
                <div class="row">
                    <h2 class="col">Cantidad de Egreso: </h2>
                    <input type="number" class="col mr-2">
                    <button class="btn btn-primary" class="col">Calcular</button>
                </div>
    
                <div class="row mt-2">
                    <h2 class="col">Motivo</h2>
                    <select name="" id="" class="col">
    
                    </select>
                </div>
    
                <div class="row mt-5" align="center">
                    <h3 class="col">Stock Actual</h3>
                    <h3 class="col"></h3>
                    <h3 class="col">Egreso</h3>
                    <h3 class="col"></h3>
                    <h3 class="col">Stock Resultado</h3>
                </div>
    
                <div class="row " align="center">
                    <h2 class="col">{{$pieza->Stock}}</h2>
                    <h2 class="col">-</h2>
                    <h2 class="col">20</h2>
                    <h2 class="col">=</h2>
                    <h2 class="col">1</h2>
                </div>
            </div>
        </div>
    </div>
</div>
