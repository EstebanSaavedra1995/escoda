let ordenesConstruccion = [];
let arregloArticulos = [];
let  arregloGomas = [];



$('#ordenes').on('select2:select', function () {
    ordenesConstruccion = [];
    arregloGomas = [];
    arregloArticulos = [];
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
            herramienta.value = `${data.conjunto.CodPieza} - ${data.conjunto.NombrePieza}`;
            numero.value = data.ordenPendiente.NroCjto;
            armarTabla(data.conjuntoArticulos, data.piezasConjunto, data.conjuntoGomas);
        })

});

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
    cadena += `<th scope="col">OC</th>`;
    cadena += `</tr>`;
    cadena += `</thead>`;
    cadena += `<tbody>`;
    if (gomas.length > 0) {
        gomas.forEach(goma => {
            cadena += `<tr>`;
            cadena += `<td>Goma</td>`;
            cadena += `<td class = "gomaCodigo">${goma.CodigoInterno}</td>`;
            cadena += `<td>${goma.CodigoGoma} - ${goma.DiametroInterior} - ${goma.DiametroExterior}</td>`;
            cadena += `<td><select class = "gomaOpcion" name = "combo${goma.CodigoGoma}" onchange = "addGoma('${goma.CodigoGoma}')";>`;
            cadena += `<option value = "1"> Si </option>`;
            cadena += `<option value = "0" selected> No </option>`;
            cadena += `</select></td>`;
            cadena += `<td style="width: 50px"> <input class="gomaCantidad" disabled id= "cant${goma.CodigoGoma}" style="width: 50px" type ="number" value = "${goma.Cantidad}"></td>`;
            cadena += `<td></td>`
            cadena += `</tr>`;
        })
    }


    if (articulos.length > 0) {
        articulos.forEach(articulo => {
            cadena += `<tr class = "claseArticulo">`;
            cadena += `<td>Artículos grales</td>`;
            cadena += `<td class ="articuloCodigo">${articulo.CodArticulo}</td>`;
            cadena += `<td>${articulo.Descripcion}</td>`;
            cadena += `<td><select class ="articuloOpcion" name = "combo${articulo.CodArticulo}" onchange ="addArticulo('${articulo.CodArticulo}')"; >`;
            cadena += `<option value = "1" > Si </option>`;
            cadena += `<option value = "0" selected> No </option>`;
            cadena += `</select></td>`;
            cadena += `<td style="width: 50px"> <input class= "articuloCantidad" disabled id= "cant${articulo.CodArticulo}" style="width: 50px" type ="number" value = "${articulo.Cantidad}"></td>`;
            cadena += `<td></td>`
            cadena += `</tr>`;
        })
    }
    if (piezas.length > 0) {
        piezas.forEach(pieza => {
            cadena += `<tr>`;
            cadena += `<td>Pieza</td>`;
            cadena += `<td>${pieza.codigoPieza}</td>`;
            cadena += `<td>${pieza.NombrePieza}</td>`;
            cadena += `<td><select name = "combo${pieza.codigoPieza}" id = "combo${pieza.codigoPieza}" onchange = "habilitar('${pieza.codigoPieza}')";>`;
            cadena += `<option value = "1"> Si </option>`;
            cadena += `<option value = "0" selected> No </option>`;
            cadena += `</select></td>`;

            cadena += `<td style="width: 50px"> <input disabled min = "1" style="width: 50px" type ="number" id= "cant${pieza.codigoPieza}" value = "${pieza.Cantidad}"></td>`;

            cadena += `<td><button disabled type="button" id= "btn${pieza.codigoPieza}" class ="btn btn-info" onclick = "mostrarOC('${pieza.codigoPieza}');">Orden</button></td>`
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

    day = fecha[8] + fecha[9];
    month = fecha[5] + fecha[6];
    year = fecha[0] + fecha[1] + fecha[2] + fecha[3];
    return [day, month, year].join('/');
}
const agregarOrden = () => {
    /* console.log(typeof JSON.parse(ordenesConstruccion)); */
    let combo = document.getElementById('ordenes');
    let nroOrden = combo.options[combo.selectedIndex].text;
    let comboOperario = document.getElementById('op').value;
    let comboSupervisor = document.getElementById('sup').value;

    if (comboOperario == "000" || comboOperario == "" || comboSupervisor == "000" || comboSupervisor == "") {
        swal({
            title: `¡Tiene que seleccionar operario y supervisor!`,
            icon: "warning",
            buttons: "Aceptar",
            dangerMode: true,
        })
    }
    else if (ordenesConstruccion.length != 0 || arregloGomas.length != 0 || arregloArticulos != 0) {
        swal({
            title: `¿Desea agregar la orden de ensamble N° ${nroOrden}?`,
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
            dangerMode: true,
        })
            .then((willAdd) => {
                if (willAdd) {
                    enviarAgregarOrden();
                }
            });
    } else {
        swal({
            title: `¡No se está agregando ningun/a pieza/articulo/goma para reparar!`,
            icon: "warning",
            buttons: "Aceptar",
            dangerMode: true,
        })
    }



}
const enviarAgregarOrden = () => {

    let arreglo = JSON.stringify(ordenesConstruccion);
   
  
    let comboOperario = document.getElementById('op').value;
    let comboSupervisor = document.getElementById('sup').value;
    let numero = document.getElementById('numero').value;
    let combo = document.getElementById('ordenes');
    let nroOrden = combo.options[combo.selectedIndex].text;

    const datos = new FormData(document.getElementById('formulario2'));

    let codigoGomas =  document.getElementsByClassName('gomaCodigo');
    let opcionesGomas = document.getElementsByClassName('gomaOpcion');
    let cantidadesGomas = document.getElementsByClassName('gomaCantidad');

    let codigoArticulos = document.getElementsByClassName('articuloCodigo');
    let opcionesArticulos = document.getElementsByClassName('articuloOpcion');
    let cantidadesArticulos = document.getElementsByClassName('articuloCantidad');

    gomasObj = [];
    articulosObj = [];
    if(codigoGomas.length > 0){
        for (let i = 0; i < codigoGomas.length; i++) {
            let e = {
                id: codigoGomas[i].innerHTML,
                opcion: opcionesGomas[i].value,
                cantidad: cantidadesGomas[i].value
            };
            gomasObj.push(e);
        }
    }
    if(codigoArticulos.length > 0){
        for (let i = 0; i < codigoArticulos.length; i++) {
            let e = {
                id: codigoArticulos[i].innerHTML,
                opcion: opcionesArticulos[i].value,
                cantidad: cantidadesArticulos[i].value
            };
            articulosObj.push(e);
        }
    }
    gomasObj = JSON.stringify(gomasObj);
    articulosObj = JSON.stringify(articulosObj);
    datos.append('oc', arreglo);
    datos.append('op', comboOperario);
    datos.append('sup', comboSupervisor);
    datos.append('numero', numero);
    datos.append('nro', nroOrden);
    datos.append('gomasObj', gomasObj);
    datos.append('articulosObj', articulosObj);
    fetch('/admin/ensamble/agregarorden', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {

            console.log(data);
            
                if (data === 'ok') {
                    swal({
                        title: `¡Se ha dado de alta la orden de ensamble N°${nroOrden}!`,
                        icon: "success",
                        button: "Aceptar",
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1000)
                }
        })

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
    fetch('/admin/ensamble/ordenpieza', {
        method: 'POST',
        body: datos,
    })

        .then(res => res.json())
        .then(data => {


            data.forEach(oc => {

                select += `<option value = "${oc.NroOC}">${oc.NroOC}</option>`;
            })
            select += `</select>`;
            let cantidadPieza = document.getElementById(`cant${codigoPieza}`).value;
            let cantidad = `<label class="col" for= "cantidad">Cantidad por OC: </label> <input class = "col" type = "number" value ="${cantidadPieza}" name= "cantidad" id= "cantidad">`;
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



const sacarOC = (oc) => {
    let body = document.getElementById('idbody');
    let tr = document.getElementById(oc);
    body.removeChild(tr)

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

    }

    let suma = 0;
    for (let i = 0; i < cantidades.length; i++) {
        
        suma = suma + parseInt(cantidades[i].innerHTML);
    }
    let cant = document.getElementById(`cant${pieza}`);
    
    cant.value = suma;

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
const addGoma = (id) => {
    if (arregloGomas.includes(id)) {
        let pos = arregloGomas.indexOf(id);
        arregloGomas.splice(pos, 1);
    } else {
        arregloGomas.push(id);
    }
    let cant = document.getElementById(`cant${id}`);
    cant.disabled = !cant.disabled;
    

}
const addArticulo = (id) => {
     if (arregloArticulos.includes(id)) {
         let pos = arregloArticulos.indexOf(id);
         arregloArticulos.splice(pos, 1);
     } else {
         arregloArticulos.push(id);
     }
     let cant = document.getElementById(`cant${id}`);
     cant.disabled = !cant.disabled;
     
}

const habilitar = (cod) => {
    let btn = document.getElementById(`btn${cod}`);
    btn.disabled = !btn.disabled;
    let cant = document.getElementById(`cant${cod}`);
    cant.disabled = !cant.disabled;
   
    let combo = document.getElementById(`combo${cod}`);
    let indice = -1;
    if (combo.value == 0 ){
        
        for (let i = 0; i < ordenesConstruccion.length; i++) {
            if (ordenesConstruccion[i].id === cod){
                indice = i;
            }
        }

        if (indice!=-1){
            ordenesConstruccion.splice(indice, 1);
        }
        //console.log(ordenesConstruccion);
    }
  
}
