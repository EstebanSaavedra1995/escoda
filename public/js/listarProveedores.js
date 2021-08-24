
document.getElementById('listar').addEventListener('click', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario'));

    fetch('/admin/listarproveedoreslistar', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            var tabla = document.getElementById('tabla');
            let datos = `<thead>
        <tr>
        <th>Código</th>
        <th>Denominación</th>
        <th>Categoría</th>
        <th>Gral.</th>
        <th>Valor</th>
        <th>Finanzación</th>
        <th>Entrega</th>
        <th>Calidad</th>
        <th>Accion</th>
        </tr>
        </thead>`;

            data.forEach(e => {
                datos += `<tr>`;
                datos += `<td>${e['p'].CodigoProv}</td>`;
                datos += `<td>${e['p'].NombreProv}</td>`;
                datos += `<td>${e['p'].Categoria}</td>`;
                datos += `<td>${'-'}</td>`;
                if (e['pf'] != null) {

                    datos += `<td>${calificar(e['pf'].CalifValor)}</td>`;
                    datos += `<td>${calificar(e['pf'].CalifFinanzacion)}</td>`;
                    datos += `<td>${calificar(e['pf'].CalifEntrega)}</td>`;
                    datos += `<td>${calificar(e['pf'].CalifCalidad)}</td>`;
                } else {
                    datos += `<td></td>`;
                    datos += `<td></td>`;
                    datos += `<td></td>`;
                    datos += `<td></td>`;
                }
                datos += `<td><button class="btn btn-primary" onclick="listarArticulos('000');">Listar</button></td>`;
                datos += `</tr>`;
            });
            tabla.innerHTML = datos;
        })

}, true)

function calificar(n) {

    switch (n) {
        case 1:
            return 'Malo';
            break;
        case 2:
            return 'Regular';
            break;
        case 3:
            return 'Bueno';
            break;

        default: return '';
            break;
    }

}

function listarArticulos(id) {
    const datos = new FormData(document.getElementById('formulario'));
    datos.append('id', id);

    fetch('/admin/listarproveedoresarticulos', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
        })

}