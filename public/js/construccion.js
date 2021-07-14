
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

/* $(document).on('click', '#eliminarTarea', function () {
    console.log('id');
    alert('id');
}); */

function eliminarTarea(id) {
    /* let parent = document.getElementById(id).parentNode;
    parent.removeChild(document.getElementById(id));
    setearId();
    alert(id);
    let parent = document.getElementById(id);
    alert(parent); */

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
/* the first parameters of function JSON.parse should be a String, and your 
data is a JavaScript object, so it will convert to a String [object object], 
you should use JSON.stringify before pass the data */
const completarTareas = (data) => {
    let tareas = document.getElementById('tareas');
    let tablatareas = '';
    for (let i = 0; i < data.length; i++) {
   /*  Horas: "00:00"
    Maquina: "06    SERRUCHO AUTOM├üTICO"
    Renglon: 1
    Supervisor: "461    Rodriguez Daniel"
    Tarea: "Corte"
    codigoPieza: "Ab05 501" */
        let id = `${data[i].Horas} ${data[i].horas} ${data[i].horas} ${data[i].horas} ${data[i].horas}`
        tablatareas += `<tr class="filasDeTareas">`;
        tablatareas += `<td> ${data[i].Tarea} </td>`;
        tablatareas += `<td> ${data[i].Maquina} </td>`;
        tablatareas += `<td> Operario </td>`;
        tablatareas += `<td> ${data[i].Supervisor} </td>`;
        tablatareas += `<td> ${data[i].Horas} </td>`;
        tablatareas += `<td><button type="button" class="btn btn-info" onclick="modificarTarea();">Modificar</button>`;
        tablatareas += `<button type="button" class="btn btn-danger id="eliminar" onclick="eliminarTarea();"> Eliminar </button>`;
       /*  tablatareas += `<button type="button" class="btn btn-danger id="eliminar" onclick="eliminarTarea('fila${i}');"> Eliminar </button>`; */
        tablatareas += `</td></tr>`;
        console.log(data[i]);
        
    }
    console.log(data);
    tablatareas += `<tr id= "filaboton"><td><button type="button" class="btn btn-primary" id="agregartarea">Agregar tarea</button> </td></tr>`;
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
    let cantidadFilas = document.getElementsByClassName("filasDeTareas").length;
    const datos = new FormData(document.getElementById('formulario-modaltarea'));

    let tarea = datos.get('tareaModal');
    tarea = JSON.parse(tarea);

    let maquina = datos.get('maquina');
    maquina = JSON.parse(maquina);

    let operario = datos.get('operario');
    operario = JSON.parse(operario);

    let supervisor = datos.get('supervisor')
    supervisor = JSON.parse(supervisor);

    tablatareas = `<tr class="filasDeTareas" id="fila${cantidadFilas}">`;
    tablatareas += `<td> ${tarea.Tarea}</td>`;
    tablatareas += `<td> ${maquina.NombreMaquina} </td>`;
    tablatareas += `<td> ${operario.NroLegajo} ${operario.ApellidoNombre} </td>`;
    tablatareas += `<td> ${supervisor.NroLegajo} ${supervisor.ApellidoNombre} </td>`;
    tablatareas += `<td> 00:00 </td>`;
    tablatareas += `<td><button type="button" class="btn btn-info" onclick="modificarTarea()"; >Modificar</button>`;
    tablatareas += `<button type="button" class="btn btn-danger" id="eliminar" onclick="eliminarTarea('fila${cantidadFilas}');">Eliminar</button>`;
    tablatareas += `</td></tr>`;
    let boton = document.getElementById('filaboton');
    boton.insertAdjacentHTML('beforebegin', tablatareas);


}
