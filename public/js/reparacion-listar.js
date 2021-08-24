let ordenesConstruccion = [];

document.getElementById('lista').addEventListener('change', function (e) {

    let divtabla = document.getElementById('divtabla');
    divtabla.innerHTML = '';
    let divtablatareas = document.getElementById('divtablatareas');
    divtablatareas.innerHTML = '';
    let buscar = document.getElementById('buscar');
    buscar.disabled = false;
    /* ocultarExcels(); */
    let valor = document.getElementById('lista').value;
    if (valor == 0) {
        filtroNroOrden();
    } else if (valor == 1) {
        filtroFecha();
    } else {
        filtroHerramienta();
    }

})

const filtroNroOrden = () => {
    let filtro = document.getElementById('filtro');
    filtro.className = "row mb-2";
    let input = `<label class=" col mr-2">Nro orden de construcción:</label>`;
    input += `<input type="number" name= "nroorden" id="nroorden" class="form-control col mr-2">`
    filtro.innerHTML = input;


}

const filtroFecha = () => {
    let hoy = formatDate();

    let filtro = document.getElementById('filtro');
    filtro.className = "row mb-2";
    let inputs = `<label class=" col mr-2">Desde</label>`;
    inputs += `<input type="date" value="${hoy}" name="fecha1" id="fecha1" class="form-control col mr-2">`
    inputs += `<label class=" col mr-2">Hasta</label>`;
    inputs += `<input type="date" value="${hoy}" name="fecha2" id="fecha2" class="form-control col mr-2">`
    filtro.innerHTML = inputs;


}
const filtroHerramienta = () => {
    let filtro = document.getElementById('filtro');
    filtro.className = "row mb-2";

    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/reparacion/listarherramientas', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {

            let comboHerramienta = document.createElement("select");
            comboHerramienta.className = "col mr-2";
            comboHerramienta.name = "herramienta";
            comboHerramienta.id = "herramienta";

            data.forEach(herramienta => {
                let option = document.createElement('option');
                option.innerHTML = `${herramienta.CodPieza} - ${herramienta.NombrePieza} - ${herramienta.Medida}`;
                option.value = herramienta.CodPieza;
                comboHerramienta.appendChild(option);
            })
            filtro.innerHTML = `<label class="col mr-2">Pieza:</label>`;
            filtro.appendChild(comboHerramienta);
        })
}

const listarOrdenes = () => {
    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/reparacion/listarordenes', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            if (data[0] === 'ordenes') {
                realizarTablaOrden(data[1]);
            } else if (data[0] === 'fechas') {
                realizarTablaFecha(data[1]);
            } else {
                realizarTablaHerramienta(data[1]);
            }
        })
}



const formatDate = () => {
    var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}
const formatoFecha = (fecha) => {

    day = fecha[4] + fecha[5];
    month = fecha[2] + fecha[3];
    year = fecha[0] + fecha[1];
    return [day, month, year].join('/');
}

const listarTareas = (oc) => {
    const datos = new FormData(document.getElementById('formulario'));
    datos.append('oc', oc);
    fetch('/admin/listarcancelar/detalles', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            divtablatareas = document.getElementById('divtablatareas');
            let tabla = `<table class="table-striped table table-bordered table-scroll3">`;
            tabla += `<thead>`;
            tabla += `<tr>`;
            tabla += `<th scope="col">Tareas</th>`;
            tabla += `<th scope="col">Máquina</th>`;
            tabla += `<th scope="col">Operario</th>`;
            tabla += `<th scope="col">Supervisor</th>`;
            tabla += `<th scope="col">Horas</th>`;
            tabla += `</tr>`;
            tabla += `</thead>`;
            tabla += `<tbody>`;
            //console.log(data);
            data.forEach(tarea => {
                tabla += `<tr>`;
                tabla += `<td>${tarea.Tarea}</td>`;
                tabla += `<td>${tarea.Maquina}</td>`;
                tabla += `<td>${tarea.Operario}</td>`;
                tabla += `<td>${tarea.Supervisor}</td>`;
                tabla += `<td>${tarea.Horas}</td>`;
                tabla += `</tr>`;
            })
            tabla += `</tbody>`;
            tabla += `</table>`;
            divtablatareas.innerHTML = tabla;
        })
}

