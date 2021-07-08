
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
                let tabla='';
                data.coladaMaterial.map(colada => {
                    tabla += `<tr>`;
                    tabla += `<td> ${colada.Colada} </td>`;
                    tabla += `<td> ${colada.Stock} </td>`;
                    tabla += `</tr>`;
                })
                contenidotabla.innerHTML = tabla;
            }
        })
}, true)

const limpiarDatos = () => {
    let material = document.getElementById('material');
    material.value = '';
    let longcorte = document.getElementById('longcorte');
    longcorte.value = ''
    let contenidotabla = document.getElementById('contenidotabla');
    contenidotabla.innerHTML = '';
}

$(document).ready(function(){
    $('#')
})