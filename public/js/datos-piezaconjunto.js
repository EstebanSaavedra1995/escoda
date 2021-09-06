function completarDatos(piezas, conjuntos) {
    let tbodymodal = document.getElementById('tablabody');
    let tabla = '';
    if (piezas.length > 0) {
        piezas.forEach(pieza => {
            tabla += `<tr>`;
            tabla += `<td>${pieza.CodPieza} </td>`;
            tabla += `<td>${pieza.NombrePieza}</td>`;
            tabla += `<td style="width: 30px">${pieza.Medida}</td>`;
            tabla += `<td style="width: 30px">Pieza</td>`;
            tabla += `<td>${pieza.Croquis}</td>`;
            tabla += `<td style="width: 30px">${pieza.Instruccion}</td>`;

            tabla += `<td><button type="button" class="btn btn-info" onclick="modificarCP('${pieza.CodPieza}', 'pieza');">Modificar</button> 
            <button type="button" class="btn btn-danger">Eliminar</button></td>`;
            tabla += `</tr>`;
        })
    }
    if (conjuntos.length > 0) {
        conjuntos.forEach(conjunto => {
            tabla += `<tr>`;
            tabla += `<td>${conjunto.CodPieza} </td>`;
            tabla += `<td>${conjunto.NombrePieza}</td>`;
            tabla += `<td style="width: 30px">${conjunto.Medida}</td>`;
            tabla += `<td style="width: 30px">Conjunto</td>`;
            tabla += `<td>${conjunto.Croquis}</td>`;
            tabla += `<td style="width: 30px">${conjunto.Instruccion}</td>`;
            tabla += `<td><button type="button" class="btn btn-info" onclick="modificarCP('${conjunto.CodPieza}', 'conjunto');"> Modificar</button> 
            <button type="button" class="btn btn-danger">Eliminar</button></td>`;
            tabla += `</tr>`;
        })
    }
    tbodymodal.innerHTML = tabla;
}
document.getElementById('buscador').addEventListener('keyup', function (e) {
    e.preventDefault();
    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/datos/buscarpiezas', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {

            completarDatos(data[0], data[1]);
        })
}, true)

const modificarCP = (conjunto, tipo) => {
    const datos = new FormData(document.getElementById('formulario2'));
    datos.append('idCP', conjunto);
    datos.append('tipo', tipo);
    fetch('/admin/datos/show', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            modalModificar(data.dato, data.tipo);

        })


}



$(document).ready(function () {
    $('#btnAgregar').click(function () {
        $('#modalAgregarPC').modal('show');
    })
})

function enviarDatos() {
    let codigo = document.getElementById('codigo').value;
    let descripcion = document.getElementById('descripcion').value;
    let medida = document.getElementById('medida').value;
    let instruccion = document.getElementById('instruccion').value;
    if (codigo.length <= 0) {
        event.stopPropagation();
        swal({
            title: "¡Ingrese un código!",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else if (descripcion.length <= 0) {
        event.stopPropagation();
        swal({
            title: "¡Ingrese una descripción!",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else if (medida.length <= 0) {
        event.stopPropagation();
        swal({
            title: "¡Ingrese una medida!",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else if (instruccion.length <= 0) {
        event.stopPropagation();
        swal({
            title: "¡Ingrese una instrucción!",
            icon: "warning",
            button: "Aceptar",
        });
    } else {
        enviar();
    }
}

const enviar = () => {
    const datos = new FormData(document.getElementById('formulario2'));
    fetch('/admin/datos/store', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data === 'ok') {
                $('#modalAgregarPC').modal('hide');
                swal({
                    title: "¡Se ha agregado una pieza o conjunto con éxito!",
                    icon: "success",
                    button: "Aceptar",
                });
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                swal({
                    title: "¡El código ya existe!",
                    icon: "warning",
                    button: "Aceptar",
                });
            }

        })
}
const modalModificar = (cp, tipoCP) => {
    let codigo = document.getElementById('codigo2');
    codigo.value = cp.CodPieza;
    let descripcion = document.getElementById('descripcion2');
    descripcion.value = cp.NombrePieza;
    let medida = document.getElementById('medida2');
    medida.value = cp.Medida;
    let tipo = document.getElementById('tipo2');
    tipo.value = tipoCP;
    let croquis = document.getElementById('croquis2');
    croquis.value = cp.Croquis;
    let instruccion = document.getElementById('instruccion2');
    instruccion.value = cp.Instruccion;
    $('#modalModificarPC').modal('show');
}
const actualizar = () => {
    let codigo = document.getElementById('codigo2').value;
    let descripcion = document.getElementById('descripcion2').value;
    let medida = document.getElementById('medida2').value;
    let instruccion = document.getElementById('instruccion2').value;
    if (codigo.length <= 0) {
        event.stopPropagation();
        swal({
            title: "¡Ingrese un código!",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else if (descripcion.length <= 0) {
        event.stopPropagation();
        swal({
            title: "¡Ingrese una descripción!",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else if (medida.length <= 0) {
        event.stopPropagation();
        swal({
            title: "¡Ingrese una medida!",
            icon: "warning",
            button: "Aceptar",
        });
    }
    else if (instruccion.length <= 0) {
        event.stopPropagation();
        swal({
            title: "¡Ingrese una instrucción!",
            icon: "warning",
            button: "Aceptar",
        });
    } else {
        enviarModificacion();

    }
}
const enviarModificacion = () => {
    const datos = new FormData(document.getElementById('formulario3'));
    fetch('/admin/datos/update', {
        method: "POST",
        body: datos
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data === 'ok') {
                $('#modalModificarPC').modal('hide');
                swal({
                    title: "¡Se ha modificado una pieza o conjunto con éxito!",
                    icon: "success",
                    button: "Aceptar",
                });
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                swal({
                    title: "¡Ocurrió un error!",
                    icon: "warning",
                    button: "Aceptar",
                });
            }
        })
}