const cancelarTarea = (oc) => {
    swal({
        title: `¿Desea cancelar la orden N°${oc}?`,
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                const datos = new FormData(document.getElementById('formulario'));
                datos.append('numoc', oc);
                fetch('/admin/listarcancelar/cancelar', {
                    method: 'POST',
                    body: datos,
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data === 'ok') {
                            swal({
                                title: `¡Se ha dado de baja la orden de construcción N°${oc}!`,
                                icon: "success",
                                button: "Aceptar",
                            });
                            setTimeout(function () {
                                window.location.href = "http://escoda.test/admin/listarcancelar";
                            }, 1500)
                        } else {
                            swal({
                                title: "¡Ocurrió un fallo, no se pudo dar de baja!",
                                icon: "warning",
                                button: "Aceptar",
                            });
                        }
                    })
            }
        });
}

const excel = () => {
    console.log('Excel');
}

const realizarTablaOrden = (array) => {
    let divtabla = document.getElementById('divtabla');
    let tabla = `<table class="table-striped table table-bordered table-scroll3" id = "tablaExcel">`;
    tabla += `<thead>`;
    tabla += `<tr>`;
    tabla += `<th scope="col">Nro reparación</th>`;
    tabla += `<th scope="col">Fecha</th>`;
    tabla += `<th scope="col">Conjunto</th>`;
    tabla += `<th scope="col">Nro</th>`;
    tabla += `<th scope="col">Operario</th>`;
    tabla += `<th scope="col">Supervisor</th>`;
    tabla += `<th scope="col">Acciones</th>`;
    tabla += `</tr>`;
    tabla += `</thead>`;
    tabla += `<tbody>`;
    array.forEach(orden => {
        tabla += `<tr>`;
        tabla += `<td style="width: 15px">${orden.NroOR}</td>`;
        tabla += `<td style="width: 15px">${formatoFecha(orden.Fecha)}</td>`;
        tabla += `<td>${orden.CodPieza} - ${orden.NombrePieza} - ${orden.Medida}</td>`;
        tabla += `<td style="width: 15px">${orden.NroCjto}</td>`;
        tabla += `<td>${orden.NroLegajo} - ${orden.ApellidoNombre}</td>`;
        tabla += `<td style="width: 20px">Supervisor </td>`;
        tabla += `<td><button type="button" class="btn btn-info" onclick= "infoOR('${orden.NroOR}');">Info</button> `;
        tabla += `<button type="button" class="btn btn-warning" id="modificarId" onclick= "modificarOR('${orden.NroOR}');">Mod</button> `;
        tabla += ` <button type="button" class="btn btn-secondary">Imp</button>`;
        tabla += `</tr>`;

    });
    tabla += `</tbody>`;
    tabla += `</table>`;
    /* numeroReporteExcel(); */
    tabla += `<tr><td> <button class="btn btn-success" type ="button" onclick="exportTableToExcel('tablaExcel', 'ordenensamble')">Excel</button></td></tr>`;
    divtabla.innerHTML = tabla;
}
const realizarTablaFecha = (array) => {
    let divtabla = document.getElementById('divtabla');
    let tabla = `<table class="table-striped table table-bordered table-scroll3" id = "tablaExcel">`;
    tabla += `<thead>`;
    tabla += `<tr>`;
    tabla += `<th scope="col">Fecha</th>`;
    tabla += `<th scope="col">Nro reparación</th>`;
    tabla += `<th scope="col">Conjunto</th>`;
    tabla += `<th scope="col">Nro</th>`;
    tabla += `<th scope="col">Operario</th>`;
    tabla += `<th scope="col">Supervisor</th>`;
    tabla += `<th scope="col">Acciones</th>`;
    tabla += `</tr>`;
    tabla += `</thead>`;
    tabla += `<tbody>`;
    array.forEach(orden => {
        tabla += `<tr>`;
        tabla += `<td style="width: 15px">${formatoFecha(orden.Fecha)}</td>`;
        tabla += `<td style="width: 15px">${orden.NroOR}</td>`;
        tabla += `<td>${orden.CodPieza} - ${orden.NombrePieza} - ${orden.Medida}</td>`;
        tabla += `<td style="width: 15px">${orden.NroCjto}</td>`;
        tabla += `<td>${orden.NroLegajo} - ${orden.ApellidoNombre}</td>`;
        tabla += `<td style="width: 20px">Supervisor </td>`;
        tabla += `<td><button type="button" class="btn btn-info" onclick= "infoOR('${orden.NroOR}');">Info</button> `;
        tabla += `<button type="button" class="btn btn-warning" id="modificarId" onclick= "modificarOR('${orden.NroOR}');">Mod</button> `;
        tabla += ` <button type="button" class="btn btn-secondary">Imp</button>`;
        tabla += `</tr>`;

    });
    tabla += `</tbody>`;
    tabla += `</table>`;
    /* fechaReporteExcel(); */
    tabla += `<tr><td> <button class="btn btn-success" type ="button" onclick="exportTableToExcel('tablaExcel', 'ordenensamble')">Excel</button></td></tr>`;
    divtabla.innerHTML = tabla;
}

