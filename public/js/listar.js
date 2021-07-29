//EVENTOS CHECK DE PIEZA/CONJUNTO
document.getElementById('ck1Mod').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario-modal'));
    fetch('/admin/listarpiezas', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {

            var conjunto = data['conjunto'];
            //var piezaDeConjunto = data['conjunto'];
            //console.log(conjunto[1]);
            var datos = "";
            datos += '<option value="0"> </option>';
            var select = document.getElementById('piezasMod');
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

document.getElementById('ck2Mod').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario-modal'));
    fetch('/admin/listarpiezas', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            //alert(data);


            var datos = "";
            var select = document.getElementById('piezasMod');
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

//Evento listar modal
document.getElementById('btnListarMod').addEventListener('click', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina
    $("#cargandoDiv").show();
    const datos = new FormData(document.getElementById('formulario-modal'));
    fetch('/admin/listartabla', {
        method: 'POST',
        body: datos,
        beforeSend: function () {
            console.log("espera");
        },
    })
        .then(res => res.json())
        .then(data => {
            //console.log(data);

            let datos = "";

            datos += `<thead>
                <tr>
                    <th scope="col">Nro. Egreso</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Pieza</th>
                    <th scope="col">Nro</th>
                    <th scope="col">Condición</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Intervención</th>
                    <th scope="col">Pozo</th>
                    <th scope="col">Orden Trabajo</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>`;

            var tabla = document.getElementById('tablaMod');
            //var ck1 = document.getElementById('ck1');
            var long = 0;
            data.forEach(e => {
                long++;
                //Convertir el string a fecha para poder modificarlo
                let fechaE = new Date(e.Fecha);
                //Poner el formato que quieres
                //fechaE = fechaE.format('DD/MM/YYYY');
                //Volver a convertirlo a string
                fechaE = ('0' + fechaE.getDate()).slice(-2) + '/'
                    + ('0' + (fechaE.getMonth() + 1)).slice(-2) + '/'
                    + fechaE.getFullYear();
                

                datos += `<tr id="${e.id}" class="" onclick="">`;
                datos += `<td scope="col" ><input id="NroE${e.id}" type="text" value="${e.NroEgreso}" class="oculto tblNroE" readonly></td>`;
                datos += `<td scope="col" ><input id="FechaE${e.id}" type="text" value="${fechaE}" class="oculto tblFechaE" readonly></td>`;
                datos += `<td scope="col" ><input id="Cod${e.id}" type="text" value="${e.CodPieza}" class="oculto tblCod" readonly></td>`;
                datos += `<td scope="col" ><input id="Numero${e.id}" type="text" value="${e.Numero}" class="oculto tblNumero" readonly></td>`;
                datos += `<td scope="col" ><input id="Condicion${e.id}" type="text" value="${e.Condicion}" class="oculto tblCondicion" readonly></td>`;
                datos += `<td scope="col" ><input id="Tipo${e.id}" type="text" value="${e.TipoEgreso}" class="oculto tblTipo" readonly></td>`;
                datos += `<td scope="col" ><input id="FechaI${e.id}" type="text" value="${e.FechaIntervencion}" class="oculto tblFechaI" readonly></td>`;
                datos += `<td scope="col" ><input id="Pozo${e.id}" type="text" value="${e.Pozo}" class="oculto tblPozo" readonly></td>`;
                datos += `<td scope="col" ><input id="NroOR${e.id}" type="text" value="${e.NroOR}" class="oculto tblNroOR" readonly></td>`;
                datos += `<td scope="col" >
                <button class="btn btn-primary mb-1" type="button" id="" onclick="modificar(${e.id});">Modificar</button>
                <button class="btn btn-danger" type="button" id="" onclick="borrar(${e.id});">Borrar</button>
                </td>`;
                datos += '</tr>';
            });
            var cantidad = document.getElementById('cantidadHtas');
            cantidad.innerText = 'Cantidad de Htas.: ' + long;
            tabla.innerHTML = datos;
        })
        .finally(() => {
            $("#cargandoDiv").hide();
        })
}, true)

function modificar(id) {
    //Activar el modal
    $('#modalModificar').modal('show');
    var NroE = document.getElementById('NroE' + id);
    var FechaE = document.getElementById('FechaE' + id);
    var Cod = document.getElementById('Cod' + id);
    var Numero = document.getElementById('Numero' + id);
    var Condicion = document.getElementById('Condicion' + id);
    var Tipo = document.getElementById('Tipo' + id);
    var FechaI = document.getElementById('FechaI' + id);
    var Pozo = document.getElementById('Pozo' + id);
    var NroOR = document.getElementById('NroOR' + id);

}

function borrar(id) {
    null
}
//COLAPPSE DE LISTAR POR
function collapse() {
    var select = document.getElementById('listarPor').value;
    var nro = document.getElementById('collNroEgreso');
    var fecha = document.getElementById('collFecha');
    var pieza = document.getElementById('collPieza');
    switch (select) {
        case 'nroDeEgreso':
            $("#collNroEgreso").show();
            $("#collFecha").hide();
            $("#collPieza").hide();

            break;
        case 'fecha':

            $("#collFecha").show();
            $("#collNroEgreso").hide();
            $("#collPieza").hide();

            break;
        case 'pieza':

            $("#collPieza").show();
            $("#collNroEgreso").hide();
            $("#collFecha").hide();
            break;

        default:
            break;
    }


}