//// añadir pack de pdf composer require barryvdh/laravel-dompdf
/// y service provider Después de actualizar Composer, agregue ServiceProvider a la matriz de proveedores en config / app.php

/* Barryvdh\DomPDF\ServiceProvider::class, Opcionalmente, puede usar la fachada para un código más corto. Agregue esto a sus fachadas:

'PDF' => Barryvdh\DomPDF\Facade::class, #Ejemplo */
//EVENTOS CHECK DE PIEZA/CONJUNTO
document.getElementById('ck1Mod').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario-modal'));
    fetch('/admin/listarpiezas', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {

            var conjunto = data['conjunto'];
            //var piezaDeConjunto = data['conjunto'];
            //console.log(conjunto[1]);
            var datos = "";
            datos += '<option value="0"> </option>';
            var select = document.getElementById('piezasMod');
            select.innerHTML = "<option></option>";
            conjunto.forEach(e => {

                datos += '<option value="' + e.CodPieza + '">';
                datos += e.CodPieza + " - " + e.NombrePieza + " - " + e.Medida;
                datos += '</option>';
            });
            data = [];
            document.getElementById('tipoTodo').value = 'conjunto';
            document.getElementById('tipoChicas').value = 'conjunto';
            document.getElementById('tipoGrandes').value = 'conjunto';
            select.innerHTML = datos;


        })
}, true)

document.getElementById('ck2Mod').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario-modal'));
    fetch('/admin/listarpiezas', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            //alert(data);


            var datos = "";
            var select = document.getElementById('piezasMod');
            select.innerHTML = "<option></option>";
            datos += '<option value="0"> </option>';
            data['piezas'].forEach(e => {

                datos += '<option value="' + e.CodPieza + '">';
                datos += e.CodPieza + " - " + e.NombrePieza + " - " + e.Medida;
                datos += '</option>';
            });
            data = [];
            document.getElementById('tipoTodo').value = 'pieza';
            document.getElementById('tipoChicas').value = 'pieza';
            document.getElementById('tipoGrandes').value = 'pieza';
            select.innerHTML = datos;

        })
}, true)

//Evento listar modal
document.getElementById('btnListarMod').addEventListener('click', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina
    $("#cargandoDiv").show();
    const datos = new FormData(document.getElementById('formulario-modal'));
    fetch('/admin/listartabla', {
        method: 'POST',
        body: datos,
        beforeSend: function () {
            console.log("espera");
        },
    })
        .then(res => res.json())
        .then(data => {
            //console.log(data);

            let datos = "";

            datos += `<thead>
                <tr>
                    <th scope="col">Nro. Egreso</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Pieza</th>
                    <th scope="col">Nro</th>
                    <th scope="col">Condición</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Intervención</th>
                    <th scope="col">Pozo</th>
                    <th scope="col">Orden Trabajo</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>`;

            var tabla = document.getElementById('tablaMod');
            //var ck1 = document.getElementById('ck1');
            var long = 0;
            data.forEach(e => {
                long++;
                datos += `<tr id="${e.id}" class="" onclick="">`;
                datos += `<input id="id${e.id}" type="text" value="${e.id}" class="tblId" hidden>`;
                datos += `<td scope="col" ><input id="NroE${e.id}" type="text" value="${e.NroEgreso}" class="oculto tblNroE" readonly></td>`;
                datos += `<td scope="col" ><input id="FechaE${e.id}" type="text" value="${e.Fecha}" class="oculto tblFechaE" readonly></td>`;
                datos += `<td scope="col" ><input id="Cod${e.id}" type="text" value="${e.CodPieza}" class="oculto tblCod" readonly></td>`;
                datos += `<td scope="col" ><input id="Numero${e.id}" type="text" value="${e.Numero}" class="oculto tblNumero" readonly></td>`;
                datos += `<td scope="col" ><input id="Condicion${e.id}" type="text" value="${e.Condicion}" class="oculto tblCondicion" readonly></td>`;
                datos += `<td scope="col" ><input id="Tipo${e.id}" type="text" value="${e.TipoEgreso}" class="oculto tblTipo" readonly></td>`;
                datos += `<td scope="col" ><input id="FechaI${e.id}" type="text" value="${e.FechaIntervencion}" class="oculto tblFechaI" readonly></td>`;
                datos += `<td scope="col" ><input id="Pozo${e.id}" type="text" value="${e.Pozo}" class="oculto tblPozo" readonly></td>`;
                datos += `<td scope="col" ><input id="NroOR${e.id}" type="text" value="${e.NroOR}" class="oculto tblNroOR" readonly></td>`;
                datos += `<td scope="col" >
                <button class="btn btn-primary mb-1" type="button"  onclick="modificar(${e.id});">Modificar</button>
                <button class="btn btn-danger" type="button"  onclick="borrar(${e.id});">Borrar</button>
                </td>`;
                datos += '</tr>';
            });
            var cantidad = document.getElementById('cantidadHtas');
            cantidad.innerText = 'Cantidad de Htas.: ' + long;
            tabla.innerHTML = datos;
        })
        .finally(() => {
            $("#cargandoDiv").hide();
        })
}, true)

