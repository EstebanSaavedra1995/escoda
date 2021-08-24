let ordenesConstruccion = [];



document.getElementById('ordenes').addEventListener('change', function (e) {
    let divtablatareas = document.getElementById('divtablatareas');
    divtablatareas.innerHTML = '';
    const datos = new FormData(document.getElementById('formulario'));
    let combo = document.getElementById('ordenes');
    let nroOrden = combo[this.selectedIndex].innerHTML;
    datos.append('nroOrden', nroOrden);
    lateral = document.getElementById('lateral');
    lateral2 = document.getElementById('lateral2');
    lateral3 = document.getElementById('lateral3');
    lateral4 = document.getElementById('lateral4');

    lateral.innerHTML = '';
    lateral2.innerHTML = '';
    lateral3.innerHTML = '';
    lateral4.innerHTML = '';
    fetch('/admin/ensamble/ordenpendiente', {
        method: 'POST',
        body: datos,
    })

        .then(res => res.json())
        .then(data => {
            console.log(data);
               let herramienta = document.getElementById('herramienta');
               let fecha = document.getElementById('fecha');
               let numero = document.getElementById('numero');
               fecha.value = formatoFecha(data.ordenPendiente.fecha);
               herramienta.value = `${data.conjunto.CodPieza} - ${data.conjunto.NombrePieza}`
               numero.value = data.ordenPendiente.NroCjto;
               armarTabla(data.conjuntoArticulos, data.piezasConjunto, data.conjuntoGomas);
        })

}, true)

const armarTabla = (articulos, piezas, gomas) => {
    let divtablatareas = document.getElementById('divtablatareas');
    let conjunto = document.getElementById('ordenes').value;
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
const formatoFecha = (fecha) => {

    day = fecha[4] + fecha[5];
    month = fecha[2] + fecha[3];
    year = fecha[0] + fecha[1];
    return [day, month, year].join('/');
}
const agregarOrden = () => {
    console.log('guardando');
    console.log(ordenesConstruccion);
}

const cancelarOrden = () => {
    let combo = document.getElementById('ordenes');
    let nroOrden = combo.options[combo.selectedIndex].text;
    swal({
        title: `¿Desea cancelar la orden de ensamble N° ${nroOrden}?`,
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

const enviarCancelarOrden = (nroOrden) => {
    const datos = new FormData(document.getElementById('formulario'));
    datos.append('orden', nroOrden);
    fetch('/admin/ensamble/cancelarorden', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            if (data === 'ok') {
                swal({
                    title: `¡Se ha dado de baja la orden de ensamble N°${nroOrden}!`,
                    icon: "success",
                    button: "Aceptar",
                });
                setTimeout(function () {
                    location.reload();
                }, 1000)
            }
        })

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
            title: "¡Esta pieza no tiene orden de ensamble!",
            icon: "warning",
            button: "Aceptar",
        });

    } else if (existe != null) {
        swal({
            title: "¡Ya se ha cargado la orden de ensamble!",
            icon: "warning",
            button: "Aceptar",
        });
    } else {
        body.appendChild(tr);
    }
}



const sacarOC = (oc) => {
    let body = document.getElementById('idbody');
    let tr = document.getElementById(oc);
    body.removeChild(tr)
    console.log('sacando', oc)
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