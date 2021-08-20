document.getElementById('lista').addEventListener('change', function (e) {
    let divtabla = document.getElementById('divtabla');
    divtabla.innerHTML = '';
    let divtablatareas = document.getElementById('divtablatareas');
    divtablatareas.innerHTML = '';
    ocultarExcels();
    let buscar = document.getElementById('buscar');
    buscar.disabled = false;
    let valor = document.getElementById('lista').value;
    if (valor == 0) {
        filtroNroOrden();
    } else if (valor == 1) {
        filtroFecha();
    } else {
        filtroPieza();
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
const filtroPieza = () => {
    let filtro = document.getElementById('filtro');
    filtro.className = "row mb-2";

    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/listarcancelar/piezas', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            let comboPieza = document.createElement("select");
            comboPieza.className = "col mr-2";
            comboPieza.name = "pieza";
            comboPieza.id = "pieza";

            data.forEach(piezas => {
                let option = document.createElement('option');
                option.innerHTML = `${piezas.CodPieza} - ${piezas.NombrePieza} - ${piezas.Medida}`;
                option.value = piezas.CodPieza;
                comboPieza.appendChild(option);
            })
            filtro.innerHTML = `<label class="col mr-2">Pieza:</label>`;
            filtro.appendChild(comboPieza);
        })
}

const listarOrdenes = () => {
    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/listarcancelar/ordenes', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            divtablatareas = document.getElementById('divtablatareas');
            divtablatareas.innerHTML = '';
            if (data[0] === 'ordenes') {
                realizarTablaOrden(data[1]);
            } else if (data[0] === 'piezas')
                realizarTablaPieza(data[1]);
            else {
                realizarTablaFecha(data[1]);
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
                                location.reload();
                            }, 1000)
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
    /*   const datos = new FormData(document.getElementById('formulario'));
      fetch('/admin/listarcancelar/exportExcel', {
          method: 'GET',
      })
          
          .then(data => {
              console.log('LLegó');
          }) */
    console.log('Excel');
}