//Modificar, guarda cambios en bd
document.getElementById('btnModificarModal').addEventListener('click', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina
    const datos = new FormData(document.getElementById('formulario-modalModificar'));
    fetch('/admin/listarmodificar', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            //console.log(data);
            swal("Modificado con Exito!", {
                icon: "success",
            });
        })
}, true)



function modificar(id) {
    //Activar el modal
    $('#modalModificar').modal('show');
    var NroE = document.getElementById('NroE' + id).value;
    var FechaE = document.getElementById('FechaE' + id).value;
    var Cod = document.getElementById('Cod' + id).value;
    var Numero = document.getElementById('Numero' + id).value;
    var Condicion = document.getElementById('Condicion' + id).value;
    var Tipo = document.getElementById('Tipo' + id).value;
    var FechaI = document.getElementById('FechaI' + id).value;
    var Pozo = document.getElementById('Pozo' + id).value;
    var NroOR = document.getElementById('NroOR' + id).value;

    document.getElementById('idMod').value = id;
    document.getElementById('nroEMod').value = NroE;
    document.getElementById('FechaEMod').value = fechaISO(FechaE);
    document.getElementById('condicionMod').value = Condicion;
    document.getElementById('tipoMod').value = Tipo;
    document.getElementById('FechaIMod').value = fechaISO(FechaI);
    document.getElementById('pozoMod').value = Pozo;
    document.getElementById('nroORMod').value = NroOR;


}

function fechaISO(fecha) {
    //convierte una fecha de dd/mm/yyyy a yyyy-mm-dd formato iso
    if (fecha != '-') {
        split = fecha.split('/');
        return split[2] + '-' + split[1] + '-' + split[0];
    } else {
        return '';
    }
}

function borrar(id) {
    swal({
        title: "Seguro desea eliminar?",
        /* text: "Once deleted, you will not be able to recover this imaginary file!", */
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                //Eliminar, borra en bd
                const datos = new FormData(document.getElementById('formulario-modalModificar'));
                datos.append('idBorrar', id);
                fetch('/admin/listareliminar', {
                    method: 'POST',
                    body: datos,
                })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        swal("El registro ha sido eliminado!", {
                            icon: "success",
                        });
                    });

                let parent = document.getElementById(id).parentNode;
                parent.removeChild(document.getElementById(id));
            } else {
                /* swal("Your imaginary file is safe!"); */
            }
        });
}
function borrarEtiqueta(id) {
    swal({
        title: "Seguro desea eliminar?",
        /* text: "Once deleted, you will not be able to recover this imaginary file!", */
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                let parent = document.getElementById('et' + id).parentNode;
                parent.removeChild(document.getElementById('et' + id));
            } else {
                /* swal("Your imaginary file is safe!"); */
            }
        });
}

