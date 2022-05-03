<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="font-size: 18px">
    {{-- {{ $tareas }} --}}
    {{-- <header style="position: fixed;
    top: 0cm;
    left: 0cm;
    right: 0cm;
    height: 3cm;"> --}}
    <header>
        <table style="width: 100%; border-bottom-style: solid">
            {{-- border="1px solid black" border-collapse="collapse" --}}
            <tr>
                <td style="width: 30%">
                    <img src="https://i.postimg.cc/k43PSGWN/logo-escoda.jpg" alt="">
                </td>
                <td style="text-align: center">
                    Orden de Ensamble
                </td>
                <td style="width: 30%">
                    Fecha: {{ $orden['Fecha'] }}
                </td>
            </tr>

            <tr>
                <td style="width: 30%">
                    &nbsp; {{ $orden['NroOE'] }}
                </td>
                <td style="text-align: center">

                </td>
                <td style="width: 30%">

                </td>
            </tr>
        </table>
    </header>
    <br>
    <table style="width: 100%">
        <tr>
            <td>
                Herramienta: {{$pieza->NombrePieza}}
            </td>
        </tr>

        <tr>
            <td>
                Numero: {{$orden->NroCjto}}
            </td>
        </tr>

    </table>
    <br>
    <br>
    <table style="width: 100%">
        <tr>
            <td>
                Pasos a Seguir:
            </td>
        </tr>

    </table>

    <br>

    <table style="width: 100%">
        <tr>
            <td>
                1 - Listado de Piezas
            </td>
        </tr>

    </table>
    <br>

    <table style="width: 100%; border: 1px solid black">
        <tr>
            <th style="border-bottom-style: solid">Codigo</th>
            <th style="border-bottom-style: solid">Descripción</th>
            <th style="border-bottom-style: solid">Nro OC</th>
            <th style="border-bottom-style: solid">Cantidad</th>

        </tr>
        @foreach ($resultado as $resu)
            <tr>

                @switch($resu['tipo'])
                    @case('articulo')
                    <td style="border-bottom-style: dashed">{{ $resu['art']->CodArticulo }}</td>
                    <td style="border-bottom-style: dashed">{{ $resu['art']->Descripcion }}</td>
                    <td style="border-bottom-style: dashed">{{ $resu['detalle']->OC }}</td>
                    <td style="border-bottom-style: dashed">{{ $resu['detalle']->Cantidad }}</td>
                    @break

                    @case('goma')
                    <td style="border-bottom-style: dashed">{{ $resu['art']->CodigoGoma }}</td>
                    <td style="border-bottom-style: dashed">Di {{ $resu['art']->DiametroInterior }} - De {{ $resu['art']->DiametroExterior }}</td>
                    <td style="border-bottom-style: dashed">{{ $resu['detalle']->OC }}</td>
                    <td style="border-bottom-style: dashed">{{ $resu['detalle']->Cantidad }}</td>
                    @break

                    @case('pieza')
                        <td style="border-bottom-style: dashed">{{ $resu['art']->CodPieza }}</td>
                        <td style="border-bottom-style: dashed">{{ $resu['art']->NombrePieza }}</td>
                        <td style="border-bottom-style: dashed">{{ $resu['detalle']->OC }}</td>
                        <td style="border-bottom-style: dashed">{{ $resu['detalle']->Cantidad }}</td>
                    @break

                    @default <td></td>
                @endswitch
            </tr>
        @endforeach
    </table>

    <br>

    <table style="width: 100%">
        <tr>
            <td>
                2 - Armado
            </td>
        </tr>

    </table>
    <br>

    <table style="width: 100%">
        <tr>
            <td>
                3 - Prueba de Funcionamiento
            </td>
        </tr>

    </table>
    <br>

    <table style="width: 100%">
        <tr>
            <td>
                4 - Pintado
            </td>
        </tr>

    </table>
    <br>

    <table style="width: 100%">
        <tr>
            <td>
                5 - Trazabilidad
            </td>
        </tr>

    </table>
    <br>

    <table style="width: 100%">
        <tr>
            <td>
                Operario:
            </td>
        </tr>

        <tr>
            <td>
                Supervisado:
            </td>
        </tr>

    </table>
    <br>

    <footer style="position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;">
        <table style="width: 100%">
            <tr>
                <th>Preparado por</th>
                <th>Revisado por</th>
                <th>Aprobado por</th>
            </tr>
            <tr>
                <td style="text-align: center">......................</td>
                <td style="text-align: center">......................</td>
                <td style="text-align: center">......................</td>
            </tr>

            <tr>
                <td colspan="3"><b>Nota: </b></td>
            </tr>
        </table>
    </footer>
</body>

</html>
