function calcular() {
    var stock = document.getElementById('stock').value;
    var cantidad = document.getElementById('cantidad').value;
    var egreso = document.getElementById('egreso');
    egreso.value = cantidad;
    var resultado = document.getElementById('resultado');
    resultado.value = parseInt(stock) + parseInt(egreso.value);
}