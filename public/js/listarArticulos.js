document.getElementById('listar').addEventListener('click', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/listararticuloslistar', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);

            var tabla = document.getElementById('tablaArticulos');
            let datos = `<thead>
            <tr>
            <th>Código</th>
            <th>Descripción</th>
            <th>Sinónimo</th>
            <th>Acción</th>
            
            </tr>
            </thead>`;
            if (data != null) {

                data.forEach(e => {
                    if (e['articulos'] != null) {
                        e['articulos'].forEach(e => {
                            //console.log(e);
                            datos += `<tr>`;
                            datos += `<td>${e['CodArticulo']}</td>`;
                            datos += `<td>${e['Descripcion']}</td>`;
                            datos += `<td>Artículos Generales</td>`;
                            datos += `<td><button type="button" class="btn btn-primary" onclick="listarProveedores('${e['CodArticulo']}')">Listar Proveedores</button></td>`;
                            datos += `</tr>`;
                        });
                    }

                    if (e['gomas'] != null) {
                        e['gomas'].forEach(e => {
                            //console.log(e);
                            datos += `<tr>`;
                            datos += `<td>${e['CodigoGoma']}</td>`;
                            datos += `<td>${e['Codigo Interno']} - øI${e['CodigoInterno']} - øE${e['CodigoExterno']} -a${e['Altura']}</td>`;
                            datos += `<td>Gomas</td>`;
                            datos += `<td><button type="button" class="btn btn-primary" onclick="listarProveedores('${e['CodigoGoma']}')">Listar Proveedores</button></td>`;
                            datos += `</tr>`;
                        });
                    }

                    if (e['materiales'] != null) {
                        e['materiales'].forEach(e => {
                            //console.log(e['CodigoMaterial']);  
                            datos += `<tr>`;
                            datos += `<td>${e['CodigoMaterial']}</td>`;
                            datos += `<td>${e['Material']} - ${e['Dimension']} - ${e['Calidad']}</td>`;
                            datos += `<td>Materiales</td>`;
                            datos += `<td><button type="button" class="btn btn-primary" onclick="listarProveedores('${e['CodigoMaterial']}')">Listar Proveedores</button></td>`;
                            datos += `</tr>`;
                        });
                    }
                });
            } else {
                datos += `<tr><td colspan="4">No hay resultados</td></tr>`;
            }
            tabla.innerHTML = datos;
        })
}, true)

function listarProveedores(id) {
    const datos = new FormData(document.getElementById('formulario'));
    //console.log(id);
    datos.append('id', id);

    fetch('/admin/listararticuloslistarproveedores', {
        method: 'POST',
        body: datos,
    })

        .then(res => res.json())
        .then(data => {
            console.log(data);
            var tabla = document.getElementById('tablaProveedores');
            let datos = `<thead>
        <tr>
        <th>Código</th>
        <th>Denominación</th>
        <th>Precio Unitario</th>
        <th>Categoría</th>
       <th>Gral.</th>
       <th>Valor</th>
       <th>Finanzación</th>
       <th>Entrega</th>
       <th>Calidad</th>
       </tr>
       </thead>`;
            if (data != null) {

                data.forEach(e => {
                    datos += `<tr>`;
                    datos += `<td>${e['p'].CodigoProv}</td>`;
                    datos += `<td>${e['p'].NombreProv}</td>`;
                    datos += `<td>${e['f'].PrecioUnitario}</td>`;
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
                    //datos += `<td><button type="button" class="btn btn-primary" onclick="listarArticulos('${e['p'].CodigoProv}');">Listar Artículos</button></td>`;
                    datos += `</tr>`;
                });
            }
            else {
                datos += `<tr><td colspan="10">No hay resultados</td></tr>`;
            }
            tabla.innerHTML = datos;
        })
}


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