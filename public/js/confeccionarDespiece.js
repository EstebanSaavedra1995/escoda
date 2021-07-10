


document.getElementById('ck1').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/confeccionardespiecepiezas', {
        method: 'POST',
        body: datos,
    })
    .then(res => res.json())
    .then(data => {
       
        
        var datos = "";
        var select = document.getElementById('piezas');
        select.innerHTML = "<option></option>";
        data.forEach(e => {
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
                datos+=`<tr class=""><td scope="col" class=""> pieza </td>`; 
                datos+=`<td scope="col" class=""> ${e.CodPieza} - ${e.NombrePieza} - ${e.Medida} </td>` ; 
                datos+= '<td scope="col" class="">'+'</td>'; 
                datos+='</tr>'; 

            });
            }else{
               
                datos+=`<tr class=""><td scope="col" class=""> Material </td>`; 
                datos+=`<td scope="col" class=""> ${data.CodigoMaterial} - ${data.Material} - ${data.Dimension} </td>`; 
                datos+= `<td scope="col" class=""></td>`; 
                datos+=`</tr>`; 
            }
            tabla.innerHTML = datos;
            //tabla.insertAdjacentHTML("beforeEnd",datos);
       
        })
}, true)

//Activar el modal
$(document).ready(function () {
    $('#material').click(function () {
        $('#modalmaterial').modal('show');
    })
})
$(document).ready(function () {
    $('#goma').click(function () {
        $('#modalgoma').modal('show');
    })
})
$(document).ready(function () {
    $('#articulos').click(function () {
        $('#modalarticulos').modal('show');
    })
})
$(document).ready(function () {
    $('#piezas').click(function () {
        $('#modalpiezas').modal('show');
    })
})
/* document.getElementById('cantidad-realizar').addEventListener('change', function (e) {
    e.preventDefault();
    let cantidadNecesaria = document.getElementById('cantidad-necesaria');
    let cantidadRealizar = document.getElementById('cantidad-realizar');
    cantidadNecesaria.value = (cantidadRealizar.value * longcorte.value) / (1000);

}, true) */