const realizarTablaHerramienta = (array) => {
    let divtabla = document.getElementById('divtabla');
    let tabla = `<table class="table-striped table table-bordered table-scroll3" id = "tablaExcel">`;
    tabla += `<thead>`;
    tabla += `<tr>`;
    tabla += `<th scope="col">Conjunto</th>`;
    tabla += `<th scope="col">Fecha</th>`;
    tabla += `<th scope="col">Nro reparación</th>`;
    tabla += `<th scope="col">Nro</th>`;
    tabla += `<th scope="col">Operario</th>`;
    tabla += `<th scope="col">Supervisor</th>`;
    tabla += `<th scope="col">Acciones</th>`;
    tabla += `</tr>`;
    tabla += `</thead>`;
    tabla += `<tbody>`;
    array.forEach(orden => {
        tabla += `<tr>`;
        tabla += `<td>${orden.CodPieza} - ${orden.NombrePieza} - ${orden.Medida}</td>`;
        tabla += `<td style="width: 15px">${formatoFecha(orden.Fecha)}</td>`;
        tabla += `<td style="width: 15px">${orden.NroOR}</td>`;
        tabla += `<td style="width: 15px">${orden.NroCjto}</td>`;
        tabla += `<td>${orden.NroLegajo} - ${orden.ApellidoNombre}</td>`;
        tabla += `<td style="width: 20px">Supervisor </td>`;
        tabla += `<td><button type="button" class="btn btn-info" onclick= "infoOR('${orden.NroOR}');">Info</button> `;
        tabla += `<button type="button" class="btn btn-warning" id="modificarId" onclick= "modificarOR('${orden.NroOR}');">Mod</button> `;
        tabla += ` <button type="button" class="btn btn-secondary">Imp</button>`;
        tabla += `</tr>`;

    });
    tabla += `</tbody>`;
    tabla += `</table>`;
    /* piezaReporteExcel(); */
    tabla += `<tr><td> <button class="btn btn-success" type ="button" onclick="exportTableToExcel('tablaExcel', 'ordenensamble')">Excel</button></td></tr>`;
    divtabla.innerHTML = tabla;
}

