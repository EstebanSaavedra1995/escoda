
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
//Activar el modal para agregar tareas
/* $(document).on('click', 'agregarMaterial', function() {
    console.log('agregando con ajax')
}); */

//Paginator 



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
        tablatareas += `<tr>`;
        tablatareas += `<td> ${tarea.Tarea} </td>`;
        tablatareas += `<td> ${tarea.Maquina} </td>`;
        tablatareas += `<td> Operario </td>`;
        tablatareas += `<td> ${tarea.Supervisor} </td>`;
        tablatareas += `<td> ${tarea.Horas} </td>`;
        tablatareas += `<td><button type="button" class="btn btn-info">Modificar</button>`;
        tablatareas += `<button type="button" class="btn btn-danger">Eliminar</button>`;
        tablatareas += `</td></tr>`;
    })
    tablatareas += `<tr><td><button type="button" class="btn btn-primary" id="agregartarea">Agregar tarea</button> </td></tr>`;
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
const agregarTareaModal = () =>{
    const datos = new FormData(document.getElementById('formulario-modaltarea'));
    const tarea= datos.get('tareaModal');
    const maquina= JSON.parse(datos.get('maquina'));
    alert(maquina.json());
}
