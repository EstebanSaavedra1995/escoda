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
            
            tabla += `<td><button type="button" class="btn btn-info" onclick="modificarP('${pieza.id}');"> 
            Modificar</button> <button type="button" class="btn btn-danger" onclick="eliminarP('${pieza.id}');">Eliminar</button></td>`;
            tabla += `</tr>`;
        })
    }
    if (conjuntos.length > 0){
        conjuntos.forEach(conjunto => {
            tabla += `<tr>`;
            tabla += `<td>${conjunto.CodPieza} </td>`;
            tabla += `<td>${conjunto.NombrePieza}</td>`;
            tabla += `<td style="width: 30px">${conjunto.Medida}</td>`;
            tabla += `<td style="width: 30px">Conjunto</td>`;
            tabla += `<td>${conjunto.Croquis}</td>`;
            tabla += `<td style="width: 30px">${conjunto.Instruccion}</td>`;
            tabla += `<td><button type="button" class="btn btn-info" onclick="eliminarP('${conjunto.id}');"> Modificar</button> 
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

const modificarC = (id) => {
    console.log('conjunto');
}
const eliminarC = (id) => {
    console.log('conjunto');
}

const modificarP = (id) => {
    console.log('pieza');
}
const eliminarP = (id) => {
    console.log('pieza');
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
    } else{
      enviar();
    }
}

const enviar = () =>{
    const datos = new FormData(document.getElementById('formulario2')); 
    fetch('/admin/datos/enviardatos', {
        method: 'POST',
        body: datos,
    })
    .then(res => res.json())
    .then(data =>{
        console.log(data);
        /* $('#modalAgregarPC').modal('hide'); */
    })
}