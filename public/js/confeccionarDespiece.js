
document.getElementById('ck1').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/confeccionardespiece', {
        method: 'POST',
        body: datos,
    })
    .then(res => res.json())
    .then(data => {
       
        
        var datos = "";
        var select = document.getElementById('piezas');
        select.innerHTML = "<option></option>";
        data.forEach(e => {
            datos+='<option>'; 
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
    fetch('/admin/confeccionardespiece', {
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
                datos+='<option>'; 
                datos+= e.CodPieza+" - "+ e.NombrePieza+" - "+e.Medida ; 
                datos+='</option>'; 
            });
            data = [];
            select.innerHTML = datos;
       
        })
}, true)

document.getElementById('piezas').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/confeccionardespiece', {
        method: 'POST',
        body: datos,
    })
    .then(res => res.json())
    .then(data => {
        //alert(data);
      
          
            var datos = "";
            var tabla = document.getElementById('tabla');
           
            data.forEach(e => {
                datos+='<option>'; 
                datos+= e.CodPieza+" - "+ e.NombrePieza+" - "+e.Medida ; 
                datos+='</option>'; 
            });
            
            tabla.innerHTML = datos;
       
        })
}, true)

