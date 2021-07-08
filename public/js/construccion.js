
document.getElementById('piezas').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

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


//Activar el modal
$(document).ready(function () {
    $('#buscar').click(function () {
        $('#modal').modal('show');
    })
})
document.getElementById('cantidad-realizar').addEventListener('change', function (e) {
    e.preventDefault();
    let cantidadNecesaria = document.getElementById('cantidad-necesaria');
    let cantidadRealizar = document.getElementById('cantidad-realizar');
    cantidadNecesaria.value = (cantidadRealizar.value * longcorte.value) / (1000);

}, true)

//Funciones 
const agregarMaterial = (material) => {
   
    const datos = new FormData(document.getElementById('formulario-modal'));
    datos.append('material',material);
    fetch('/admin/construccion/material', {
        method: 'POST',
        body: datos,
    })

        .then(res => res.json())
        .then(data => {
            let material = document.getElementById('material');
            material.value = `${data.material.CodigoMaterial} - ${data.material.Material} - ${data.material.Dimension} - ${data.material.Calidad}`;
            completarColadas(data.coladaMaterial);
        })
      /*   alert(material); */
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
    tareas.innerHTML = tablatareas;
}