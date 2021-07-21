
//Cada vez que selecciona una pieza en el selector
document.getElementById('piezas').addEventListener('change', function (e) {
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
                let longcorte = document.getElementById('longcorte');
                longcorte.value = data.materialPieza.longitudCorte;
                let cantidadNecesaria = document.getElementById('cantidad-necesaria');
                let cantidadRealizar = document.getElementById('cantidad-realizar');
                cantidadNecesaria.value = (cantidadRealizar.value * longcorte.value) / (1000);
                completarColadas(data.coladaMaterial);
                completarTareas(data.piezaTarea);
            }
        })
}, true)

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
                option.disabled=true;
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

function modificarTareas2(tarea, maquina, operario, supervisor,horas) {
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
            let horasminutos= document.getElementById('modificarhoraminuto');
            horasminutos.value= horas;
            console.log(horasminutos);

            idTareaModifcar.value = tarea;
            data.tareas.forEach(tareas => {
                let option = document.createElement('option');
                str = JSON.stringify(tareas); //IMPORTANTEEE
                option.innerHTML = tareas.Tarea.trim(); //sacamos espacios de la lista de tareas de la base
                if (option.text === tarea) {
                    option.selected = true;
                }
                option.disabled=true;
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
    
    let horas= document.getElementById('modificarhoraminuto').value;


    let idTareaModifcar = document.getElementById('idTareaModificar').value;
    let fila = document.getElementById(idTareaModifcar);
    fila.innerHTML = '';
    fila.id= comboTareas.Tarea.trim();

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
    let botones = `<button type="button" class="btn btn-info" id= "modificarTarea2" onclick="modificarTareas2('${fila.id}','${comboMaquinas.CodMaquina}','${comboOperario.NroLegajo}','${comboSupervisor.NroLegajo}','${horas}');"> Modificar</button>`;
    botones += `<button type="button" class="btn btn-danger id="eliminar" onclick="eliminarTarea('${fila.id}');"> Eliminar </button>`;
    celda6.innerHTML = botones;
    fila.appendChild(celda6);

    /*  console.log(JSON.parse(comboMaquinas)); //IMPORTANTEEE */

}
$idbtnModificarTarea.on('click', realizarModificacion);

//Cada vez que se cambie el valor de cantidad a realizar, la multiplique por la longitud de corte y lo ponga en cantidad necesaria
document.getElementById('cantidad-realizar').addEventListener('change', function (e) {
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
            material.value = `${data.material.CodigoMaterial} - ${data.material.Material} - ${data.material.Dimension} - ${data.material.Calidad}`;
            completarColadas(data.coladaMaterial);
            /* alert(data); */
        })
    /*  alert(material); */
}

/* $(document).on('click', '#eliminarTarea', function () {
    console.log('id');
    alert('id');
}); */

function eliminarTarea(id) {
    





    let parent = document.getElementById(id).parentNode;
    parent.removeChild(document.getElementById(id));
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
        tablacoladas += `<td> <input type="radio" name= "radio"> ${colada.Colada} </td>`;
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
        tablatareas += `<td> ${tarea.Tarea} </td>`;
        tablatareas += `<td> ${tarea.Maquina} </td>`;
        tablatareas += `<td> Operario </td>`;
        tablatareas += `<td> ${tarea.Supervisor} </td>`;
        tablatareas += `<td> ${tarea.Horas} </td>`;
        tablatareas += `<td><button type="button" class="btn btn-info" id= "modificarTarea" onclick="modificarTareas('${tarea.Tarea.trim()}','${tarea.Maquina}');"> Modificar</button>`;
        tablatareas += `<button type="button" class="btn btn-danger id="eliminar" onclick="eliminarTarea('${id}');"> Eliminar </button>`;
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

    let horaminuto= document.getElementById('horaminuto').value;

    let id = tarea.Tarea.trim();
    let filas = document.getElementsByClassName("filasDeTarea");

    if (verificarTareaExistente(filas, id) === true) {
        return alert('Existe la tarea');
    } else {
        //AGREGAR en 390 mas parametros para la funcion modificarTareas!!!
        console.log(horaminuto);
        tablatareas = `<tr class="filasDeTarea" id="${id}">`;
        tablatareas += `<td> ${tarea.Tarea}</td>`;
        tablatareas += `<td> ${maquina.NombreMaquina} </td>`;
        tablatareas += `<td> ${operario.NroLegajo} ${operario.ApellidoNombre} </td>`;
        tablatareas += `<td> ${supervisor.NroLegajo} ${supervisor.ApellidoNombre} </td>`;
        tablatareas += `<td> ${horaminuto}</td>`;
        tablatareas += `<td><button type="button" class="btn btn-info" id="modificarTarea" onclick="modificarTareas2('${tarea.Tarea}','${maquina.CodMaquina}','${operario.NroLegajo}','${supervisor.NroLegajo}','${horaminuto}');" >Modificar</button>`;
        tablatareas += `<button type="button" class="btn btn-danger" id="eliminar" onclick="eliminarTarea('${id}');">Eliminar</button>`;
        tablatareas += `</td></tr>`;
        let boton = document.getElementById('filaboton');
        boton.insertAdjacentHTML('beforebegin', tablatareas);
        /* onclick="modificarTareas2('${fila.id}','${comboMaquinas.CodMaquina}','${comboOperario.NroLegajo}','${comboSupervisor.NroLegajo}','${horas}');" */
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


}