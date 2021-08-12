document.getElementById('lista').addEventListener('change', function (e) {
    let buscar = document.getElementById('buscar');
    buscar.disabled = false;
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
    let tabla = `<table class="table-striped table table-bordered table-scroll3">`;
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
        tabla += ` <button type="button" class="btn btn-secondary">Imprimir</button>`;
        tabla += `</tr>`;

    });
    tabla += `</tbody>`;
    tabla += `</table>`;
    tabla += `<tr> <td> <button type ="button" class="btn btn-success" onclick="excel();">Excel</button></td></tr>`
    divtabla.innerHTML = tabla;
}
const realizarTablaFecha = (array) => {
    let divtabla = document.getElementById('divtabla');
    let tabla = `<table class="table-striped table table-bordered table-scroll3">`;
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
        tabla += `<td><button type="button" class="btn btn-info" onclick= "infoOR();">Info</button> `;
        tabla += ` <button type="button" class="btn btn-secondary">Imprimir</button>`;
        tabla += `</tr>`;

    });
    tabla += `</tbody>`;
    tabla += `</table>`;
    tabla += `<tr> <td> <button type ="button" class="btn btn-success" onclick="excel();">Excel</button></td></tr>`
    divtabla.innerHTML = tabla;
}

const realizarTablaHerramienta = (array) => {
    let divtabla = document.getElementById('divtabla');
    let tabla = `<table class="table-striped table table-bordered table-scroll3">`;
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
        tabla += `<td><button type="button" class="btn btn-info" onclick= "infoOR();">Info</button> `;
        tabla += ` <button type="button" class="btn btn-secondary">Imprimir</button>`;
        tabla += `</tr>`;

    });
    tabla += `</tbody>`;
    tabla += `</table>`;
    tabla += `<tr> <td> <button type ="button" class="btn btn-success" onclick="excel();">Excel</button></td></tr>`
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
            console.log(data);
        })
}