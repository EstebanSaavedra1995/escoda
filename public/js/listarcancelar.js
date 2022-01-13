

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
    } else if (valor == 2){
        filtroPieza();
    } else if (valor == -1){
    document.getElementById('divOrden').style.display='none';
    document.getElementById('divPiezas').style.display='none';
    document.getElementById('divFechas').style.display='none';
    document.getElementById('buscar').disabled = true;
    }

})
$('#pieza').on('select2:select', function () {

});
$('#ordenes').on('select2:select', function () {
  /*  const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/construccion', {
        method: 'POST',
        body: datos,
    })

        .then(res => res.json())
        .then(data => {
            if (data.length == 0) {
                limpiarDatos();
            } else {
                let material = document.getElementById('material');
                material.value = `${data.material.CodigoMaterial} - ${data.material.Material} - ${data.material.Dimension} - ${data.material.Calidad}`;
                let idmaterial = document.getElementById('idmaterial');
                idmaterial.value = data.material.CodigoMaterial;
                let longcorte = document.getElementById('longcorte');
                longcorte.value = data.materialPieza.longitudCorte;
                let cantidadNecesaria = document.getElementById('cantidad-necesaria');
                let cantidadRealizar = document.getElementById('cantidad-realizar');
                cantidadNecesaria.value = (cantidadRealizar.value * longcorte.value) / (1000);
                completarColadas(data.coladaMaterial);
                completarTareas(data.piezaTarea);
            }
        }) */ 
});
const filtroNroOrden = () => {
    /* let filtro = document.getElementById('filtro');
    filtro.className = "row mb-2";
    let input = `<label class=" col mr-2">Nro orden de construcción:</label>`;
    input += `<input type="number" name= "nroorden" id="nroorden" class="form-control col mr-2">`
    filtro.innerHTML = input; */
  /*   $("#divOrden").show();
    $("#divPiezas").hide();
    $("#divFechas").hide(); */
    /* let div = document.querySelector('#divOrden');
    div.style.visibility='visible'; */
    document.getElementById('divOrden').style.display='inline-block';
    document.getElementById('divPiezas').style.display='none';
    document.getElementById('divFechas').style.display='none';
    document.getElementById('buscar').disabled = false;

}
function imprimir (cod)
{
   
    let pdf = document.getElementById('idPDF');
    pdf.value = cod;
    alert(pdf.value);
    document.getElementById('formPDF').submit();
}

const filtroFecha = () => {
    let hoy = formatDate();

    document.getElementById('divOrden').style.display='none';
    document.getElementById('divPiezas').style.display='none';
    document.getElementById('divFechas').style.display='inline-block';
    document.getElementById('fecha1').value = hoy;
    document.getElementById('fecha2').value = hoy;
    document.getElementById('buscar').disabled = false;
    /* let filtro = document.getElementById('filtro'); 
    filtro.className = "row mb-2";
    let inputs = `<label class=" col mr-2">Desde</label>`;
    inputs += `<input type="date" value="${hoy}" name="fecha1" id="fecha1" class="form-control col mr-2">`
    inputs += `<label class=" col mr-2">Hasta</label>`;
    inputs += `<input type="date" value="${hoy}" name="fecha2" id="fecha2" class="form-control col mr-2">`
    filtro.innerHTML = inputs; */

}
const filtroPieza = () => {
    document.getElementById('divOrden').style.display='none';
    document.getElementById('divPiezas').style.display='inline-block';
    document.getElementById('divFechas').style.display='none'
    document.getElementById('buscar').disabled = false;
    /* let filtro = document.getElementById('filtro');
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
        }) */
}

const listarOrdenes = () => { // SOLO ENVIAR FECHAS
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

    day = fecha[8] + fecha[9];
    month = fecha[5] + fecha[6];
    year = fecha[0] + fecha[1] + fecha[2] + fecha[3];
    return [day, month, year].join('/');
}

