function abrirModal() {
    const datos = new FormData(document.getElementById('formulario-factura'));
    //console.log(id);
    //datos.append('codFactura', codFactura);
    //datos.append('codProveedor', codProveedor);

    fetch('/admin/ingresarfacturasllenarmodal', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            //console.log(data);
            $('#modalAñadirArt').modal('show');

            var selectArt = document.getElementById('selectArt');
            let datos = `<option></option>`;
            if (data != null) {

                data.forEach(e => {
                    if (e['articulos'] != null) {
                        e['articulos'].forEach(e => {
                            //console.log(e);
                            datos += `<option value="${e['CodArticulo']}">`;
                            datos += `Articulo - ${e['CodArticulo']} - ${e['Descripcion']}`;
                            datos += `</option>`;
                        });
                    }

                    if (e['gomas'] != null) {
                        e['gomas'].forEach(e => {
                            //console.log(e);
                            datos += `<option value="${e['CodigoGoma']}">`;
                            datos += `Goma - ${e['Codigo Interno']} - øI${e['CodigoInterno']} - øE${e['CodigoExterno']} -a${e['Altura']}`;
                            datos += `</option>`;
                        });
                    }

                    if (e['materiales'] != null) {
                        e['materiales'].forEach(e => {
                            //console.log(e['CodigoMaterial']);  
                            datos += `<option value="${e['CodigoMaterial']}">`;
                            datos += `Material - ${e['CodigoMaterial']} - ${e['Material']} - ${e['Dimension']} - ${e['Calidad']}`;
                            datos += `</option>`;
                        });
                    }
                });
            } else {
                datos += `<option>-</option>`;
            }

            selectArt.innerHTML = datos;
        })
}

function cambiarProveedor() {

    const datos = new FormData(document.getElementById('formulario-factura'));
    //console.log(id);
    //datos.append('id', id);

    fetch('/admin/facturaobtenerproveedor', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            //console.log(data);

            var cod = document.getElementById('proveedores');
            var inputCod = document.getElementById('provCod');
            var inputRazon = document.getElementById('provRazon');

            inputCod.value = cod.value;
            inputRazon.value = data.NombreProv;
        })

}

function cambiarArt() {
    const datos = new FormData(document.getElementById('formulario-añadir'));
    fetch('/admin/ingresarfacturasgetart', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);

        })
}

function agregarArt() {
    var tabla = document.getElementById('tablacard');
    var cod = document.getElementById('selectArt').value;
    var sinonimo = document.getElementById('sinonimoArt').value;
    var cantidad = document.getElementById('cantidadArt').value;
    var precio = document.getElementById('precioArt').value;
    var obs = document.getElementById('obsArt').value;
    var colada = document.getElementById('selectColada').value;
    if (sinonimo == '' || cod == '' || cantidad == '' || precio == '') {
        swal({
            title: `¡Falta completar datos!`,
            icon: "",
        });
    } else {

        let datos = `<tr>`;
        datos += `<td>${cod}<input type="hidden" id="id${cod}" name="id${cod}" class="tblCodigo" value="${cod}"> </td>`;
        datos += `<td>${$("#selectArt option:selected").text()} - ${colada}<input type="hidden" id="desc${cod}" name="desc${cod}" class="tblDesc" value="${$("#selectArt option:selected").text()}">
        <input type="hidden" id="sin${cod}" name="sin${cod}" class="tblSin" value="${sinonimo}">
        <input type="hidden" id="col${cod}" name="col${cod}" class="tblCol" value="${colada}"></td>`;
        datos += `<td>${cantidad}<input type="hidden" id="can${cod}" name="can${cod}" class="tblCan" value="${cantidad}"></td>`;
        datos += `<td>${precio}<input type="hidden" id="precio${cod}" name="precio${cod}" class="tblPrecio" value="${precio}"></td>`;
        datos += `<td>${obs}<input type="hidden" id="obs${cod}" name="obs${cod}" class="tblObs" value="${obs}"></td>`;
        datos += `<td>Accion</td>`;
        datos += `</tr>`;

        tabla.insertAdjacentHTML("beforeEnd", datos);
        $('#modalAñadirArt').modal('hide');
    }

}

/* $('#proveedoresMod').on('select2:select', function () {
    var codProv = document.getElementById('provCod').value;
    var nroFact = document.getElementById('nroFact').value;
    bonificacion(nroFact, codProv);
}); */

function bonificacion() {

    var codigos = document.getElementsByClassName('tblCodigo');
    var subTotalAux = 0;

    for (i = 0; i < codigos.length; i++) {
        subTotalAux = subTotalAux + (document.getElementById('can' + codigos[i].value).value * document.getElementById('precio' + codigos[i].value).value);
        console.log(subTotalAux);
    }

    /* data['facturaArticulos'].forEach(e => {
        subTotalAux = subTotalAux + (e.Cantidad * e.PrecioUnitario);
    }); */

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

}

function guardarFactura() {
    var nroFact = document.getElementById('nroFact');
    if (nroFact == '' ) {
        swal({
            title: `¡Falta completar Nro. Factura!`,
            icon: "",
        });
    } else {

        var codigos = document.getElementsByClassName('tblCodigo');
        var val = [];
        for (i = 0; i < codigos.length; i++) {
            val.push(codigos[i].value);
        }
        const datos = new FormData(document.getElementById('formulario-factura'));
        datos.append('codigos', val);
        fetch('/admin/ingresarfacturassave', {
            method: 'POST',
            body: datos,
        })
            .then(res => res.json())
            .then(data => {
                //console.log(data);
                if (data == 'ok') {
                    swal({
                        title: `¡Se ha guardado la factura!`,
                        icon: "success",
                        button: "Aceptar",
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1000)
                } else {
                    console.log('error');
                }

            })
    }
}

function getColada() {
    var codigoMaterial = document.getElementById('selectArt');
    console.log(codigoMaterial.value);

    var datos = new FormData(document.getElementById('form-null'));

    datos.append('codigo', codigoMaterial.value);

    fetch('/admin/ingresarfacturasgetcolada', {
        method: 'POST',
        body: datos,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);

            var selectArt = document.getElementById('selectColada');
            let datos = ``;
            if (data != null) {

                data.forEach(e => {

                    datos += `<option value="${e['id']}">`;
                    datos += `${e['Colada']}`;
                    datos += `</option>`;

                });
            } else {
                datos += `<option>-</option>`;
            }

            selectArt.innerHTML = datos;
        })
}