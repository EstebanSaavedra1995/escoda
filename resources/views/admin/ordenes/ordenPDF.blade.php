<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="font-size: 12px">

    <h1>ORDEN PDF</h1>
    <table style="width: 100%">
        <tr>
            <th>Tarea</th>
            <th>Màquina</th>
            <th>Operario</th>
            <th>Supervisor de Área</th>
            <th>Tiempo Estimado</th>

        </tr>
        @foreach ($ordenes as $orden)
            <tr>
                <td style="border-bottom-style: dashed">{{ $orden['Renglon'] . ' ' . $orden['Tarea'] }}</td>
                <td style="border-bottom-style: dashed">{{ $orden['Maquina'] }}</td>
                <td style="border-bottom-style: dashed">{{ $orden['Operario'] }}</td>
                <td style="border-bottom-style: dashed">{{ $orden['Supervisor'] }}</td>
                <td style="border-bottom-style: dashed">{{ $orden['Horas'] }}</td>
            </tr>
        @endforeach
    </table>
    <table style="width: 100%">
        <tr>
            <th>Preparado por</th>
            <th>Revisado por</th>
            <th>Aprobado por</th>
        </tr>
        <tr>
            <td style="text-align: center">Tu vieja</td>
            <td style="text-align: center">Tu vieja</td>
            <td style="text-align: center">Tu vieja</td>
        </tr>

        <tr><td colspan="3"><b>Nota: </b>Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic doloribus molestiae blanditiis iusto optio similique excepturi corrupti nam, amet voluptates? Autem repudiandae dolore possimus architecto ad, ut sequi quas natus?</td></tr>
    </table>


</body>

</html>
