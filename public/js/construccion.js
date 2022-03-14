
function verificarRadios() {
    let nameradio = document.getElementsByName('nameradio');
    let flag = false;

    for (let i = 0; i < nameradio.length; i++) {
        if (nameradio[i].checked === true) {
            flag = true;
        }
    }
    return flag;
}
function cancelar() {
    swal({
        title: "¿Desea cancelar la orden de construcción?",
        /* text: "Once deleted, you will not be able to recover this imaginary file!", */
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        dangerMode: true,
    })
        .then((willCancel) => {
            if (willCancel) {
                setTimeout(function () {
                    location.reload(); //ARREGLAR
                }, 1000)
            }
        });

}
function validar() {
    let celdasincorrectas = document.getElementsByClassName('celdasincorrectas').length;
    let filasDeTarea = document.getElementsByClassName('filasDeTarea').length;
    let cantidadrealizar = document.getElementById('cantidad-realizar').value;
    let radios = verificarRadios();
    /* console.log(cantidadrealizar); */

    if (filasDeTarea > 0 && celdasincorrectas == 0 && cantidadrealizar > 0 && radios == true) {
        swal({
            title: "¿Desea agregar una nueva orden de construcción?",
            /* text: "Once deleted, you will not be able to recover this imaginary file!", */
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
            dangerMode: true,
        })
            .then((willAdd) => {
                if (willAdd) {
                    enviarDatos();
                }
            });
    } else {
        swal({
            title: "¡Faltan datos por completar!",
            icon: "warning",
            button: "Aceptar",
        });
    }
}

function enviarDatos() {
    const datos = new FormData(document.getElementById('formulario'));
    let arreglo = pasarFilas();
    datos.append('arreglo', arreglo);
    fetch('/admin/construccion/agregarconstruccion', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            //alert(data);
            console.log(data);
            if (data === 'ok') {
                swal({
                    title: "¡Se ha agregado una nueva orden de construcción!",
                    icon: "success",
                    button: "Aceptar",
                });
                setTimeout(function () {
                    location.reload();
                }, 1000)
            } else {
                swal({
                    title: "¡Ocurrió un fallo, por favor revise los campos!",
                    icon: "warning",
                    button: "Aceptar",
                });
            }
        })
}


function pasarFilas() {
    let filas = document.getElementsByClassName('filasDeTarea');
    let filasText = [];

    for (let i = 0; i < filas.length; i++) {
        let celdas = filas[i].cells;
        let celdasText = [];
        for (let j = 0; j < 5; j++) {
            celdasText.push(celdas[j].innerHTML);
        }
        filasText.push(celdasText);
    }
    return JSON.stringify(filasText);
}



//Cada vez que selecciona una pieza en el selector
/* document.getElementById('piezas').addEventListener('click', function (e) {
    e.preventDefault();

    const datos = new FormData(document.getElementById('formulario'));
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
        })
}, true) */
$('#piezas').on('select2:select', function () {

    const datos = new FormData(document.getElementById('formulario'));
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
        })
});

const vaciarSelector = () => {

    $("#tarea-modificar").empty();
    $("#maquina-modificar").empty();
    $("#operario-modificar").empty();
    $("#supervisor-modificar").empty();

}

//Busqueda de material en tiempo real
document.getElementById('buscarmaterial').addEventListener('keyup', function (e) {
    e.preventDefault();
    const datos = new FormData(document.getElementById('formulario-modal'));
    fetch('/admin/construccion/material/buscar', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            completarMaterial(data);
        })
}, true)

//Activar el modal para buscar materiales
$(document).ready(function () {
    $('#buscar').click(function () {
        $('#modal').modal('show');
    })
})
//Activar el modal para agregar tareas
$(document).on('click', '#agregartarea', function () {
    $('#modaltareas').modal('show');
});

//Activar el modal para modificar tareas
let $mtarea = $('#modificarTarea');

