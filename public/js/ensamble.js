

const cargarTabla = () => {
    let conjunto = document.getElementById('conjunto').value;
    const datos = new FormData(document.getElementById('formulario'));

    fetch('/admin/ensamble/conjuntos', {
        method: 'POST',
        body: datos
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            armarTabla(data.conjuntoArticulos, data.piezasConjunto, data.conjuntoGomas, data.nuevaOE, data.numero);
        })
}


const armarTabla = (articulos, piezas, gomas, oe, numero) => {
    let divtablatareas = document.getElementById('divtablatareas');
    let conjunto = document.getElementById('conjunto').value;
    let noe = document.getElementById('noe');
    noe.value = oe;
    let cadena = '';
    cadena += `<u>Orden de ensamble</u>: ${oe} <br>`
    cadena += `<u>Fecha:</u> ${formatDate()} <br>`;
    cadena += `<u>Herramienta</u>: ${conjunto} <br>`;
    cadena += `<u>Número</u>: <input type="number" name="numero" id="numero" value="${numero}"><br>`;
    cadena += `<u>Pasos a seguir</u>: <br>`;
    cadena += `1 - Listado de piezas<br>`;
    cadena += `<table class="table-striped table table-bordered table-scroll3">`;
    cadena += `<thead>`;
    cadena += `<tr>`;
    cadena += `<th scope="col">Código</th>`;
    cadena += `<th scope="col">Descripción</th>`;
    cadena += `<th scope="col">Nro OC</th>`;
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
            cadena += `<td>${pieza.Cantidad}</td>`;
            cadena += `</tr>`;
        })
    }

    cadena += `</tbody>`;
    cadena += `</table>`;
    cadena += `2 - Armado <br>`;
    cadena += `3 - Prueba de funcionamiento<br>`;
    cadena += `4 - Pintado<br>`;
    cadena += `5 - Trazabilidad<br>`;
    cadena += `<button type="button" class ="btn btn-success" onclick= "agregarOE();">Agregar orden</button> `
    cadena += `<button type="button" class ="btn btn-info">PDF</button>`;
    divtablatareas.innerHTML = cadena;
}
const agregarOE = () => {

    swal({
        title: "¿Desea agregar una nueva orden de ensamble?",
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


    fetch('/admin/ensamble/guardar', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            
              if (data === 'ok') {
                  swal({
                      title: "¡Se ha agregado una nueva orden de ensamble pendiente!",
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
const formatDate = () => {
    var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [day, month, year].join('/');
}