const infoOR = (nro) => {

    const datos = new FormData(document.getElementById('formulario'));
    datos.append('nro', nro);
    fetch('/admin/reparacion/listardetalles', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data[0], data[1], data[2]);
            armarTabla(data[0], data[1], data[2]);
        })
}
const armarTabla = (articulos, gomas, piezas) => {
    let divtablatareas = document.getElementById('divtablatareas');
    let cadena = '';
    cadena += `<table class="table-striped table table-bordered table-scroll4">`;
    cadena += `<thead>`;
    cadena += `<tr>`;
    cadena += `<th scope="col">Tipo</th>`;
    cadena += `<th scope="col">Piezas</th>`;
    cadena += `<th scope="col">Nro OC</th>`;
    cadena += `<th scope="col">Cantidad</th>`;
    cadena += `</tr>`;
    cadena += `</thead>`;
    cadena += `<tbody>`;
    if (gomas.length > 0) {
        gomas.forEach(goma => {
            cadena += `<tr>`;
            cadena += `<td>Goma</td>`;
            cadena += `<td>${goma.CodigoInterno} - ${goma.CodigoGoma} - ${goma.DiametroInterior} - ${goma.DiametroExterior}</td>`;
            cadena += `<td>-</td>`;
            cadena += `<td>${goma.Cantidad}</td>`;
            cadena += `</tr>`;
        })
    }


    if (articulos.length > 0) {
        articulos.forEach(articulo => {
            cadena += `<tr>`;
            cadena += `<td>Artículos grales</td>`;
            cadena += `<td>${articulo.CodArticulo} - ${articulo.Descripcion}</td>`;
            cadena += `<td>-</td>`;
            cadena += `<td>${articulo.Cantidad}</td>`;
            cadena += `</tr>`;
        })
    }
    if (piezas.length > 0) {
        piezas.forEach(pieza => {
            cadena += `<tr>`;
            cadena += `<td>Pieza</td>`;
            cadena += `<td>${pieza.codPieza} - ${pieza.NombrePieza}</td>`;
            cadena += `<td>${pieza.NroOC}</td>`;
            cadena += `<td>${pieza.Cantidad}</td>`;
            cadena += `</tr>`;
        })
    }
    cadena += `</tbody>`;
    cadena += `</table>`;
    divtablatareas.innerHTML = cadena;
}

