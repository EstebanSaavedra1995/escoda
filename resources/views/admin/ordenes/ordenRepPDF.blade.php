<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="font-size: 16px">
    {{-- {{ $tareas }} --}}
    <header>
        <table style="width: 100%; border-bottom-style: solid">
            {{-- border="1px solid black" border-collapse="collapse" --}}
            <tr>
                <td style="width: 30%">
                    <img src="https://i.postimg.cc/k43PSGWN/logo-escoda.jpg" alt="">
                </td>
                <td style="text-align: center">
                    Orden de Reparación
                </td>
                <td style="width: 30%">
                    Fecha: {{ $orden['Fecha'] }}
                </td>
            </tr>

            <tr>
                <td style="width: 30%">
                    &nbsp; {{ $orden['NroOR'] }}
                </td>
                <td style="">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cliente:
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
                Herramienta: {{$conjunto->CodPieza}} {{$conjunto->NombrePieza}} {{$conjunto->Medida}}
            </td>
        </tr>
    </table>

    <table style="width: 100%">
        <tr>
            <td>Número: .....</td>
            <td> Fecha Bajada: ..../..../....</td>
            <td> Fecha Reparacion: ..../..../....</td>
        </tr>

        <tr>
            <td></td>
            <td>Fecha Sacada: ..../..../....</td>
            <td></td>
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
        
        <tr>
            <td>1 - Limpieza</td>
            <td>4 - Calibración d interior....... d exterior.......</td>
            <td>7 - Pintado</td>
        </tr>

        <tr>
            <td>2 - Desarmado</td>
            <td>5 - Armado</td>
            <td>8 - Trazabilidad</td>
        </tr>

        <tr>
            <td>3 - Identificación de Piezas</td>
            <td>6 - Prueba de Funcionamiento</td>
            <td></td>
        </tr>

    </table>

    <br>
    <br>

    <table style="width: 100%; border: 1px solid black">
        <tr>
            <th style="border-bottom-style: solid">Despiece</th>
            <th style="border-bottom-style: solid">Nro OC</th>
            <th style="border-bottom-style: solid">Cant</th>
            <th style="border-bottom-style: solid">Estado</th>
            <th style="border-bottom-style: solid">Cambiado</th>
            <th style="border-bottom-style: solid">Reutilizado</th>

        </tr>
        @foreach ($gomas as $goma)
            <tr>
                <td style="border-bottom-style: dashed">{{ $goma->CodigoInterno}} - dI {{ $goma->DiametroInterior}} - dE {{ $goma->DiametroExterior}} - {{ $goma->Altura}}</td>
                <td style="border-bottom-style: dashed"></td>
                <td style="border-bottom-style: dashed"></td>
                <td style="border-bottom-style: dashed"></td>
                <td style="border-bottom-style: dashed" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" readonly value="Si" style="width: 20%; align: center"> <input type="text" readonly value="No" style="width: 20%; align: center"></td>
                <td style="border-bottom-style: dashed"></td>
            </tr>
        @endforeach
        
        @foreach ($art as $a)
            <tr>
                <td style="border-bottom-style: dashed">{{ $a->CodArticulo}} - {{ $a->Descripcion}}</td>
                <td style="border-bottom-style: dashed"></td>
                <td style="border-bottom-style: dashed"></td>
                <td style="border-bottom-style: dashed"></td>
                <td style="border-bottom-style: dashed" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" readonly value="Si" style="width: 20%; align: center"> <input type="text" readonly value="No" style="width: 20%; align: center"></td>
                <td style="border-bottom-style: dashed"></td>
            </tr>
        @endforeach
        
        @foreach ($piezas as $pieza)
        {{$pieza}}
            <tr>
                <td style="border-bottom-style: dashed">{{ $pieza->CodPieza}} - {{ $pieza->NombrePieza}} - {{ $pieza->Medida}}</td>
                <td style="border-bottom-style: dashed"></td>
                <td style="border-bottom-style: dashed"></td>
                <td style="border-bottom-style: dashed"></td>
                <td style="border-bottom-style: dashed" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" readonly value="Si" style="width: 20%; align: center"> <input type="text" readonly value="No" style="width: 20%; align: center"></td>
                <td style="border-bottom-style: dashed"></td>
            </tr>
        @endforeach
    </table>
    <br>

    <table style="width: 100%">
        <tr>
            <td>Diagnostico de la falla encontrada:</td>

            <td>&nbsp;</td>

            <td>
                <table border="solid" style="border-collapse: collapse;">
                    <tr>
                        <td colspan="5"  align="center">Contenido</td>
                    </tr>
                    <tr >
                        <td>&nbsp;Arena&nbsp;</td>
                        <td>&nbsp;Incru.&nbsp;</td>
                        <td>&nbsp;Corr.&nbsp;</td>
                        <td>&nbsp;P. Vis.&nbsp;</td>
                        <td>&nbsp;Abrs&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
        
    </table>
    <br>

    <table style="width: 100%; border: 1px solid black">
        <tr>
            <td>Documentos Adjuntos:</td>
        </tr>

        <tr>
            <td>Fotografias:</td>
        </tr>

        <tr>
            <td>Costos:</td>
        </tr>
    </table>
    <br>

    <table style="width: 100%">
        <tr>
            <td>Operario:</td>
        </tr>

        <tr>
            <td>Tiempo de Operación:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hs.</td>
            <td>Conforme Cliente:</td>
        </tr>
    </table>

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