//COLAPPSE DE LISTAR POR
function collapse() {
    var select = document.getElementById('listarPor').value;
    var nro = document.getElementById('collNroEgreso');
    var fecha = document.getElementById('collFecha');
    var pieza = document.getElementById('collPieza');
    switch (select) {
        case 'nroDeEgreso':
            $("#collNroEgreso").show();
            $("#collFecha").hide();
            $("#collPieza").hide();

            break;
        case 'fecha':

            $("#collFecha").show();
            $("#collNroEgreso").hide();
            $("#collPieza").hide();

            break;
        case 'pieza':

            $("#collPieza").show();
            $("#collNroEgreso").hide();
            $("#collFecha").hide();
            break;

        default:
            break;
    }


}
//carga la tabla del modal de etiquetas
function etiqueta() {
    var tabla = document.getElementById('tablaEtiqueta');
    tabla.innerHTML = '';
    $('#modalEtiquetas').modal('show');
    var codigos = document.getElementsByClassName('tblId');
    var val = [];
    for (i = 0; i < codigos.length; i++) {
        let e = {
            id: codigos[i].value,
        };
        val.push(e);
        //console.log(codigos[i].value);
    }
    val = JSON.stringify(val);
    //console.log(val);
    const datos = new FormData(document.getElementById('formulario-modal'));
    datos.append('codigos', val);

    fetch('/admin/listartablaEtiqueta', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            //console.log(data);
            let datos = "";
            datos += `<table class="table table-bordered table-striped table-Etiqueta">`;
            datos += `<thead>
            <tr>
            <th scope="col">Herramienta</th>
            <th scope="col">Medida</th>
            <th scope="col">Número</th>
            <th scope="col">Condición</th>
            <th scope="col">Tamaño</th>
            <th scope="col">Acción</th>
            </tr>
            </thead>`;
            datos += `<tbody>`;

            var tabla = document.getElementById('tablaEtiqueta');
            var etChica = document.getElementById('etiquetasChicas');
            var etChicasTodo = document.getElementById('etChicas');
            var etGrandes = document.getElementById('etiquetasGrandes');
            etGrandes.value = '';
            var etGrandesTodo = document.getElementById('etGrandes');
            etGrandesTodo.value = '';
            let str = '';
            data.forEach(e => {
                str += `${e.trazabilidad.id}/`;
                datos += `<tr id="et${e.trazabilidad.id}" class="" onclick="">`;
                datos += `<input id="idEt${e.trazabilidad.id}" type="text" value="${e.trazabilidad.id}" class="tblId" hidden>`;
                datos += `<td scope="col" ><input id="nombreEt${e.trazabilidad.id}" type="text" value="${e.pieza.CodPieza} - ${e.pieza.NombrePieza}" class="oculto tblNombre" readonly></td>`;
                datos += `<td scope="col" ><input id="MedidaEt${e.trazabilidad.id}" type="text" value="${e.pieza.Medida}" class="oculto tblMedida" readonly></td>`;
                datos += `<td scope="col" ><input id="NumeroEt${e.trazabilidad.id}" type="text" value="${e.trazabilidad.Numero}" class="oculto tblNumero" readonly></td>`;
                datos += `<td scope="col" ><input id="CondicionEt${e.trazabilidad.id}" type="text" value="${e.trazabilidad.Condicion}" class="oculto tblCondicion" readonly></td>`;
                datos += `<td scope="col" >
                <select name="tamaño" id="tamañoEt${e.trazabilidad.id}" class="tblTamaño" onchange="cargarEtiquetas(${e.trazabilidad.id});">
                <option value="chica">Chica</option>
                <option value="grande">Grande</option>
                </select></td>`;
                datos += `<td scope="col" >
                <button class="btn btn-danger" type="button"  onclick="borrarEtiqueta(${e.trazabilidad.id});">Borrar</button>
                </td>`;
                datos += '</tr>';
            });
            datos += `</tbody>`;
            datos += `</table>`;
            etChica.value = str;
            etChicasTodo.value = str;
            //console.log(str);
            tabla.innerHTML = datos;
        })
}

function cargarEtiquetas(id) {
    var codigos = document.getElementsByClassName('tblId');
    var tamaño = document.getElementById('tamañoEt' + id).value;
    var etChicas = document.getElementById('etiquetasChicas');
    var etGrandes = document.getElementById('etiquetasGrandes');
    var etChicasTodo = document.getElementById('etChicas');
    var etGrandesTodo = document.getElementById('etGrandes');
    var str = '';
    if (tamaño == 'grande') {
        etGrandes.value += `${id}/`;
        etGrandesTodo.value += `${id}/`;
        str = etChicas.value;
        str = str.replace(id + '/', "");
        etChicas.value = str;
        etChicasTodo.value = str;
    }
    if (tamaño == 'chica') {
        etChicas.value += `${id}/`;
        str = etGrandes.value;
        str = str.replace(id + '/', "");
        etGrandes.value = str;
        etGrandesTodo.value = str;
    }
    /* console.log('chicas ' + etChicas.value);
    console.log('grandes ' + etGrandes.value); */
}

//Evento listar modal
document.getElementById('btnExel').addEventListener('click', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina
    const datos = new FormData(document.getElementById('formulario-modal'));
    fetch('/admin/exel', {
        method: 'GET',
        //body: datos,
        //responseType: "blob",
    })
        //.then(res => res.json())
        .then(data => {
            console.log('ok');
            const url = window.URL.createObjectURL(new Blob([data]));
            console.log(url);
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", "mat.xls");
            document.body.appendChild(link);
            link.click();
        })
}, true)





