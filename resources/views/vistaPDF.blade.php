<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> --}}
    {{-- <link href="css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}

    {{-- <style type="text/css">
        thead:before,
        thead:after {
            display: none;
        }

        tbody:before,
        tbody:after {
            display: none;
        }

    </style> --}}
    <link rel="stylesheet" href="{{ asset('css/PDFStyles.css') }}">
    <title>Document</title>
</head>

<body>
    {{-- @foreach ($arrayDatos as $dato)
        
    {{$dato['pieza']}}<br>
    @endforeach --}}
    {{-- grande es 10% y 20% fontsize 20px y 30 px --}}
    @foreach ($arrayDatos as $datos)
        @if ($datos['tamaño'] == 'grande')

            <table class="" border="1" width="100%" style="border-collapse:collapse; ">
                <tr>
                    <td height="10%" style="font-size:20px;">
                        {{ $date = date('d/m/y') }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        ESCODA
                    </td>
                </tr>
                <tr>
                    <td height="20%" style="font-size:30px; text-align: left">
                        {{-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {{ $datos['trazabilidad']->CodPieza }} - {{$datos['pieza']->NombrePieza}}<br> --}}
                        <p align="center">{{ $datos['trazabilidad']->CodPieza }} -
                            {{ $datos['pieza']->NombrePieza }}
                        </p>

                        Medida: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        s<br>

                        Número: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $datos['trazabilidad']->Numero }}<br>

                        Condición: &nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $datos['trazabilidad']->Condicion }}
                    </td>
                </tr>
            </table>
            <br>


        @else

            <table class="" border="1" width="100%" style="border-collapse:collapse; ">
                <tr>
                    <td height="5%" style="font-size:15px;">
                        {{ $date = date('d/m/y') }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        ESCODA
                    </td>
                </tr>
                <tr>
                    <td height="10%" style="font-size:18px; text-align: left">

                        <p align="center">{{ $datos['trazabilidad']->CodPieza }} -
                            {{ $datos['pieza']->NombrePieza }}
                        </p>

                        Medida: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        s<br>

                        Número: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $datos['trazabilidad']->Numero }}<br>

                        Condición: &nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $datos['trazabilidad']->Condicion }}
                    </td>
                </tr>
            </table>
            <br>

        @endif
    @endforeach

</body>

</html>
