$('#piezas').on('select2:select', function () {

    const datos = new FormData(document.getElementById('formulario'));
    fetch('/admin/construccion', {
        method: 'POST',
        body: datos,
    })

        .then(res => res.json())
        .then(data => {
         /*    if (data.length == 0) {
                limpiarDatos();
            } else {
                let material = document.getElementById('material');
                material.value = `${data.material.CodigoMaterial} - ${data.material.Material} - ${data.material.Dimension} - ${data.material.Calidad}`;
                let idmaterial = document.getElementById('idmaterial');
                idmaterial.value = data.material.CodigoMaterial;
                let longcorte = document.getElementById('longcorte');
                longcorte.value = data.materialPieza.longitudCorte;
                let cantidadNecesaria = document.getElementById('cantidad-necesaria');
                let cantidadRealizar = document.getElementById('cantidad-realizar');
                cantidadNecesaria.value = (cantidadRealizar.value * longcorte.value) / (1000);
                completarColadas(data.coladaMaterial);
                completarTareas(data.piezaTarea);
            }
         */})
});


document.getElementById('listar').addEventListener('click', function (e) {
    e.preventDefault(); //para evitar que se recargue la pagina

    const datos = new FormData(document.getElementById('formulario'));

    fetch('/admin/listarfacturaslistar', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            var tabla = document.getElementById('tabla');
            let datos = `<thead>
        <tr>
        <th>Letra</th>
        <th>Nro. de Factura</th>
        <th>Fecha</th>
        <th>Importe</th>
        <th>Observaciones</th>
        <th>Valor</th>
        <th>Finanzación</th>
        <th>Entrega</th>
        <th>Calidad</th>
        <th>Accion</th>
        </tr>
        </thead>`;

            data.forEach(e => {
                datos += `<tr>`;
                datos += `<td>${e['proveedorFactura'].Letra}</td>`;
                datos += `<td>${e['proveedorFactura'].NroFactura}</td>`;
                datos += `<td>${e['proveedorFactura'].Fecha}</td>`;
                datos += `<td>${e['valor']}</td>`;
                datos += `<td>${e['proveedorFactura'].Observaciones}</td>`;
                datos += `<td>${calificar(e['proveedorFactura'].CalifValor)}</td>`;
                datos += `<td>${calificar(e['proveedorFactura'].CalifFinanzacion)}</td>`;
                datos += `<td>${calificar(e['proveedorFactura'].CalifEntrega)}</td>`;
                datos += `<td>${calificar(e['proveedorFactura'].CalifCalidad)}</td>`;
                datos += `<td><button type="button" class="btn btn-primary" onclick="listarArticulos('${e['proveedorFactura'].NroFactura}','${e['proveedorFactura'].CodigoProv}');">Listar</button></td>`;
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

function listarArticulos(codFactura, codProveedor) {
    const datos = new FormData(document.getElementById('formulario2'));
    //console.log(id);
    datos.append('codFactura', codFactura);
    datos.append('codProveedor', codProveedor);

    fetch('/admin/listarfacturaslistararticulos', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);

            var tabla = document.getElementById('tablaArticulos');
            let datos = `<thead>
        <tr>
        <th>Codigo de Articulo</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Observaciones</th>
        </tr>
        </thead>`;

            data.forEach(e => {
                datos += `<tr>`;
                datos += `<td>${e.CodArticulo}</td>`;
                datos += `<td>${e.Descripcion}</td>`;
                datos += `<td>${e.Cantidad}</td>`;
                datos += `<td>${e.PrecioUnitario}</td>`;
                datos += `<td>${e.Observaciones}</td>`;
                //datos += `<td><button type="button" class="btn btn-primary" onclick="modificarFactura('${e.id}')">Modificar</button></td>`;
                datos += `</tr>`;
            });
            tabla.innerHTML = datos;
            var btn = document.getElementById('btn');
            btn.innerHTML = `<button type="button" class="btn btn-primary" onclick="modificarFactura('${codFactura}','${codProveedor}')">Modificar</button>`;
            /* `<a href="{{route('modificarFactura',['${codFactura}','${codProveedor}'])}}" class="btn btn-secondary"
            target="blank">Modificar</a>`; */
            //<button type="button" class="btn btn-primary" onclick="modificarFactura('${codFactura}','${codProveedor}')">Modificar</button>

        })

}

function modificarFactura(codFactura, codProveedor) {
    const datos = new FormData(document.getElementById('formulario2'));
    //console.log(id);
    datos.append('codFactura', codFactura);
    datos.append('codProveedor', codProveedor);

    fetch('/admin/listarfacturasllenarmodal', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);

            var subTotalAux = 0;
            var tabla = document.getElementById('tablaModal');
            let datos = `<thead>
        <tr>
        <th>Codigo de Articulo</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Observaciones</th>
        <th>Acción</th>
        </tr>
        </thead>`;

            data['facturaArticulos'].forEach(e => {
                subTotalAux = subTotalAux + (e.Cantidad * e.PrecioUnitario) ;
                datos += `<tr>`;
                datos += `<td>${e.CodArticulo}</td>`;
                datos += `<td>${e.Descripcion}</td>`;
                datos += `<td>${e.Cantidad}</td>`;
                datos += `<td>${e.PrecioUnitario}</td>`;
                datos += `<td>${e.Observaciones}</td>`;
                datos += `<td>
                <button type="button" class="btn btn-primary mb-1" onclick="modificarFactura('${e.id}')">Modificar</button>
                <button type="button" class="btn btn-danger" onclick="eliminarFactura('${e.id}')">Eliminar</button>
                </td>`;
                datos += `</tr>`;
            });
            tabla.innerHTML = datos;
            var btnBon = document.getElementById('divBon');
            btnBon.innerHTML = `<input type="button" class="btn btn-primary" value="Aplicar" onclick="bonificacion('${codFactura}','${codProveedor}');">`;
            var prov = document.getElementById('proveedoresMod');
            var codProv = document.getElementById('provCod');
            var razonProv = document.getElementById('provRazon');
            var nroFact = document.getElementById('nroFact');
            var tipo = document.getElementById('tipo');
            var iva = document.getElementById('iva');
            var fechaMod = document.getElementById('fechaMod');
            var obsMod = document.getElementById('obsMod');
            var calValor = document.getElementById('calValor');
            var calFin = document.getElementById('calFin');
            var calEntrega = document.getElementById('calEntrega');
            var calCalidad = document.getElementById('calCalidad');
            var subTotal = document.getElementById('subTotal');
            var bon = document.getElementById('bon');
            var ivaMod = document.getElementById('ivaMod');
            var total = document.getElementById('total');
            prov.value = data['proveedorFactura'].CodigoProv;
            codProv.value = data['proveedor'].CodigoProv;
            razonProv.value = data['proveedor'].NombreProv;
            nroFact.value = data['proveedorFactura'].NroFactura;
            tipo.value = data['proveedorFactura'].Letra;
            iva.value = data['proveedorFactura'].AlicuotaIVA;
            fechaMod.value = data['proveedorFactura'].Fecha;
            obsMod.value = data['proveedorFactura'].Observaciones;
            calValor.value = data['proveedorFactura'].CalifValor;
            calEntrega.value = data['proveedorFactura'].CalifEntrega;
            calFin.value = data['proveedorFactura'].CalifFinanzacion;
            calCalidad.value = data['proveedorFactura'].CalifCalidad;
            subTotal.value = subTotalAux;
            bon.value = (data['proveedorFactura'].Bonificacion / 100) * subTotalAux;
            ivaMod.value = (data['proveedorFactura'].AlicuotaIVA / 100) * subTotalAux;
            total.value = parseFloat(subTotalAux) - parseFloat(bon.value) + parseFloat(ivaMod.value);
            $('#modalModificar').modal('show');
        })
}

function eliminarFactura(id) {
    
}

function bonificacion(codFactura, codProveedor) {
    const datos = new FormData(document.getElementById('formulario2'));
    //console.log(id);
    datos.append('codFactura', codFactura);
    datos.append('codProveedor', codProveedor);

    fetch('/admin/listarfacturasllenarmodal', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            //console.log(data);

            var subTotalAux = 0;

            data['facturaArticulos'].forEach(e => {
                subTotalAux = subTotalAux + (e.Cantidad * e.PrecioUnitario) ;
            });

            var subTotal = document.getElementById('subTotal');
            var bon = document.getElementById('bon');
            var ivaMod = document.getElementById('ivaMod');
            var total = document.getElementById('total');
            var bonif = document.getElementById('bonif').value;
            subTotal.value = subTotalAux;
            bon.value = (bonif / 100) * subTotalAux;
            ivaMod.value = (data['proveedorFactura'].AlicuotaIVA / 100) * subTotalAux;
            total.value = parseFloat(subTotalAux) - parseFloat(bon.value) + parseFloat(ivaMod.value);
            //$('#modalModificar').modal('show');
        })
}

