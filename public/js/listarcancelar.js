

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

const filtroNroOrden = () => {

    document.getElementById('divOrden').style.display='inline-block';
    document.getElementById('divPiezas').style.display='none';
    document.getElementById('divFechas').style.display='none';
    document.getElementById('buscar').disabled = false;

}
function imprimir (cod)
{
    let pdf = document.getElementById('idPDF');
    pdf.value = cod;
    //alert(pdf.value);
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


}
const filtroPieza = () => {
    document.getElementById('divOrden').style.display='none';
    document.getElementById('divPiezas').style.display='inline-block';
    document.getElementById('divFechas').style.display='none'
    document.getElementById('buscar').disabled = false;

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
            tabla += `<th scope="col">Estado</th>`;
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
                tabla += `<td>${tarea.Estado}</td>`;
                let maquina = codMaquina(tarea.Maquina);
                let op = codOpSup(tarea.Operario);
                let sup = codOpSup(tarea.Supervisor);
                //tabla += `<td><a type="button" value="Modificar" class="btn btn-danger" onclick="modalModificar(${tarea.id_detalle},${tarea.id_tarea}, '${maquina}', '${op}', '${sup}','${tarea.Horas}');" ><i class="fas fa-music"></i> </a>`;

                tabla += `<td><a type="button" value="Modificar" title="Modificar" class="btn btn-danger" onclick="modalModificar(${tarea.id_detalle},${tarea.id_tarea}, '${maquina}', '${parseInt(op)}', '${sup}','${tarea.Horas}','${tarea.Estado}');"><i class="fas fa-edit"></i></a> `;
                tabla += `<a type="button" value="Eliminar" title="Eliminar" class="btn btn-warning" onclick="eliminarTarea(${tarea.id_detalle}, '${tarea.Tarea}');"><i class="fas fa-trash-alt"></i></a>`;
                tabla += `</tr>`;
            })
            tabla += `<tr><td><button type="button" class="btn btn-primary" onclick="modalAgregar();"> Agregar Tarea</button></td>`;
            tabla += `<td colspan="6"></td></tr>`;
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
        tabla += `<td><button type="button" class="btn btn-info" title="Tareas" onclick="listarTareas('${orden.NroOC}');">Tar</button> `;
        tabla += `<button type="button" class="btn btn-secondary" title="Imprimir" onclick="imprimir('${orden.NroOC}');">Imp</button> `;
        tabla += `<button type="button" class="btn btn-danger" title="Cancelar" onclick="cancelarTarea('${orden.NroOC}');">Can</button></td>`;
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
        tabla += `<td><button type="button" class="btn btn-info"  title="Tarea" onclick="listarTareas('${orden.NroOC}');">Tar</button> `;
        tabla += `<button type="button" class="btn btn-secondary" title="Imprimir" onclick="imprimir('${orden.NroOC}');">Imp</button> `
        tabla += `<button type="button" class="btn btn-danger"    title="Cancelar" onclick="cancelarTarea('${orden.NroOC}');">Can</button></td>`;
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
        tabla += `<td><button type="button" class="btn btn-info"  title="Tarea" onclick="listarTareas('${orden.NroOC}');">Tar</button> `;
        tabla += `<button type="button" class="btn btn-secondary" title="Imprimir" onclick="imprimir('${orden.NroOC}');">Imp</button> `
        tabla += `<button type="button" class="btn btn-danger"    title="Cancelar" onclick="cancelarTarea('${orden.NroOC}');">Can</button></td>`;
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
    return parseInt(maquina.substring(0, 2), 10);
}
function codOpSup(operario) {
    return operario.substring(0, 3)
}

function  modalModificar(detalle, tarea, maq, op, sup, tiempo,estado) {

    console.log(detalle, tarea, maq, op, sup, tiempo)
    document.getElementById("hdDetalle").value = detalle 
    $("#tarea-modificar").val(tarea);
    $("#maquina-modificar").val(maq);
    $("#operario-modificar").val(op);
    $("#supervisor-modificar").val(sup);
    $("#estado").val(estado);
    document.getElementById("modificarhoraminuto").value = tiempo
    $('#modalmodificartareas').modal('show');
}
function  modalAgregar() {
    $('#modalAgregarTarea').modal('show');
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
    
    var comboEstado = document.getElementById("estado");
    var estado = comboEstado.options[comboEstado.selectedIndex].text;

    var tiempo = document.getElementById("modificarhoraminuto").value;
    var datos = new FormData(document.getElementById('formulario-modalmodificartareas'));
    datos.append('tarea', tarea);
    datos.append('maquina', maquina);
    datos.append('op', op);
    datos.append('sup', sup);
    datos.append('tiempo', tiempo);
    datos.append('estado', estado);

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
                           listarTareas(oc)
                        } else {
                            swal({
                                title: "¡Ocurrió un fallo, no se pudo modificar!",
                                icon: "warning",
                                button: "Aceptar",
                            });
                        }
        }) 
}
function enviarTarea ()  {
    var oc = document.getElementById("hdOC").value;
    var comboTarea = document.getElementById("tarea-agregar");
    var tarea = comboTarea.options[comboTarea.selectedIndex].text;

    var comboMaquina = document.getElementById("maquina-agregar");
    var maquina = comboMaquina.options[comboMaquina.selectedIndex].text;

    var comboOP = document.getElementById("operario-agregar");
    var op = comboOP.options[comboOP.selectedIndex].text;

    var comboSup = document.getElementById("supervisor-agregar");
    var sup = comboSup.options[comboSup.selectedIndex].text;

    var tiempo = document.getElementById("agregarminuto").value;
    var datos = new FormData(document.getElementById('formulario-agregarTarea'));
    //console.log(tarea, maquina, op, sup, tiempo);
    datos.append('tarea', tarea);
    datos.append('maquina', maquina);
    datos.append('op', op);
    datos.append('sup', sup);
    datos.append('tiempo', tiempo);
    datos.append('oc', oc);

    fetch('/admin/listarcancelar/agregarTarea', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
                if (data === 'ok') {
                            swal({
                                title: `¡Se ha agregado una tarea a la orden de construcción N°${oc}!`,
                                icon: "success",
                                button: "Aceptar",
                            });
                            listarTareas(oc);
                        } else {
                            swal({
                                title: "¡Ocurrió un fallo, no se pudo agregar!",
                                icon: "warning",
                                button: "Aceptar",
                            });
                        }
        }) 
}

function eliminarTarea (cod, tar){
    swal({
        title: "¿Desea eliminar la tarea: " + tar + "?" ,
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        dangerMode: true,
    })
        .then((willAdd) => {
            if (willAdd) {
                enviarEliminarTarea(cod, tar);
            }
        });
}

function enviarEliminarTarea (codTarea, tar )  {
    var datos = new FormData(document.getElementById('formulario-agregarTarea'));
    datos.append('codTarea', codTarea);

    fetch('/admin/listarcancelar/eliminarTarea', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
                if (data === 'ok') {
                    var oc = document.getElementById("hdOC").value;
                            swal({
                                title: `¡Se ha eliminado la tarea ${tar}!`,
                                icon: "success",
                                button: "Aceptar",
                            });
                            listarTareas(oc);
                        } else {
                            swal({
                                title: "¡Ocurrió un fallo, no se pudo eliminar!",
                                icon: "warning",
                                button: "Aceptar",
                            });
                        }
        }) 
}


