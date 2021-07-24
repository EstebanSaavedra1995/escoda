
//Eventos de check para diferenciar pieza y conjunto
document.getElementById('ck1').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/registraregresopiezas', {
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
    fetch('/admin/registraregresopiezas', {
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
document.getElementById('ck1Mod').addEventListener('change', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario-modal'));
    fetch('/admin/registraregresopiezas', {
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
    fetch('/admin/registraregresopiezas', {
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


document.getElementById('btnListarMod').addEventListener('click', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina
    $("#cargandoDiv").show();
    const datos = new FormData(document.getElementById('formulario-modal'));
    fetch('/admin/registraregresotabla', {
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
                </tr>
            </thead>`;

            var tabla = document.getElementById('tablaMod');
            //var ck1 = document.getElementById('ck1');
            data.forEach(e => {
                /* datos += `<tr id="${e.CodPieza+e.Numero+e.Fecha}" class="" onclick=""><td scope="col" class=""> ${e.tipo} </td>`;
                datos += `<input type="hidden" class="tblCodigo" value="${e.pieza.CodPieza}"> `;
                datos += `<input type="hidden" class="tblTipo" value="${e.tipo}"> `;
                datos += `<input type="hidden" class="tblCantidad" value="${e.cantidad}"> `; */

                datos += `<td scope="col" > ${e.NroEgreso} </td>`;
                datos += `<td scope="col" class="">${e.Fecha}</td>`;
                datos += `<td scope="col" class="">${e.CodPieza}</td>`;
                datos += `<td scope="col" class="">${e.Numero}</td>`;
                datos += `<td scope="col" class="">${e.Condicion}</td>`;
                datos += `<td scope="col" class="">${e.TipoEgreso}</td>`;
                datos += `<td scope="col" class="">${e.FechaIntervencion}</td>`;
                datos += `<td scope="col" class="">${e.Pozo}</td>`;
                datos += `<td scope="col" class="">${e.NroOR}</td>`;
                //datos += `<td scope="col" class=""><button type="button" class="btn btn-primary " id="" onclick="eliminar('${e.pieza.CodPieza}');">Eliminar</button></td>`;
                datos += '</tr>';
            });
            tabla.innerHTML = datos;
        })
        .finally(()=>{
            $("#cargandoDiv").hide();
        })
}, true)

$(document).ready(function () {
    $('#listarBtn').click(function () {
        $('#modalListar').modal('show');
    })
})

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