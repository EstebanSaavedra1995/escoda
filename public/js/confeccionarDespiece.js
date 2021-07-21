

//Eventos de check para diferenciar pieza y conjunto
document.getElementById('ck1').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/confeccionardespiecepiezas', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {

            var conjunto = data['conjunto'];
            var piezaDeConjunto = data['conjunto'];
            //console.log(conjunto[1]);
            var datos = "";
            datos += '<option value="0"> </option>';
            var select = document.getElementById('piezas');
            select.innerHTML = "<option></option>";
            conjunto.forEach(e => {

                datos += '<option value="' + e.CodPieza + '">';
                datos += e.CodPieza + " - " + e.NombrePieza + " - " + e.Medida;
                datos += '</option>';
            });
            data = [];
            select.innerHTML = datos;


        })
}, true)

document.getElementById('ck2').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/confeccionardespiecepiezas', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            //alert(data);


            var datos = "";
            var select = document.getElementById('piezas');
            select.innerHTML = "<option></option>";
            datos += '<option value="0"> </option>';
            data['piezas'].forEach(e => {

                datos += '<option value="' + e.CodPieza + '">';
                datos += e.CodPieza + " - " + e.NombrePieza + " - " + e.Medida;
                datos += '</option>';
            });
            data = [];
            select.innerHTML = datos;

        })
}, true)
//predeterminar o guardar cambios en bd
document.getElementById('predeterminarbtn').addEventListener('click', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina
    var codigos = document.getElementsByClassName('tblCodigo');
    var tipo = document.getElementsByClassName('tblTipo');
    var cantidad = document.getElementsByClassName('tblCantidad');
    var conjunto = document.getElementById('piezas').value;
    //console.log((codigos[0] == null));
    if (codigos[0] == null) {
        swal("Aviso!", "No puede predeterminar la tabla vacia!");

    }
    else
    {
        var val = [];
        for (i = 0; i < codigos.length; i++) {
            let e = {
                id: codigos[i].value,
                tipo: tipo[i].value,
                cantidad: cantidad[i].value
            };
            val.push(e);
        }
        val = JSON.stringify(val);
        //console.log(val);
        const datos = new FormData(document.getElementById('formulario'));
        datos.append('valores', val);
        datos.append('conjunto', conjunto);
        
        fetch('/admin/confeccionardespiecepredeterminar', {
            method: 'POST',
            body: datos,
        })
            .then(res => res.json())
            .then(data => {
    
    
                //console.log(data);
                swal("Predeterminado con exito!", {
                    icon: "success",
                });
    
    
            })
    }
    
}, true)