function modificarTareas(tarea, maquina) {
    vaciarSelector();
    const datos = new FormData(document.getElementById('formulario-modalmodificartareas'));
    let idMaquina = maquina.split(" ", 1);
    let comboTareas = document.getElementById('tarea-modificar');
    let comboMaquinas = document.getElementById('maquina-modificar');
    let comboOperario = document.getElementById('operario-modificar');
    let comboSupervisor = document.getElementById('supervisor-modificar');
    let idTareaModifcar = document.getElementById('idTareaModificar'); //el oculto

    fetch('/admin/construccion/modificartarea', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            idTareaModifcar.value = tarea;
            data.tareas.forEach(tareas => {
                let option = document.createElement('option');

                str = JSON.stringify(tareas); //IMPORTANTEEE
                option.innerHTML = tareas.Tarea.trim(); //sacamos espacios de la lista de tareas de la base
                if (option.text === tarea) {
                    option.selected = true;
                }
                option.disabled = true;
                option.value = str;
                comboTareas.appendChild(option);
            })
            data.maquinas.forEach(maquinas => {
                let option = document.createElement('option');
                /* option.value = maquinas.CodMaquina; */
                str = JSON.stringify(maquinas);
                option.innerHTML = `${maquinas.CodMaquina} - ${maquinas.NombreMaquina}`;
                if (maquinas.CodMaquina === idMaquina[0]) {
                    option.selected = true;
                }
                option.value = str;
                comboMaquinas.appendChild(option);
            })
            data.operarios.forEach(operarios => {
                let option = document.createElement('option');
                str = JSON.stringify(operarios);
                option.value = str;
                option.innerHTML = `${operarios.NroLegajo} - ${operarios.ApellidoNombre}`;
                comboOperario.appendChild(option);
            })

            data.supervisores.forEach(supervisores => {
                let option = document.createElement('option');
                str = JSON.stringify(supervisores);
                option.value = str;
                option.innerHTML = `${supervisores.NroLegajo} - ${supervisores.ApellidoNombre}`;
                if (option.text === 'Rodriguez Daniel') {
                    option.selected = true;
                }
                comboSupervisor.appendChild(option);
            })


        })


    $('#modalmodificartareas').modal('show');
}
$mtarea.on('click', modificarTareas);
////////////////////////////////////////////////////////
let $mtarea2 = $('#modificarTarea2');

