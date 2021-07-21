
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