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
            //console.log(data);
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
            //console.log(data);

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
            listarArticulosModal(codProveedor);
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
            //console.log(data);
            var tArticulos = [];
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
            </thead>
            <tbody id="bodyModal">`;
        /* `<thead>
        <tr>
        <th>Codigo de Articulo</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Observaciones</th>
        <th>Acción</th>
        </tr>
        </thead>`; */
            data['facturaArticulos'].forEach(e => {
                subTotalAux = subTotalAux + (e.Cantidad * e.PrecioUnitario);
                tArticulos.push(e.id);
                datos += `<tr id="${e.CodArticulo}">`;
                datos += `<input type="hidden" class="tblCodigo" value="${e.CodArticulo}"> `;
                datos += `<input type="hidden" class="tblDesc" value="${e.Descripcion}"> `;
                datos += `<input type="hidden" class="tblCant" value="${e.Cantidad}"> `;
                datos += `<input type="hidden" class="tblPrecio" value="${e.PrecioUnitario}"> `;
                datos += `<input type="hidden" class="tblObs" value="${e.Observaciones}"> `;
                datos += `<td>${e.CodArticulo}</td>`;
                datos += `<td>${e.Descripcion}</td>`;
                datos += `<td>${e.Cantidad}</td>`;
                datos += `<td>${e.PrecioUnitario}</td>`;
                datos += `<td>${e.Observaciones}</td>`;
                datos += `<td>
                <button type="button" class="btn btn-primary mb-1" onclick="modificarArticulo('${e.CodArticulo}')">Modificar</button>
                <button type="button" class="btn btn-danger" onclick="eliminarFactura('${e.CodArticulo}')">Eliminar</button>
                </td>`;
                datos += `</tr>`;
            });
            datos += `</tbody>`;
            tabla.innerHTML = datos;
            var btnBon = document.getElementById('divBon');
            var btnAñadir = document.getElementById('divAñadir');
            btnAñadir.innerHTML = `<input type="button" class="btn btn-primary" value="Añadir" onclick="añadir();">`;
            btnBon.innerHTML = `<input type="button" class="btn btn-primary" value="Aplicar" onclick="bonificacion();">`;
            var prov = document.getElementById('proveedoresMod');
            var codProv = document.getElementById('provCod');
            var nroFact = document.getElementById('nroFact');
            var razonProv = document.getElementById('provRazon');
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
            var fArt = document.getElementById('fArtId');
            var pFactId = document.getElementById('pFacId');
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
            fArt.value = JSON.stringify(tArticulos);
            pFactId.value = data['proveedorFactura'].id;
            $('#modalModificar').modal('show');
        })
}

function eliminarFactura(id) {
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

function modificarArticulo(cod) {
    
}

function bonificacion() {
    var codProveedor = document.getElementById('provCod').value;
    var codFactura = document.getElementById('nroFact').value;
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
                subTotalAux = subTotalAux + (e.Cantidad * e.PrecioUnitario);
            });

            var subTotal = document.getElementById('subTotal');
            var bon = document.getElementById('bon');
            var ivaMod = document.getElementById('ivaMod');
            var iva = document.getElementById('iva').value;
            var total = document.getElementById('total');
            var bonif = document.getElementById('bonif').value;
            subTotal.value = subTotalAux;
            bon.value = (bonif / 100) * subTotalAux;
            ivaMod.value = (iva / 100) * subTotalAux;
            total.value = parseFloat(subTotalAux) - parseFloat(bon.value) + parseFloat(ivaMod.value);
            //$('#modalModificar').modal('show');
        })
}


function guardarFactura() {
    /* datos += `<input type="hidden" class="tblCodigo" value="${e.CodArticulo}"> `;
                    datos += `<input type="hidden" class="tblDesc" value="${e.Descripcion}"> `;
                    datos += `<input type="hidden" class="tblCant" value="${e.Cantidad}"> `;
                    datos += `<input type="hidden" class="tblPrecio" value="${e.PrecioUnitario}"> `;
                    datos += `<input type="hidden" class="tblObs" value="${e.Observaciones}"> `; */
    var codigos = document.getElementsByClassName('tblCodigo');
    var desc = document.getElementsByClassName('tblDesc');
    var cant = document.getElementsByClassName('tblCant');
    var precio = document.getElementsByClassName('tblPrecio');
    var obs = document.getElementsByClassName('tblObs');
    //console.log((codigos[0] == null));
    //if (codigos[0] == null) {
    //swal("Aviso!", "No puede predeterminar la tabla vacia!");
    var val = [];
    for (i = 0; i < codigos.length; i++) {
        let e = {
            cod: codigos[i].value,
            descripcion: desc[i].value,
            cantidad: cant[i].value,
            precio: precio[i].value,
            observaciones: obs[i].value
        };
        val.push(e);
    }

    val = JSON.stringify(val);
    const datos = new FormData(document.getElementById('formulario-modal'));
    datos.append('valores', val);
    fetch('/admin/listarfacturasguardar', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
        })
}

function añadir() {
    var cod = document.getElementById('productos').value;
    const datos = new FormData(document.getElementById('formulario-modal'));
    datos.append('cod', cod);
    fetch('/admin/listarfacturasbuscarproducto', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(e => {
            console.log(e);
            var cantidad = document.getElementById('cantidad').value;
            var precioU = document.getElementById('precioU').value;
            var observP = document.getElementById('observP').value;
            let datos = `<tr id="${e.CodArticulo}">`;
            datos += `<input type="hidden" class="tblCodigo" value="${e.CodArticulo}"> `;
            datos += `<input type="hidden" class="tblDesc" value="${e.Descripcion}"> `;
            datos += `<input type="hidden" class="tblCant" value="${cantidad}"> `;
            datos += `<input type="hidden" class="tblPrecio" value="${precioU}"> `;
            datos += `<input type="hidden" class="tblObs" value="${observP}"> `;
            datos += `<td>${e.CodArticulo}</td>`;
            datos += `<td>${e.Descripcion}</td>`;
            datos += `<td>${cantidad}</td>`;
            datos += `<td>${precioU}</td>`;
            datos += `<td>${observP}</td>`;
            datos += `<td>
                <button type="button" class="btn btn-primary mb-1" onclick="modificarArticulo('${e.CodArticulo}')">Modificar</button>
                <button type="button" class="btn btn-danger" onclick="eliminarFactura('${e.CodArticulo}')">Eliminar</button>
                </td>`;
            datos += `</tr>`;
            
            var tabla = document.getElementById('bodyModal');
            var existe = document.getElementById(e.CodArticulo);
            if (existe == null) {
                tabla.insertAdjacentHTML("beforeEnd", datos);
            } else {
                eliminarSinAlert(e.CodArticulo);
                tabla.insertAdjacentHTML("beforeEnd", datos);
            }

            //tabla.appendChild(datos);
            //tabla.insertAdjacentHTML("beforeEnd", datos);
        })

}

function eliminarTodoSinAlert() {
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
    let tabla = document.getElementById('tablaModal');
    tabla.innerHTML = datos;
}

function eliminarSinAlert(id) {
    let parent = document.getElementById(id).parentNode;
    parent.removeChild(document.getElementById(id));
}

function listarArticulosModal(id) {
    const datos = new FormData(document.getElementById('formulario2'));
    //console.log(id);
    datos.append('id', id);

    fetch('/admin/listarproveedoresarticulos', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            let datos = `<option></option>`;

            data.forEach(e => {
                if (e['articulos'] != null) {
                    e['articulos'].forEach(e => {
                        //console.log(e);
                        datos += `<option value="${e['CodArticulo']}">${e['CodArticulo']} - ${e['Descripcion']} - Artículos</option>`
                    });
                }

                if (e['gomas'] != null) {
                    e['gomas'].forEach(e => {
                        //console.log(e);
                        datos += `<option value="${e['CodigoGoma']}"> ${e['CodigoGoma']} - ${e['Codigo Interno']} - øI${e['CodigoInterno']} - øE${e['CodigoExterno']} -a${e['Altura']} - Gomas</option>`;
                    });
                }

                if (e['materiales'] != null) {
                    e['materiales'].forEach(e => {
                        //console.log(e['CodigoMaterial']);
                        datos += `<option value="${e['CodigoMaterial']}"> ${e['CodigoMaterial']} - ${e['Material']} - ${e['Dimension']} - ${e['Calidad']} - Materiales</option>`;
                    });
                }
            });
            var select = document.getElementById('productos');
            select.innerHTML = datos;
        })

}

$('#proveedoresMod').on('select2:select', function () {
    var codProv = document.getElementById('provCod').value;
    var nroFact = document.getElementById('nroFact').value;
    bonificacion(nroFact, codProv);
});