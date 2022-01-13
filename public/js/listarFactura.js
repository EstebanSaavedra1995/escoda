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