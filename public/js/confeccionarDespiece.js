

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
        console.log(conjunto[1]);
        var datos = "";
        datos+='<option value="0"> </option>';
        var select = document.getElementById('piezas');
        select.innerHTML = "<option></option>";
        conjunto.forEach(e => {
            
            datos+='<option value="' + e.CodPieza +'">'; 
            datos+= e.CodPieza+" - "+ e.NombrePieza+" - "+e.Medida ; 
            datos+='</option>'; 
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
            data.forEach(e => {
                datos+='<option value="0"> </option>'; 
                datos+='<option value="' + e.CodPieza +'">'; 
                datos+= e.CodPieza+" - "+ e.NombrePieza+" - "+e.Medida ; 
                datos+='</option>'; 
            });
            data = [];
            select.innerHTML = datos;
       
        })
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
            datos +=`<thead><tr class="">`;
            datos +=`<td scope="col" class="table-primary">Tipo</td>`;
            datos +=`<td scope="col" class="table-primary">Descripción</td>`;
            datos +=`<td scope="col" class="table-primary">Cantidad</td>`;
            datos +=`</tr></thead>`;

            var tabla = document.getElementById('tabla');
            var ck1 = document.getElementById('ck1');
            console.log(data);
           
            if(ck1.checked){
            data.forEach(e => {
                datos+=`<tr id="${e.CodPieza}" class="" onclick=""><td scope="col" class=""> pieza </td>`; 
                datos+=`<td scope="col" class="" value="${e.CodPieza}"> ${e.CodPieza} - ${e.NombrePieza} - ${e.Medida} </td>` ; 
                datos+= '<td scope="col" class="">'+'</td>'; 
                datos+='</tr>'; 

            });
            }else{
               
                datos+=`<tr id="${data.CodigoMaterial}" class=""><td scope="col" class=""> Material </td>`; 
                datos+=`<td scope="col" class="" value="${data.CodigoMaterial}"> ${data.CodigoMaterial} - ${data.Material} - ${data.Dimension} </td>`; 
                datos+= `<td scope="col" class=""></td>`; 
                datos+=`</tr>`; 
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

function agregarGoma(goma){    
    goma = JSON.parse(goma);
    var cantidadInput = document.getElementById('cantidadGomas');
    var cantidad = cantidadInput.value; 
    let datos = `<tr><td>Goma</td>`;
    datos+= `<td value="${goma.CodigoGoma}">${goma.CodigoGoma} - ØI ${goma.DiametroInterior} - ØE ${goma.DiametroExterior} - h ${goma.Altura}</td>`
    datos+= `<td value="${cantidad}">${cantidad}</td></tr>`
    var tabla = document.getElementById('tabla');
    cantidadInput.value="";
    tabla.insertAdjacentHTML("beforeEnd",datos);
}

function agregarArticulo(articulo){    
    articulo = JSON.parse(articulo);
    var cantidadInput = document.getElementById('cantidadArticulos');
    var cantidad = cantidadInput.value; 
    let datos = `<tr><td>Artículos Grales.</td>`;
    datos+= `<td value="${articulo.CodArticulo}">${articulo.CodArticulo} -  ${articulo.Descripcion} </td>`
    datos+= `<td value="${cantidad}">${cantidad}</td></tr>`
    var tabla = document.getElementById('tabla');
    cantidadInput.value="";
    tabla.insertAdjacentHTML("beforeEnd",datos);
}
function agregarPieza(pieza){
/*  pieza = JSON.parse(pieza);   
    var tipo = document.getElementById('tipoAgregar');
    tipo.innerHTML = "Pieza";
    tipo.value= "Pieza";
    var descripcion = document.getElementById('descripcionAgregar');
    descripcion.innerHTML = `${pieza.CodPieza} -  ${pieza.NombrePieza} - ${pieza.Medida}` ;
    descripcion.value = `${pieza.CodPieza} -  ${pieza.NombrePieza} - ${pieza.Medida}` ;
    let datos = `<div id="codPieza" style="display: none" value='${pieza.CodPieza}'></div>`;
    tipo.insertAdjacentHTML("beforeEnd",datos); */

    pieza = JSON.parse(pieza);
    var cantidadInput = document.getElementById('cantidadPiezas');
    var cantidad = cantidadInput.value; 
    let datos = `<tr><td>Pieza</td>`;
    datos+= `<td value="${pieza.CodPieza}">${pieza.CodPieza} -  ${pieza.NombrePieza} - ${pieza.Medida}</td>`
    datos+= `<td value="${cantidad}">${cantidad}</td></tr>`
    var tabla = document.getElementById('tabla');
    cantidadInput.value="";
    tabla.insertAdjacentHTML("beforeEnd",datos);
}
function agregaMaterial(material){    
    material = JSON.parse(material);
    var cantidadInput = document.getElementById('cantidadMaterial');
    var cantidad = cantidadInput.value; 
    let datos = `<tr><td>Material</td>`;
    datos+= `<td value="${material.CodigoMaterial}">${material.CodigoMaterial} -  ${material.Material} - ${material.Dimension}</td>`
    datos+= `<td value="${cantidad}">${cantidad}</td></tr>`
    var tabla = document.getElementById('tabla');
    cantidadInput.value="";
    tabla.insertAdjacentHTML("beforeEnd",datos);
}

//Habilita el boton agregar con al menos 1 unidad
function habilitarAgregar(tipo,i) {
    switch(tipo) {
        case 'M':
            var boton = document.getElementById(`addBtnM${i}`);
            boton.disabled= false;
          break;
        case 'P':
            var boton = document.getElementById(`addBtnP${i}`);
            boton.disabled= false;
          break;
        case 'A':
            var boton = document.getElementById(`addBtnA${i}`);
            boton.disabled= false;
          break;
        case 'G':
            var boton = document.getElementById(`addBtnG${i}`);
            boton.disabled= false;
          break;
        default:
      }
    var boton = document.getElementById(`addBtnM${i}`);
    boton.disabled= false;
}

function eliminar(id) {
    var row = document.getElementById(id);

    document.getElementById("tabla").deleteRow(row);
}

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