//llenar la tabla
document.getElementById('piezas').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/confeccionardespiecetabla', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {




            let datos = "";
            datos += `<thead><tr class="">`;
            datos += `<td id="asd" scope="col" class="table-primary">Tipo</td>`;
            datos += `<td scope="col" class="table-primary">Descripción</td>`;
            datos += `<td scope="col" class="table-primary">Cantidad</td>`;
            datos += `<td scope="col" class="table-primary">Accion</td>`;
            datos += `</tr></thead>`;

            var tabla = document.getElementById('tabla');
            var ck1 = document.getElementById('ck1');

            if (ck1.checked) {

                data.forEach(e => {
                    switch (e.tipo) {
                        case 'pieza':
                            datos += `<tr id="${e.pieza.CodPieza}" class="" onclick=""><td scope="col" class=""> ${e.tipo} </td>`;
                            datos += `<input type="hidden" class="tblCodigo" value="${e.pieza.CodPieza}"> `;
                            datos += `<input type="hidden" class="tblTipo" value="${e.tipo}"> `;
                            datos += `<input type="hidden" class="tblCantidad" value="${e.cantidad}"> `;

                            datos += `<td scope="col" > ${e.pieza.CodPieza} - ${e.pieza.NombrePieza} - ${e.pieza.Medida} </td>`;
                            datos += `<td scope="col" class="">${e.cantidad}</td>`;
                            datos += `<td scope="col" class=""><button type="button" class="btn btn-primary " id="" onclick="eliminar('${e.pieza.CodPieza}');">Eliminar</button></td>`;
                            datos += '</tr>';
                            break;
                        case 'articulo':
                            datos += `<tr id="${e.articulo.CodArticulo}" class="" onclick=""><td scope="col" class=""> ${e.tipo} </td>`;
                            datos += `<input type="hidden" class="tblCodigo" value="${e.articulo.CodArticulo}"> `;
                            datos += `<input type="hidden" class="tblTipo" value="${e.tipo}"> `;
                            datos += `<input type="hidden" class="tblCantidad" value="${e.cantidad}"> `;
                            datos += `<td scope="col" > ${e.articulo.CodArticulo} - ${e.articulo.Descripcion} </td>`;
                            datos += `<td scope="col" class="">${e.cantidad}</td>`;
                            datos += `<td scope="col" class=""><button type="button" class="btn btn-primary " id="" onclick="eliminar('${e.articulo.CodArticulo}');">Eliminar</button></td>`;
                            datos += '</tr>';
                            break;
                        case 'goma':
                            datos += `<tr id="${e.goma.CodigoGoma}" class="" onclick=""><td scope="col" class=""> ${e.tipo} </td>`;
                            datos += `<input type="hidden" class="tblCodigo" value="${e.goma.CodigoGoma}"> `;
                            datos += `<input type="hidden" class="tblTipo" value="${e.tipo}"> `;
                            datos += `<input type="hidden" class="tblCantidad" value="${e.cantidad}">`;
                            datos += `<td scope="col" > ${e.goma.CodigoGoma} - ØI ${e.goma.DiametroInterior} - ØE ${e.goma.DiametroExterior} - h ${e.goma.Altura}</td>`;
                            datos += `<td scope="col" class="">${e.cantidad}</td>`;
                            datos += `<td scope="col" class=""><button type="button" class="btn btn-primary " id="" onclick="eliminar('${e.goma.CodigoGoma}');">Eliminar</button></td>`;
                            datos += '</tr>';
                            break;

                        default:
                    }


                });
                habilitarBotones('conjunto');
            } else {
                var material = data['material'];
                var cantidad = data['cantidad'];
                datos += `<tr id="${material.CodigoMaterial}" class=""><td scope="col" class=""> Material </td>`;
                datos += `<input type="hidden" id="id${material.CodigoMaterial}" class="tblCodigo" value="${material.CodigoMaterial}"> `;
                datos += `<input type="hidden" id="tipo${material.CodigoMaterial}" class="tblTipo" value="pieza"> `;
                datos += `<input type="hidden" id="cantidad${material.CodigoMaterial}" class="tblCantidad" value="${cantidad}"> `;
                datos += `<td scope="col" > ${material.CodigoMaterial} - ${material.Material} - ${material.Dimension} </td>`;
                datos += `<td scope="col" class="">${data['cantidad']}</td>`;
                datos += `<td scope="col" class=""><button type="button" class="btn btn-primary " id="" onclick="eliminar('${material.CodigoMaterial}');">Eliminar</button></td>`;
                datos += `</tr>`;
                habilitarBotones('pieza');
            }
            tabla.innerHTML = datos;
            //tabla.insertAdjacentHTML("beforeEnd",datos);

        })
}, true)

//Activar el modal
$(document).ready(function () {
    $('#materialbtn').click(function () {
        $('#modalmaterial').modal('show');
    })
})
$(document).ready(function () {
    $('#gomabtn').click(function () {
        $('#modalgoma').modal('show');
    })
})
$(document).ready(function () {
    $('#articulobtn').click(function () {
        $('#modalarticulo').modal('show');
    })
})
$(document).ready(function () {
    $('#piezabtn').click(function () {
        $('#modalpieza').modal('show');
    })
})
$(document).ready(function () {
    $('#addpiezabtn').click(function () {
        $('#modalAgregar').modal('show');
    })
})


//Funciones de agregar elementos

function agregarGoma(goma, i) {
    goma = JSON.parse(goma);
    var cantidadInput = document.getElementById('cantidadGomas' + i);
    var cantidad = cantidadInput.value;
    let datos = `<tr id="${goma.CodigoGoma}"><td>Goma</td>`;
    datos += `<input type="hidden" id="id${goma.CodigoGoma}" class="tblCodigo" value="${goma.CodigoGoma}"> `;
    datos += `<input type="hidden" id="tipo${goma.CodigoGoma}" class="tblTipo" value="goma"> `;
    datos += `<input type="hidden" id="cantidad${goma.CodigoGoma}" class="tblCantidad" value="${cantidad}"> `;
    datos += `<td value="${goma.CodigoGoma}">${goma.CodigoGoma} - ØI ${goma.DiametroInterior} - ØE ${goma.DiametroExterior} - h ${goma.Altura}</td>`
    datos += `<td value="${cantidad}">${cantidad}</td>`
    datos += `<td scope="col" class=""><button type="button" class="btn btn-primary " id="" onclick="eliminar('${goma.CodigoGoma}');">Eliminar</button></td></tr>`;
    var tabla = document.getElementById('tabla');
    cantidadInput.value = "";
    var existe = document.getElementById(goma.CodigoGoma);
    if (existe == null) {
        tabla.insertAdjacentHTML("beforeEnd", datos);
    } else {
        eliminarSinAlert(goma.CodigoGoma);
        tabla.insertAdjacentHTML("beforeEnd", datos);
    }
}

