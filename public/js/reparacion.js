

const cargarTabla = () => {
    let conjunto = document.getElementById('conjunto').value;
    const datos = new FormData(document.getElementById('formulario'));

    fetch('/admin/reparacion/conjuntos', {
        method: 'POST',
        body: datos
    })
        .then(res => res.json())
        .then(data => {

            armarTabla(data.conjuntoArticulos, data.piezasConjunto, data.conjuntoGomas, data.nuevaor);
        })
}


const armarTabla = (articulos, piezas, gomas, or) => {
    let divtablatareas = document.getElementById('divtablatareas');
    let conjunto = document.getElementById('conjunto').value;
    let nor = document.getElementById('nor');
    nor.value = or;
    let cadena = '';
    cadena += `<u>Orden de reparación</u>: ${or} <br>`
    cadena += '<u>Fecha: </u> <br>';
    cadena += `<u>Herramienta</u>: ${conjunto} <br>`;
    cadena += `<u>Número</u>: ...........<br>`;
    cadena += `<u>Pasos a seguir</u>: <br>`;
    cadena += `1 - Limpieza <br>`;
    cadena += `2 - Desarmado<br>`;
    cadena += `3 - Estado de piezas<br>`;

    cadena += `<table class="table-striped table table-bordered table-scroll3">`;
    cadena += `<thead>`;
    cadena += `<tr>`;
    cadena += `<th scope="col">Código</th>`;
    cadena += `<th scope="col">Descripción</th>`;
    cadena += `<th scope="col">Nro OC</th>`;
    cadena += `<th scope="col">Cambiar</th>`;
    cadena += `<th scope="col">Cantidad</th>`;
    cadena += `</tr>`;
    cadena += `</thead>`;
    cadena += `<tbody>`;
    if (gomas.length > 0) {
        gomas.forEach(goma => {
            cadena += `<tr>`;
            cadena += `<td>${goma.CodigoInterno}</td>`;
            cadena += `<td>${goma.CodigoGoma} - ${goma.DiametroInterior} - ${goma.DiametroExterior}</td>`;
            cadena += `<td></td>`;
            cadena += `<td>Si No</td>`;
            cadena += `<td>${goma.Cantidad}</td>`;
            cadena += `</tr>`;
        })
    }

    if (articulos.length > 0) {
        articulos.forEach(articulo => {
            cadena += `<tr>`;
            cadena += `<td>${articulo.CodArticulo}</td>`;
            cadena += `<td>${articulo.Descripcion}</td>`;
            cadena += `<td></td>`;
            cadena += `<td>Si No</td>`;
            cadena += `<td>${articulo.Cantidad}</td>`;
            cadena += `</tr>`;
        })
    }
    if (piezas.length > 0) {
        piezas.forEach(pieza => {
            cadena += `<tr>`;
            cadena += `<td>${pieza.codigoPieza}</td>`;
            cadena += `<td>${pieza.NombrePieza}</td>`;
            cadena += `<td></td>`;
            cadena += `<td>Si No</td>`;
            cadena += `<td>${pieza.Cantidad}</td>`;
            cadena += `</tr>`;
        })
    }

    cadena += `</tbody>`;
    cadena += `</table>`;
    cadena += `4 - Armado <br>`;
    cadena += `5 - Prueba de funcionamiento<br>`;
    cadena += `6 - Pintado<br>`;
    cadena += `7 - Trazabilidad<br>`;
    cadena += `<button type="button" class ="btn btn-success" onclick= "agregarOR();">Agregar orden</button> <button type="button" class ="btn btn-info">PDF</button>`;
    divtablatareas.innerHTML = cadena;
}
const agregarOR = () => {

    swal({
        title: "¿Desea agregar una nueva orden de reparación?",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        dangerMode: true,
    })
        .then((willAdd) => {
            if (willAdd) {
                enviarDatos();
            }
        });
}

const enviarDatos = () => {
    const datos = new FormData(document.getElementById('formulario'));


    fetch('/admin/reparacion/guardar', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data === 'ok') {
                swal({
                    title: "¡Se ha agregado una nueva orden de reparación!",
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