let $modal = $('#modificarId');
function modificarOR(or) {


    const datos2 = new FormData(document.getElementById('formulario2'));
    datos2.append('or', or);
    fetch('/admin/reparacion/modificarorden', {
        method: 'POST',
        body: datos2,
    })
        .then(res => res.json())
        .then(data => {
            let herramienta = document.getElementById('herramienta');
            let fecha = document.getElementById('fecha');
            let ordenes = document.getElementById('ordenes');
            let numero = document.getElementById('numero');
            fecha.value = formatoFecha(data.orden.Fecha);
            herramienta.value = `${data.conjunto.CodPieza} - ${data.conjunto.NombrePieza}`
            ordenes.value = data.orden.NroOR;
            numero.value = data.orden.NroCjto;
            armarTabla2(data.conjuntoArticulos, data.piezasConjunto, data.conjuntoGomas);
        })



    $('#modalModificar').modal('show');
}
$modal.on('click', modificarOR);
const armarTabla2 = (articulos, piezas, gomas) => {
    let divtablatareas = document.getElementById('divtablatareas2');
    let cadena = '';
    cadena += `<table class="table-striped table table-bordered table-scroll4">`;
    cadena += `<thead>`;
    cadena += `<tr>`;
    cadena += `<th scope="col">Tipo</th>`;
    cadena += `<th scope="col">Código</th>`;
    cadena += `<th scope="col">Descripción</th>`;
    cadena += `<th scope="col">Cambiar</th>`;
    cadena += `<th scope="col">Cantidad</th>`;
    cadena += `<th scope="col">Orden</th>`;
    cadena += `</tr>`;
    cadena += `</thead>`;
    cadena += `<tbody>`;
    if (gomas.length > 0) {
        gomas.forEach(goma => {
            cadena += `<tr>`;
            cadena += `<td>Goma</td>`;
            cadena += `<td>${goma.CodigoInterno}</td>`;
            cadena += `<td>${goma.CodigoGoma} - ${goma.DiametroInterior} - ${goma.DiametroExterior}</td>`;
            cadena += `<td><select name = "combo${goma.CodigoGoma}">`;
            cadena += `<option value = "1" selected> Si </option>`;
            cadena += `<option value = "0"> No </option>`;
            cadena += `</select></td>`;
            cadena += `<td style="width: 50px"> <input style="width: 50px" type ="number" value = "${goma.Cantidad}" ></td>`;
            cadena += `<td><button type="button" class ="btn btn-secondary" disabled="true">Orden</button></td>`
            cadena += `</tr>`;
        })
    }


    if (articulos.length > 0) {
        articulos.forEach(articulo => {
            cadena += `<tr>`;
            cadena += `<td>Artículos grales</td>`;
            cadena += `<td>${articulo.CodArticulo}</td>`;
            cadena += `<td>${articulo.Descripcion}</td>`;
            cadena += `<td><select> name = "combo${articulo.CodArticulo}"`;
            cadena += `<option value = "1" selected> Si </option>`;
            cadena += `<option value = "0"> No </option>`;
            cadena += `</select></td>`;
            cadena += `<td style="width: 50px"> <input style="width: 50px" type ="number" value = "${articulo.Cantidad}"></td>`;
            cadena += `<td><button type="button" class ="btn btn-secondary" disabled="true">Orden</button></td>`
            cadena += `</tr>`;
        })
    }
    if (piezas.length > 0) {
        piezas.forEach(pieza => {
            cadena += `<tr>`;
            cadena += `<td>Pieza</td>`;
            cadena += `<td>${pieza.codigoPieza}</td>`;
            cadena += `<td>${pieza.NombrePieza}</td>`;
            cadena += `<td><select> name = "combo${pieza.codigoPieza}"`;
            cadena += `<option value = "1" selected> Si </option>`;
            cadena += `<option value = "0"> No </option>`;
            cadena += `</select></td>`;
            cadena += `<td style="width: 50px"> <input style="width: 50px" type ="number" value = "${pieza.Cantidad}"></td>`;
            cadena += `<td><button type="button" class ="btn btn-info" onclick = "mostrarOC('${pieza.codigoPieza}');">Orden</button></td>`
            cadena += `</tr>`;
        })
    }

    cadena += `</tbody>`;
    cadena += `</table>`;
    cadena += `<button type="button" class ="btn btn-success" onclick = "agregarOrden();">Guardar</button> `
    cadena += `<button type="button" class ="btn btn-danger" onclick = "cancelarOrden();">Cancelar orden pendiente</button>`;
    divtablatareas.innerHTML = cadena;
}
const mostrarOC = (codigoPieza) => {
    lateral = document.getElementById('lateral');
    lateral2 = document.getElementById('lateral2');
    lateral3 = document.getElementById('lateral3');
    lateral4 = document.getElementById('lateral4');

    lateral.innerHTML = '';
    lateral2.innerHTML = '';
    lateral3.innerHTML = '';
    lateral4.innerHTML = '';


    /*  let select = '<label class ="col-2" for= "comboOrdenes"> Orden de construcción N°: </label> <select class="col-2 mr-2" name = "comboOrdenes" id = "comboOrdenes">'; */
    let select = '<label class="col" for= "comboOrdenes"> Orden de construcción N°: </label> <select class="col" name = "comboOrdenes" id = "comboOrdenes">';
    const datos = new FormData(document.getElementById('formulario'));
    datos.append('codigoPieza', codigoPieza);
    fetch('/admin/reparacion/ordenpieza', {
        method: 'POST',
        body: datos,
    })

        .then(res => res.json())
        .then(data => {
            data.forEach(oc => {
                select += `<option value = "${oc.NroOC}">${oc.NroOC}</option>`;
            })
            select += `</select>`;
            let cantidad = `<label class="col" for= "cantidad">Cantidad por OC: </label> <input min="1" class = "col" type = "number" value ="1" name= "cantidad" id= "cantidad">`;
            let botones = `<button type="button" class ="btn btn-success" onclick = "agregarOC();">Agregar</button> `;

            let arregloOrdenes = devuelvoArreglo(codigoPieza);
            if (arregloOrdenes.length > 0) {
                let tabla = '';
                tabla += `<table class="table-striped table table-bordered table-scroll3">`;
                tabla += `<thead>`;
                tabla += `<tr>`;
                tabla += `<th scope="col">NroOC</th>`;
                tabla += `<th scope="col">Cantidad</th>`;
                tabla += `<th scope="col">Acción</th>`;
                tabla += `</tr>`;
                tabla += `</thead>`;
                tabla += `<tbody id= "idbody">`;
                arregloOrdenes.forEach(orden => {
                    tabla += `<tr id = "${orden.orden}">`;
                    tabla += `<td class = "orden">${orden.orden}</td>`;
                    tabla += `<td class = "cantidad">${orden.cantidad}</td>`;
                    tabla += `<td><button type="button" class ="btn btn-danger" onclick = "sacarOC('${orden.orden}');">Sacar</button></td>`;
                    tabla += `</tr>`;

                })
                tabla += `</tbody>`;
                tabla += `</table>`;
                tabla += `<button type="button" class ="btn btn-success" onclick = "guardarOC('${codigoPieza}');">Guardar ordenes</button>`;
                lateral.innerHTML = select;
                lateral2.innerHTML = cantidad;
                lateral3.innerHTML = botones;
                lateral4.innerHTML = tabla;

            } else {
                let tabla = '';
                tabla += `<table class="table-striped table table-bordered table-scroll3">`;
                tabla += `<thead>`;
                tabla += `<tr>`;
                tabla += `<th scope="col">NroOC</th>`;
                tabla += `<th scope="col">Cantidad</th>`;
                tabla += `<th scope="col">Acción</th>`;
                tabla += `</tr>`;
                tabla += `</thead>`;
                tabla += `<tbody id= "idbody">`;
                tabla += `</tbody>`;
                tabla += `</table>`;
                tabla += `<button type="button" class ="btn btn-success" onclick = "guardarOC('${codigoPieza}');">Guardar ordenes</button>`;
                lateral.innerHTML = select;
                lateral2.innerHTML = cantidad;
                lateral3.innerHTML = botones;
                lateral4.innerHTML = tabla;
            }
        })
}
const devuelvoArreglo = (pieza) => {
    let index = -1;
    for (let i = 0; i < ordenesConstruccion.length; i++) {
        if (ordenesConstruccion[i].id === pieza) {
            index = i;
        }
    }
    if (index != -1) {
        return ordenesConstruccion[index].ordenes;
    } else {
        return [];
    }
}
const agregarOC = () => {
    let body = document.getElementById('idbody');
    let comboOrdenes = document.getElementById('comboOrdenes');
    let cantidad = document.getElementById('cantidad');

    let tr = document.createElement('tr');
    let td = document.createElement('td');
    let td2 = document.createElement('td');
    let td3 = document.createElement('td');

    td.innerHTML = comboOrdenes.value;
    td.className = 'orden';

    td2.innerHTML = cantidad.value;
    td2.className = 'cantidad';
    td3.innerHTML = `<button type="button" class ="btn btn-danger" onclick = "sacarOC('${comboOrdenes.value}');">Sacar</button>`;
    tr.appendChild(td);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tr.id = comboOrdenes.value;

    let existe = document.getElementById(comboOrdenes.value);

    if (cantidad.value == 0) {
        swal({
            title: "¡La cantidad debe ser distinta de 0!",
            icon: "warning",
            button: "Aceptar",
        });

    } else if (cantidad.value == '') {
        swal({
            title: "¡Debe ingresar una cantidad!",
            icon: "warning",
            button: "Aceptar",
        });

    } else if (comboOrdenes.value == '') {
        swal({
            title: "¡Esta pieza no tiene orden de construcción!",
            icon: "warning",
            button: "Aceptar",
        });

    } else if (existe != null) {
        swal({
            title: "¡Ya se ha cargado la orden de construcción!",
            icon: "warning",
            button: "Aceptar",
        });
    } else {
        body.appendChild(tr);
    }
}
const guardarOC = (pieza) => {

    let cantidades = document.getElementsByClassName('cantidad');
    let ordenes = document.getElementsByClassName('orden');
    let ordenesCantidad = [];
    for (let i = 0; i < cantidades.length; i++) {
        objeto = {
            orden: ordenes[i].innerHTML,
            cantidad: cantidades[i].innerHTML
        }
        ordenesCantidad.push(objeto);
    }

    obj = {
        id: pieza,
        ordenes: ordenesCantidad
    }
    let index = -1;
    for (let i = 0; i < ordenesConstruccion.length; i++) {
        if (ordenesConstruccion[i].id === pieza) {
            index = i;
        }
    }
    if (index == -1) {
        ordenesConstruccion.push(obj);
    } else {
        ordenesConstruccion[index].ordenes = ordenesCantidad;
        console.log('Reemplazando ordenes y cantidades');
    }



    console.log(ordenesConstruccion, index);
}
const cancelarOrden = () => {
    let combo = document.getElementById('ordenes');
    let nroOrden = combo.value;
    swal({
        title: `¿Desea cancelar la orden de reparación N° ${nroOrden}?`,
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        dangerMode: true,
    })
        .then((willAdd) => {
            if (willAdd) {
                enviarCancelarOrden(nroOrden);
            }
        });
}
/* const piezaReporteExcel = () => {
    let divPieza = document.getElementById('divPieza').style.visibility = "visible";
    let divFecha = document.getElementById('divFecha').style.visibility = "hidden";
    let divNumero = document.getElementById('divNumero').style.visibility = "hidden";

    let piezaExcel = document.getElementById('piezaExcel');
    let pieza = document.getElementById('pieza');
    piezaExcel.value = pieza.value;
}
const fechaReporteExcel = () => {
    let divPieza = document.getElementById('divPieza').style.visibility = "hidden";
    let divFecha = document.getElementById('divFecha').style.visibility = "visible";
    let divNumero = document.getElementById('divNumero').style.visibility = "hidden";

    let fecha1Excel = document.getElementById('fecha1Excel');
    let fecha2Excel = document.getElementById('fecha2Excel');
    fecha1Excel.value = document.getElementById('fecha1').value;
    fecha2Excel.value = document.getElementById('fecha2').value;

}
const numeroReporteExcel = () => {
    let divPieza = document.getElementById('divPieza').style.visibility = "hidden";
    let divFecha = document.getElementById('divFecha').style.visibility = "hidden";
    let divNumero = document.getElementById('divNumero').style.visibility = "visible";

    let numeroExcel = document.getElementById('numeroExcel');
    numeroExcel.value = document.getElementById('nroorden').value;
    //pasarle el valor del numero de orden
}

const ocultarExcels = () => {
    let divPieza = document.getElementById('divPieza').style.visibility = "hidden";
    let divFecha = document.getElementById('divFecha').style.visibility = "hidden";
    let divNumero = document.getElementById('divNumero').style.visibility = "hidden";
} */
function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename ? filename + '.xls' : 'excel_data.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;
        /*         tabla +=`<tr><td> <button class="btn btn-success" type ="button" onclick="exportTableToExcel('tablaExcel', 'ordenensamble')">Excel</button></td></tr>`; */
        //triggering the function
        downloadLink.click();
    }
}