const realizarTablaPieza = (array) => {
    let divtabla = document.getElementById('divtabla');
    let tabla = `<table class="table-striped table table-bordered table-scroll3">`;
    tabla += `<thead>`;
    tabla += `<tr>`;
    tabla += `<th scope="col">Pieza</th>`;
    tabla += `<th scope="col">Nro de orden</th>`;
    tabla += `<th scope="col">Fecha</th>`;
    tabla += `<th scope="col">Cantidad</th>`;
    tabla += `<th scope="col">Material</th>`;
    tabla += `<th scope="col">Longitud corte</th>`;
    tabla += `<th scope="col">Colada</th>`;
    tabla += `<th scope="col">Acciónes</th>`;
    tabla += `</tr>`;
    tabla += `</thead>`;
    tabla += `<tbody>`;
    array.forEach(orden => {
        tabla += `<tr>`;
        tabla += `<td>${orden.CodPieza} - ${orden.NombrePieza} - ${orden.Medida}</td>`;
        tabla += `<td style="width: 20px">${orden.NroOC} </td>`;
        tabla += `<td style="width: 15px">${formatoFecha(orden.Fecha)} </td>`;
        tabla += `<td style="width: 15px">${orden.Cantidad} </td>`;
        tabla += `<td>${orden.CodigoMaterial} - ${orden.Material} - ${orden.Dimension} - ${orden.Calidad}</td>`;
        tabla += `<td style="width: 20px">${orden.LongitudCorte} </td>`;
        tabla += `<td style="width: 15px">${orden.Colada} </td>`;
        tabla += `<td><button type="button" class="btn btn-info" onclick="listarTareas('${orden.NroOC}');">Tar</button> `;
        tabla += `<button type="button" class="btn btn-secondary">Imp</button> `
        tabla += `<button type="button" class="btn btn-danger" onclick="cancelarTarea('${orden.NroOC}');">Can</button></td>`;
        tabla += `</tr>`;

    });
    tabla += `</tbody>`;
    tabla += `</table>`;
    piezaReporteExcel();
    divtabla.innerHTML = tabla;

}
const realizarTablaOrden = (array) => {
    let divtabla = document.getElementById('divtabla');
    let tabla = `<table class="table-striped table table-bordered table-scroll3">`;
    tabla += `<thead>`;
    tabla += `<tr>`;
    tabla += `<th scope="col">Nro de orden</th>`;
    tabla += `<th scope="col">Fecha</th>`;
    tabla += `<th scope="col">Pieza</th>`;
    tabla += `<th scope="col">Cantidad</th>`;
    tabla += `<th scope="col">Material</th>`;
    tabla += `<th scope="col">Longitud corte</th>`;
    tabla += `<th scope="col">Colada</th>`;
    tabla += `<th scope="col">Acciónes</th>`;
    tabla += `</tr>`;
    tabla += `</thead>`;
    tabla += `<tbody>`;
    array.forEach(orden => {
        tabla += `<tr>`;
        tabla += `<td style="width: 20px">${orden.NroOC} </td>`;
        tabla += `<td style="width: 15px">${formatoFecha(orden.Fecha)} </td>`;
        tabla += `<td>${orden.CodPieza} - ${orden.NombrePieza} - ${orden.Medida}</td>`;
        tabla += `<td style="width: 15px">${orden.Cantidad} </td>`;
        tabla += `<td>${orden.CodigoMaterial} - ${orden.Material} - ${orden.Dimension} - ${orden.Calidad}</td>`;
        tabla += `<td style="width: 20px">${orden.LongitudCorte} </td>`;
        tabla += `<td style="width: 15px">${orden.Colada} </td>`;
        tabla += `<td><button type="button" class="btn btn-info" onclick="listarTareas('${orden.NroOC}');">Tar</button> `;
        tabla += `<button type="button" class="btn btn-secondary">Imp</button> `
        tabla += `<button type="button" class="btn btn-danger" onclick="cancelarTarea('${orden.NroOC}');">Can</button></td>`;
        tabla += `</tr>`;

    });

    tabla += `</tbody>`;
    tabla += `</table>`;
    numeroReporteExcel();
    divtabla.innerHTML = tabla;

}
const realizarTablaFecha = (array) => {
    let divtabla = document.getElementById('divtabla');
    let tabla = `<table class="table-striped table table-bordered table-scroll3">`;
    tabla += `<thead>`;
    tabla += `<tr>`;
    tabla += `<th scope="col">Fecha</th>`; style = "width: 20px"
    tabla += `<th scope="col">Nro de orden</th>`;

    tabla += `<th scope="col">Pieza</th>`;
    tabla += `<th scope="col">Cantidad</th>`;
    tabla += `<th scope="col">Material</th>`;
    tabla += `<th scope="col">Longitud corte</th>`;
    tabla += `<th scope="col">Colada</th>`;
    tabla += `<th scope="col">Acciónes</th>`;
    tabla += `</tr>`;
    tabla += `</thead>`;
    tabla += `<tbody>`;
    array.forEach(orden => {
        tabla += `<tr>`;
        tabla += `<td style="width: 15px">${formatoFecha(orden.Fecha)} </td>`;
        tabla += `<td style="width: 20px">${orden.NroOC} </td>`;
        tabla += `<td>${orden.CodPieza} - ${orden.NombrePieza} - ${orden.Medida}</td>`;
        tabla += `<td style="width: 15px">${orden.Cantidad} </td>`;
        tabla += `<td>${orden.CodigoMaterial} - ${orden.Material} - ${orden.Dimension} - ${orden.Calidad}</td>`;
        tabla += `<td style="width: 20px">${orden.LongitudCorte} </td>`;
        tabla += `<td style="width: 15px">${orden.Colada} </td>`;
        tabla += `<td><button type="button" class="btn btn-info" onclick="listarTareas('${orden.NroOC}');">Tar</button> `;
        tabla += `<button type="button" class="btn btn-secondary">Imp</button> `
        tabla += `<button type="button" class="btn btn-danger" onclick="cancelarTarea('${orden.NroOC}');">Can</button></td>`;
        tabla += `</tr>`;

    });
    tabla += `</tbody>`;
    tabla += `</table>`;
    fechaReporteExcel();
    divtabla.innerHTML = tabla;

}
const piezaReporteExcel = () => {
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
}