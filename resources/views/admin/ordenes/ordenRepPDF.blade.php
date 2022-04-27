<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="font-size: 20px">
    {{-- {{ $tareas }} --}}
    <header>
        <table style="width: 100%; border-bottom-style: solid">
            {{-- border="1px solid black" border-collapse="collapse" --}}
            <tr>
                <td style="width: 30%">
                    <img src="https://i.postimg.cc/k43PSGWN/logo-escoda.jpg" alt="">
                </td>
                <td style="text-align: center">
                    Orden de Construcción
                </td>
                <td style="width: 30%">
                    Fecha: {{ $orden['Fecha'] }}
                </td>
            </tr>

            <tr>
                <td style="width: 30%">
                    &nbsp; {{$orden['NroOR'] }}
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
                Pieza: 
            </td>
        </tr>

        <tr>
            <td>
                Cantidad: 
            </td>
        </tr>

    </table>
    <br>
    <table style="width: 100%">
        <tr>
            <td>
                Material: 
            </td>
        </tr>

        <tr>
            <td>
                Colada: 
            </td>
        </tr>

        <tr>
            <td>
                Longitud de Corte (mm):
            </td>
        </tr>

    </table>

    <br>
    <br>

    <table style="width: 100%; border: 1px solid black">
        <tr>
            <th style="border-bottom-style: solid">Tarea</th>
            <th style="border-bottom-style: solid">Màquina</th>
            <th style="border-bottom-style: solid">Operario</th>
            <th style="border-bottom-style: solid">Supervisor de Área</th>
            <th style="border-bottom-style: solid">Tiempo Estimado</th>

        </tr>
        {{-- @foreach ($tareas as $orden)
            <tr>
                <td style="border-bottom-style: dashed">{{ $orden['Renglon'] . ' ' . $orden['Tarea'] }}</td>
                <td style="border-bottom-style: dashed">{{ $orden['Maquina'] }}</td>
                <td style="border-bottom-style: dashed">{{ $orden['Operario'] }}</td>
                <td style="border-bottom-style: dashed">{{ $orden['Supervisor'] }}</td>
                <td style="border-bottom-style: dashed">{{ $orden['Horas'] }}</td>
            </tr>
        @endforeach --}}
    </table>

<br>

    <footer>
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
