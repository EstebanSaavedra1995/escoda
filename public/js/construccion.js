
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
                console.log(data);
                let material = document.getElementById('material');
                material.value = `${data.material.CodigoMaterial} - ${data.material.Material} - ${data.material.Dimension} - ${data.material.Calidad}`;
                let longcorte = document.getElementById('longcorte');
                longcorte.value = data.materialPieza.longitudCorte;
                let contenidotabla = document.getElementById('contenidotabla');
                let tablacoladas='';
                data.coladaMaterial.map(colada => {
                    tablacoladas += `<tr>`;
                    tablacoladas += `<td> <input type="radio" name= "radio"> ${colada.Colada} </td>`;
                    tablacoladas += `<td> ${colada.Stock} </td>`;
                    tablacoladas += `</tr>`;
                })
                contenidotabla.innerHTML = tablacoladas;

                let tareas = document.getElementById('tareas');
                let tablatareas='';
                data.piezaTarea.map(tarea => {
                    tablatareas += `<tr>`;
                    tablatareas += `<td> ${tarea.Tarea} </td>`;
                    tablatareas += `<td> ${tarea.Maquina} </td>`;
                    tablatareas += `<td> Operario </td>`;
                    tablatareas += `<td> ${tarea.Supervisor} </td>`;
                    tablatareas += `<td> ${tarea.Horas} </td>`;
                    tablatareas += `</tr>`;
                })
                tareas.innerHTML = tablatareas;

            }
        })
}, true)



$(document).ready(function(){
    $('#buscar').click(function(){
        $('#modal').modal('show');
    })
})
const limpiarDatos = () => {
    let material = document.getElementById('material');
    material.value = '';
    let longcorte = document.getElementById('longcorte');
    longcorte.value = ''
    let contenidotabla = document.getElementById('contenidotabla');
    contenidotabla.innerHTML = '';
}