function agregarArticulo(articulo, i) {
    articulo = JSON.parse(articulo);
    var cantidadInput = document.getElementById('cantidadArticulos' + i);
    var cantidad = cantidadInput.value;
    let datos = `<tr id="${articulo.CodArticulo}"><td>Artículos Grales.</td>`;
    datos += `<input type="hidden" id="id${articulo.CodArticulo}" class="tblCodigo" value="${articulo.CodArticulo}"> `;
    datos += `<input type="hidden" id="tipo${articulo.CodArticulo}" class="tblTipo" value="articulo"> `;
    datos += `<input type="hidden" id="cantidad${articulo.CodArticulo}" class="tblCantidad" value="${cantidad}"> `;
    datos += `<td value="${articulo.CodArticulo}">${articulo.CodArticulo} -  ${articulo.Descripcion} </td>`
    datos += `<td value="${cantidad}">${cantidad}</td>`
    datos += `<td scope="col" class=""><button type="button" class="btn btn-primary " id="" onclick="eliminar('${articulo.CodArticulo}');">Eliminar</button></td></tr>`;
    var tabla = document.getElementById('tabla');
    cantidadInput.value = "";
    var existe = document.getElementById(articulo.CodArticulo);
    if (existe == null) {
        tabla.insertAdjacentHTML("beforeEnd", datos);
    } else {
        eliminarSinAlert(articulo.CodArticulo);
        tabla.insertAdjacentHTML("beforeEnd", datos);
    }
}
function agregarPieza(pieza, i) {
    pieza = JSON.parse(pieza);
    var cantidadInput = document.getElementById('cantidadPiezas' + i);
    var cantidad = cantidadInput.value;
    let datos = `<tr id="${pieza.CodPieza}"><td>Pieza</td>`;
    datos += `<input type="hidden" id="id${pieza.CodPieza}" class="tblCodigo" value="${pieza.CodPieza}"> `;
    datos += `<input type="hidden" id="tipo${pieza.CodPieza}" class="tblTipo" value="pieza"> `;
    datos += `<input type="hidden" id="cantidad${pieza.CodPieza}" class="tblCantidad" value="${cantidad}"> `;
    datos += `<td value="${pieza.CodPieza}">${pieza.CodPieza} -  ${pieza.NombrePieza} - ${pieza.Medida}</td>`
    datos += `<td value="${cantidad}">${cantidad}</td>`
    datos += `<td scope="col" class=""><button type="button" class="btn btn-primary " id="" onclick="eliminar('${pieza.CodPieza}');">Eliminar</button></td></tr>`;
    var tabla = document.getElementById('tabla');
    cantidadInput.value = "";
    //console.log(document.getElementById(pieza.CodPieza));
    var existe = document.getElementById(pieza.CodPieza);
    if (existe == null) {
        tabla.insertAdjacentHTML("beforeEnd", datos);
    } else {
        eliminarSinAlert(pieza.CodPieza);
        tabla.insertAdjacentHTML("beforeEnd", datos);
    }

}
function agregaMaterial(material, i) {
    material = JSON.parse(material);
    var cantidadInput = document.getElementById('cantidadMaterial' + i);
    var cantidad = cantidadInput.value;
    let datos = `<tr id="${material.CodigoMaterial}"><td>Material</td>`;
    datos += `<input type="hidden" id="id${material.CodigoMaterial}" class="tblCodigo" value="${material.CodigoMaterial}"> `;
    datos += `<input type="hidden" id="tipo${material.CodigoMaterial}" class="tblTipo" value="pieza"> `;
    datos += `<input type="hidden" id="cantidad${material.CodigoMaterial}" class="tblCantidad" value="${cantidad}"> `;
    datos += `<td value="${material.CodigoMaterial}">${material.CodigoMaterial} -  ${material.Material} - ${material.Dimension}</td>`
    datos += `<td value="${cantidad}">${cantidad}</td>`
    datos += `<td scope="col" class=""><button type="button" class="btn btn-primary " id="" onclick="eliminar('${material.CodigoMaterial}');">Eliminar</button></td></tr>`;
    var tabla = document.getElementById('tabla');
    cantidadInput.value = "";
    eliminarTodoSinAlert();
    tabla.insertAdjacentHTML("beforeEnd", datos);

}