function modificarTareas2(tarea, maquina, operario, supervisor, horas) {
    vaciarSelector();
    const datos = new FormData(document.getElementById('formulario-modalmodificartareas'));
    let idMaquina = maquina.split(" ", 1);
    let comboTareas = document.getElementById('tarea-modificar');
    let comboMaquinas = document.getElementById('maquina-modificar');
    let comboOperario = document.getElementById('operario-modificar');
    let comboSupervisor = document.getElementById('supervisor-modificar');
    let idTareaModifcar = document.getElementById('idTareaModificar');

    fetch('/admin/construccion/modificartarea', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            let horasminutos = document.getElementById('modificarhoraminuto');
            horasminutos.value = horas;

            idTareaModifcar.value = tarea;
            data.tareas.forEach(tareas => {
                let option = document.createElement('option');
                str = JSON.stringify(tareas); //IMPORTANTEEE
                option.innerHTML = tareas.Tarea.trim(); //sacamos espacios de la lista de tareas de la base
                if (option.text === tarea) {
                    option.selected = true;
                }
                option.disabled = true;
                option.value = str;
                comboTareas.appendChild(option);
            })
            data.maquinas.forEach(maquinas => {
                let option = document.createElement('option');
                str = JSON.stringify(maquinas);
                option.innerHTML = `${maquinas.CodMaquina} - ${maquinas.NombreMaquina}`;
                if (maquinas.CodMaquina === maquina) {
                    option.selected = true;
                }
                option.value = str;
                comboMaquinas.appendChild(option);
            })
            data.operarios.forEach(operarios => {
                
                let option = document.createElement('option');
                str = JSON.stringify(operarios);
                option.innerHTML = `${operarios.NroLegajo} - ${operarios.ApellidoNombre}`;
                if (operarios.NroLegajo === operario) {
                    option.selected = true;
                }
                option.value = str;
                comboOperario.appendChild(option);
            })
            data.supervisores.forEach(supervisores => {
                
                let option = document.createElement('option');
                str = JSON.stringify(supervisores);
                option.innerHTML = `${supervisores.NroLegajo} - ${supervisores.ApellidoNombre}`;

                if (supervisores.NroLegajo === supervisor) {
                    option.selected = true;
                }
                option.value = str;
                comboSupervisor.appendChild(option);
            })

        })


    $('#modalmodificartareas').modal('show');
}
$mtarea2.on('click', modificarTareas2);
////////////////////////////////////////////////////////
let $idbtnModificarTarea = $('#idbtnModificarTarea');
function realizarModificacion() {
    //entre combos y cliscks

    let comboTareas = document.getElementById('tarea-modificar').value;
    comboTareas = JSON.parse(comboTareas);

    let comboMaquinas = document.getElementById('maquina-modificar').value;
    comboMaquinas = JSON.parse(comboMaquinas);

    let comboOperario = document.getElementById('operario-modificar').value;
    comboOperario = JSON.parse(comboOperario);

    let comboSupervisor = document.getElementById('supervisor-modificar').value;
    comboSupervisor = JSON.parse(comboSupervisor);

    let horas = document.getElementById('modificarhoraminuto').value;


    let idTareaModifcar = document.getElementById('idTareaModificar').value;
    let fila = document.getElementById(idTareaModifcar);

    if (comboMaquinas.NombreMaquina === '(Ninguna)') {
        event.stopPropagation();
        swal({
            title: "¡Debe elegir una maquina!",
            icon: "warning",
            button: "Aceptar",
        });
    } else if (comboOperario.NroLegajo === '000') {
        event.stopPropagation();
        swal({
            title: "¡Debe elegir un operario!",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else if (horas === '') {
        event.stopPropagation();
        swal({
            title: "¡Debe ingresar un tiempo estimado!",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else if (horas[2] != ':' || horas.length != 5 || isNaN(horas[0]) || isNaN(horas[1]) || isNaN(horas[3]) || isNaN(horas[4])) {
        event.stopPropagation();
        swal({
            title: "¡Formato de tiempo incorrecto! Ejemplo: 03:45",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else {

        fila.innerHTML = '';
        fila.id = comboTareas.Tarea.trim();

        let celda1 = document.createElement('td');
        celda1.innerHTML = comboTareas.Tarea.trim();
        fila.appendChild(celda1);


        let celda2 = document.createElement('td');
        celda2.innerHTML = `${comboMaquinas.CodMaquina} - ${comboMaquinas.NombreMaquina}`;
        fila.appendChild(celda2);

        let celda3 = document.createElement('td');
        celda3.innerHTML = `${comboOperario.NroLegajo} - ${comboOperario.ApellidoNombre}`;
        fila.appendChild(celda3);

        let celda4 = document.createElement('td');
        celda4.innerHTML = `${comboSupervisor.NroLegajo} - ${comboSupervisor.ApellidoNombre}`;
        fila.appendChild(celda4);

        let celda5 = document.createElement('td');
        celda5.innerHTML = horas;
        fila.appendChild(celda5);

        let celda6 = document.createElement('td');
        let botones = ` <button type="button" class="btn btn-warning" id= "modificarTarea2" onclick="modificarTareas2('${fila.id}','${comboMaquinas.CodMaquina}','${comboOperario.NroLegajo}','${comboSupervisor.NroLegajo}','${horas}');"> Modificar</button>`;
        botones += ` <button type="button" class="btn btn-danger id="eliminar" onclick="eliminarTarea('${fila.id}');"> Eliminar </button>`;
        celda6.innerHTML = botones;
        fila.appendChild(celda6);
        swal({
            title: "¡La tarea se ha modificado con éxito!",
            icon: "success",
            button: "Aceptar",
        });
    }
    /*  console.log(JSON.parse(comboMaquinas)); //IMPORTANTEEE */

}
$idbtnModificarTarea.on('click', realizarModificacion);

//Cada vez que se cambie el valor de cantidad a realizar, la multiplique por la longitud de corte y lo ponga en cantidad necesaria
document.getElementById('cantidad-realizar').addEventListener('keyup', function (e) {
    e.preventDefault();
    let cantidadNecesaria = document.getElementById('cantidad-necesaria');
    let cantidadRealizar = document.getElementById('cantidad-realizar');
    cantidadNecesaria.value = (cantidadRealizar.value * longcorte.value) / (1000);

}, true)

//Funciones 
//Agrega el material del modal de materiales

const agregarMaterial = (codigoMaterial) => {
    const datos = new FormData(document.getElementById('formulario-modal'));
    datos.append('codigoMaterial', codigoMaterial);
    fetch('/admin/construccion/material', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            let material = document.getElementById('material');
            let idMaterial = document.getElementById('idmaterial');
            material.value = `${data.material.CodigoMaterial} - ${data.material.Material} - ${data.material.Dimension} - ${data.material.Calidad}`;
            idMaterial.value = data.material.CodigoMaterial;
            completarColadas(data.coladaMaterial);
            swal({
                title: "¡El material se ha agregado con éxito!",
                icon: "success",
                button: "Aceptar",
            });

        })

}



function eliminarTarea(id) {
    swal({
        title: "¿Desea eliminar la tarea?",
        /* text: "Once deleted, you will not be able to recover this imaginary file!", */
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("¡La tarea ha sido eliminada!", {
                    icon: "success",
                    button: "Aceptar",
                });

                let parent = document.getElementById(id).parentNode;
                parent.removeChild(document.getElementById(id));

            }
        });


}
/* function modificarTarea() {
    alert('id');
} */
/* function setearId() {
    let filas = document.getElementsByClassName("filasDeTareas");
    for (let i = 0; i < filas.length; i++) {
        filas[i].id = `fila${i}`;
    }
} */


const limpiarDatos = () => {
    let material = document.getElementById('material');
    material.value = '';
    let longcorte = document.getElementById('longcorte');
    longcorte.value = ''
    let contenidotabla = document.getElementById('contenidotabla');
    contenidotabla.innerHTML = '';
    let tareas = document.getElementById('tareas');
    tareas.innerHTML = '';
    let cantidadNecesaria = document.getElementById('cantidad-necesaria');
    cantidadNecesaria.value = '';
}

const completarColadas = (data) => {
    let contenidotabla = document.getElementById('contenidotabla');
    let tablacoladas = '';
    data.forEach(colada => {
        tablacoladas += `<tr>`;
        tablacoladas += `<td> <input type="radio" name="nameradio" value="${colada.Colada}"> ${colada.Colada} </td>`;
        tablacoladas += `<td> ${colada.Stock} </td>`;
        tablacoladas += `</tr>`;
    })
    contenidotabla.innerHTML = tablacoladas;
}

const completarTareas = (data) => {
    let tareas = document.getElementById('tareas');
    let tablatareas = '';
    data.forEach(tarea => {
        let id = tarea.Tarea.trim();
        /* console.log(id); */
        tablatareas += `<tr class="filasDeTarea" id= "${id}">`;
        tablatareas += `<td class="celdasincorrectas">${tarea.Tarea}</td>`;
        tablatareas += `<td class="celdasincorrectas">${tarea.Maquina}</td>`;
        tablatareas += `<td class="celdasincorrectas">Operario</td>`;
        tablatareas += `<td class="celdasincorrectas">${tarea.Supervisor}</td>`;
        tablatareas += `<td class="celdasincorrectas">${tarea.Horas}</td>`;
        tablatareas += `<td class="celdasincorrectas"><button type="button" class="btn btn-warning" id= "modificarTarea" onclick="modificarTareas('${tarea.Tarea.trim()}','${tarea.Maquina}');"> Modificar</button> `;
        tablatareas += ` <button type="button" class="btn btn-danger id="eliminar" onclick="eliminarTarea('${id}');"> Eliminar </button>`;
        tablatareas += `</td></tr>`;

    });

    tablatareas += `<tr id= "filaboton"><td><button type="button" class="btn btn-primary" id="agregartarea">Agregar tarea</button> </td>`;
    tablatareas += `<td colspan="5" style="text-align:center"><input type="checkbox"> PREDETERMINAR TAREAS</td></tr>`;
    tareas.innerHTML = tablatareas;
}
const completarMaterial = (data) => {
    let tbodymodal = document.getElementById('tbodymodal');
    let tabla = '';
    data.forEach(material => {
        tabla += `<tr>`;
        tabla += `<td> ${material.CodigoMaterial} </td>`;
        tabla += `<td> ${material.Material} - ${material.Dimension} - ${material.Calidad}</td>`;
        tabla += `<td> Materiales </td>`;
        tabla += `<td><button type="button" class="btn btn-info" data-dismiss="modal" onclick="agregarMaterial('${material.CodigoMaterial}');">Agregar</button></td>`;
        tabla += `</tr>`;
    })
    tbodymodal.innerHTML = tabla;
}
const agregarTareaModal = () => {

    const datos = new FormData(document.getElementById('formulario-modaltarea'));

    let tarea = datos.get('tareaModal');
    tarea = JSON.parse(tarea);

    let maquina = datos.get('maquina');
    maquina = JSON.parse(maquina);

    let operario = datos.get('operario');
    operario = JSON.parse(operario);

    let supervisor = datos.get('supervisor')
    supervisor = JSON.parse(supervisor);

    let horaminuto = document.getElementById('horaminuto').value;

    let id = tarea.Tarea.trim();
    let filas = document.getElementsByClassName("filasDeTarea");



    if (verificarTareaExistente(filas, id) === true) {
        event.stopPropagation();
        swal({
            title: "¡La tarea ya existe!",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else if (maquina.NombreMaquina === '(Ninguna)') {
        event.stopPropagation();
        swal({
            title: "¡Debe elegir una maquina!",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else if (operario.NroLegajo === '000') {
        event.stopPropagation();
        swal({
            title: "¡Debe elegir un operario!",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else if (horaminuto === '') {
        event.stopPropagation();
        swal({
            title: "¡Debe ingresar un tiempo estimado!",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else if (horaminuto[2] != ':' || horaminuto.length != 5 || isNaN(horaminuto[0]) || isNaN(horaminuto[1]) || isNaN(horaminuto[3]) || isNaN(horaminuto[4])) {
        event.stopPropagation();
        swal({
            title: "¡Formato de tiempo incorrecto! Ejemplo: 03:45",
            icon: "warning",
            button: "Aceptar",
        });
    }

    else {

        tablatareas = `<tr class="filasDeTarea" id="${id}">`;
        tablatareas += `<td>${tarea.Tarea}</td>`;
        tablatareas += `<td>${maquina.NombreMaquina}</td>`;
        tablatareas += `<td>${operario.NroLegajo} - ${operario.ApellidoNombre}</td>`;
        tablatareas += `<td>${supervisor.NroLegajo} - ${supervisor.ApellidoNombre}</td>`;
        tablatareas += `<td>${horaminuto}</td>`;
        tablatareas += `<td><button type="button" class="btn btn-info" id="modificarTarea" onclick="modificarTareas2('${tarea.Tarea}','${maquina.CodMaquina}','${operario.NroLegajo}','${supervisor.NroLegajo}','${horaminuto}');" >Modificar</button>`;
        tablatareas += `<button type="button" class="btn btn-danger" id="eliminar" onclick="eliminarTarea('${id}');">Eliminar</button>`;
        tablatareas += `</td></tr>`;
        let boton = document.getElementById('filaboton');
        boton.insertAdjacentHTML('beforebegin', tablatareas);

        swal({
            title: "¡La tarea se ha agregado con éxito!",
            icon: "success",
            button: "Aceptar",
        });
        /* onclick="modificarTareas2('${fila.id}','${comboMaquinas.CodMaquina}','${comboOperario.NroLegajo}','${comboSupervisor.NroLegajo}','${horas}');" */
    }
}

function verificarTareaExistente(filas, id) {
    let flag = false;
    for (let i = 0; i < filas.length; i++) {
        if (filas[i].id === id) {
            flag = true;
        }
    }
    return flag;

}
   /*  $(document).ready(function() {
$('#piezas').select2();
});  */