const listarTareas = (oc) => {
    document.getElementById('hdOC').value = oc;
    const datos = new FormData(document.getElementById('formulario'));
    datos.append('oc', oc);
    fetch('/admin/listarcancelar/detalles', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            //console.log(data);
            divtablatareas = document.getElementById('divtablatareas');
            let tabla = `<table class="table-striped table table-bordered table-scroll3">`;
            tabla += `<thead>`;
            tabla += `<tr>`;
            tabla += `<th scope="col">Tareas</th>`;
            tabla += `<th scope="col">Máquina</th>`;
            tabla += `<th scope="col">Operario</th>`;
            tabla += `<th scope="col">Supervisor</th>`;
            tabla += `<th scope="col">Horas</th>`;
            tabla += `<th scope="col">Acciones</th>`;
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
                let maquina = codMaquina(tarea.Maquina);
                let op = codOpSup(tarea.Operario);
                let sup = codOpSup(tarea.Supervisor);
                //Hacer una funcion q devuelva los id o codigo de los primeros 4 y pasarlo como parametros a la funcion alerta.
                //en construccion.js ver linea 270 para abrir modal.
                tabla += `<td><input type="button" value="Modificar" class="btn btn-success" onclick="modalModificar(${tarea.id_detalle},${tarea.id_tarea}, '${maquina}', '${op}', '${sup}','${tarea.Horas}');" /></td>`;
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
        tabla += `<button type="button" class="btn btn-secondary" onclick="imprimir('${orden.NroOC}');">Imp</button> `
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
        tabla += `<button type="button" class="btn btn-secondary" onclick="imprimir('${orden.NroOC}');">Imp</button> `
        tabla += `<button type="button" class="btn btn-danger" onclick="cancelarTarea('${orden.NroOC}');">Can</button></td>`;
        tabla += `</tr>`;

    });

    tabla += `</tbody>`;
    tabla += `</table>`;
    //numeroReporteExcel();
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
        tabla += `<button type="button" class="btn btn-secondary" onclick="imprimir('${orden.NroOC}');">Imp</button> `
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
/* }
const numeroReporteExcel = () => {
    let divPieza = document.getElementById('divPieza').style.visibility = "hidden";
    let divFecha = document.getElementById('divFecha').style.visibility = "hidden";
    let divNumero = document.getElementById('divNumero').style.visibility = "visible";

    let numeroExcel = document.getElementById('numeroExcel');
    numeroExcel.value = document.getElementById('nroorden').value;
    //pasarle el valor del numero de orden
} */

const ocultarExcels = () => {
    let divPieza = document.getElementById('divPieza').style.visibility = "hidden";
    let divFecha = document.getElementById('divFecha').style.visibility = "hidden";
    let divNumero = document.getElementById('divNumero').style.visibility = "hidden";
}


function codMaquina(maquina) {
    return maquina.substring(0, 2)
}
function codOpSup(operario) {
    return operario.substring(0, 3)
}

function  modalModificar(detalle, tarea, maq, op, sup, tiempo) {
    //let tareas = document.getElementById("tarea-modificar").value = tarea;
    //alert(tarea);
    //console.log(tiempo);
    console.log(detalle, tarea, maq, op, sup, tiempo)
    document.getElementById("hdDetalle").value = detalle 
    $("#tarea-modificar").val(tarea);
    $("#maquina-modificar").val(maq);
    $("#operario-modificar").val(op);
    $("#supervisor-modificar").val(sup);
    document.getElementById("modificarhoraminuto").value = tiempo
    $('#modalmodificartareas').modal('show');
}


function enviarModificacion ()  {
    var comboTarea = document.getElementById("tarea-modificar");
    var tarea = comboTarea.options[comboTarea.selectedIndex].text;

    var comboMaquina = document.getElementById("maquina-modificar");
    var maquina = comboMaquina.options[comboMaquina.selectedIndex].text;

    var comboOP = document.getElementById("operario-modificar");
    var op = comboOP.options[comboOP.selectedIndex].text;

    var comboSup = document.getElementById("supervisor-modificar");
    var sup = comboSup.options[comboSup.selectedIndex].text;

    var tiempo = document.getElementById("modificarhoraminuto").value;
    var datos = new FormData(document.getElementById('formulario-modalmodificartareas'));
    //console.log(tarea, maquina, op, sup, tiempo);
    datos.append('tarea', tarea);
    datos.append('maquina', maquina);
    datos.append('op', op);
    datos.append('sup', sup);
    datos.append('tiempo', tiempo);

    fetch('/admin/listarcancelar/modificarOC', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
                if (data === 'ok') {
                    var oc = document.getElementById('hdOC').value 
                            swal({
                                title: `¡Se ha modificado la orden de construcción N°${oc}!`,
                                icon: "success",
                                button: "Aceptar",
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1000)
                        } else {
                            swal({
                                title: "¡Ocurrió un fallo, no se pudo modificar!",
                                icon: "warning",
                                button: "Aceptar",
                            });
                        }
        }) 
}