//Habilita el boton agregar con al menos 1 unidad
function habilitarAgregar(tipo, i) {
    switch (tipo) {
        case 'M':
            var boton = document.getElementById(`addBtnM${i}`);
            boton.disabled = false;
            break;
        case 'P':
            var boton = document.getElementById(`addBtnP${i}`);
            boton.disabled = false;
            break;
        case 'A':
            var boton = document.getElementById(`addBtnA${i}`);
            boton.disabled = false;
            break;
        case 'G':
            var boton = document.getElementById(`addBtnG${i}`);
            boton.disabled = false;
            break;
        default:
    }
}
//HABILITA LOS BOTONES DE AGREGAR ELEMENTOS
function habilitarBotones(tipo) {
    var material= document.getElementById(`materialbtn`);
    var pieza= document.getElementById(`piezabtn`);
    var articulo= document.getElementById(`articulobtn`);
    var goma= document.getElementById(`gomabtn`);
    switch (tipo) {
        case 'vacio':
            material.disabled = true;
            pieza.disabled = true;
            articulo.disabled = true;
            goma.disabled = true;
            break;
        case 'conjunto':
            material.disabled = true;
            pieza.disabled = false;
            articulo.disabled = false;
            goma.disabled = false;
            break;
        case 'pieza':
            material.disabled = false;
            pieza.disabled = true;
            articulo.disabled = true;
            goma.disabled = true;
            break;
        default:
    }
}

function eliminar(id) {
    swal({
        title: "Seguro desea eliminar?",
        /* text: "Once deleted, you will not be able to recover this imaginary file!", */
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("El registro ha sido eliminado!", {
                    icon: "success",
                });

                let parent = document.getElementById(id).parentNode;
                parent.removeChild(document.getElementById(id));



            } else {
                /* swal("Your imaginary file is safe!"); */
            }
        });

}
function eliminarSinAlert(id) {
    let parent = document.getElementById(id).parentNode;
    parent.removeChild(document.getElementById(id));
}
function eliminarTodoSinAlert() {
    let datos = "";
    datos += `<thead><tr class="">`;
    datos += `<td scope="col" class="table-primary">Tipo</td>`;
    datos += `<td scope="col" class="table-primary">Descripción</td>`;
    datos += `<td scope="col" class="table-primary">Cantidad</td>`;
    datos += `<td scope="col" class="table-primary">Accion</td>`;
    datos += `</tr></thead>`;
    let tabla = document.getElementById('tabla');
    tabla.innerHTML = datos;
}
function eliminarTodo() {
    swal({
        title: "Seguro desea eliminar todo?",
        /* text: "Once deleted, you will not be able to recover this imaginary file!", */
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Los registros ha sido eliminados!", {
                    icon: "success",
                });
                let datos = "";
                datos += `<thead><tr class="">`;
                datos += `<td scope="col" class="table-primary">Tipo</td>`;
                datos += `<td scope="col" class="table-primary">Descripción</td>`;
                datos += `<td scope="col" class="table-primary">Cantidad</td>`;
                datos += `<td scope="col" class="table-primary">Accion</td>`;
                datos += `</tr></thead>`;
                let tabla = document.getElementById('tabla');
                tabla.innerHTML = datos;
            }
        });

}

$(document).ready(function () {
    $('#materialbtn').click(function () {
        $('#modalmaterial').modal('show');
    })
})

//AGREGAR A LA FILA CON OTRO MODAL
/* $(document).ready(function () {
    $('#agregarFinal').click(function () {
        var cantidadInput = document.getElementById('cantidadAgregar');
        var codPieza = document.getElementById('codPieza').value;
        var cantidad = cantidadInput.value;
        var tipo = document.getElementById('tipoAgregar').value;
        var descripcion =  document.getElementById('descripcionAgregar').value;
        let datos = `<tr><td>${tipo}</td>`;
        datos+= `<td value="${codPieza}">${descripcion}</td>`
        datos+= `<td value="${cantidad}">${cantidad}</td></tr>`
        var tabla = document.getElementById('tabla');
        cantidadInput.value="";
        tabla.insertAdjacentHTML("beforeEnd",datos);

    })
}) */

/* const agregarGoma = (Goma) => {
    const datos = new FormData(document.getElementById('formulario-modal'));
    datos.append('Goma',Goma);
    fetch('/admin/construccion/material', {
        method: 'POST',
        body: datos,
    })

        .then(res => res.json())
        .then(data => {
            let material = document.getElementById('material');
            material.value = `${data.Goma.CodigoMaterial} - ${data.Goma.Material} - ${data.Goma.Dimension} - ${data.Goma.Calidad}`;
            completarColadas(data.coladaMaterial);
        })

} */
/* document.getElementById('cantidad-realizar').addEventListener('change', function (e) {
    e.preventDefault();
    let cantidadNecesaria = document.getElementById('cantidad-necesaria');
    let cantidadRealizar = document.getElementById('cantidad-realizar');
    cantidadNecesaria.value = (cantidadRealizar.value * longcorte.value) / (1000);

}, true) */

