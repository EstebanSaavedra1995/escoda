var arregloOriginalSudoku = new Array();
var tiempoTotal = "";

function pasoValores() {
    var arregloDeInputsSudoku = document.getElementsByClassName("campos");
    var arreglo = new Array();
    for (let index = 0; index < arregloDeInputsSudoku.length; index++) {
        arreglo.push(arregloDeInputsSudoku[index].value);
    }
    return arreglo;
}

function guardoSudokuCompleto() {
    arregloOriginalSudoku = pasoValores();
}

function ocultoCampos() {
    var arregloDeInputsSudoku = document.getElementsByClassName("campos");
    var random;
    for (let index = 0; index < 63; index++) {
        random = Math.floor(Math.random() * 81);
        if (arregloDeInputsSudoku[random].value != "") {
            arregloDeInputsSudoku[random].value = "";
            arregloDeInputsSudoku[random].style.background = "white";
            arregloDeInputsSudoku[random].removeAttribute("readOnly");
        } else {
            index--;
        }
    }
}

function comparoArreglos(a1, a2) {
    var flag = true;
    for (let index = 0; index < a1.length; index++) {
        if (a1[index] != a2[index]) {
            flag = false;
        }
    }
    return flag;
}

function contarTiempo() {
    var minutos = 0,
        segundos = 0,
        horas = 0,
        seg = "",
        min = "";
    setInterval(function() {
        if (minutos == 60) {
            minutos = 0;
            horas++;
        }
        if (segundos == 60) {
            segundos = 0;
            minutos++;
        }
        segundos++;
        if (segundos < 10) {
            seg = "0";
        } else {
            seg = "";
        }
        if (minutos < 10) {
            min = "0";
        } else {
            min = "";
        }

        tiempoTotal = "0" + horas + ":" + min + minutos + ":" + seg + segundos;
    }, 1000)
}

function creoFormulario() {
    var tabla = '<h3> ¡Felicidades, has ganado!</h3> <form method="post"> <table class="formu"> <tr> <td> Ingrese su nombre: </td> <td> <input id="nombreFormu" class="nombreFormu" type="text" onkeyup="verificoNombre();"></input> </tr>';
    tabla += '<tr> <td> Su tiempo es: </td> <td> <label id="tiempoJugador" class="tiempoJugador">' + tiempoTotal + '</label></td> </tr> ';
    tabla += '<tr> <td colspan="2" class= "filaBoton"> <button id= "guardarFormu" disabled= "true" type = "button" class ="guardarFormu" onClick="guardoDatos();" >¡Guardar datos!</button></td> </tr> </table> </form>';
    return tabla;
}



function verificoSiEstaCompleto() {
    var arregloDeInputs = document.getElementsByClassName("campos");
    var contenedor = document.getElementById("contenedor");
    var contar = 0;
    var arregloActualSudoku = pasoValores();
    for (let index = 0; index < arregloDeInputs.length; index++) {
        if (arregloDeInputs[index].value != "") {
            contar++;
        }
        if (contar == 81) {
            if (comparoArreglos(arregloActualSudoku, arregloOriginalSudoku)) {
                var tablero = document.getElementById("tablaSudoku").style.display = "none";
                contenedor.innerHTML = creoFormulario();
            } else {
                contenedor.innerHTML = "<h3>¡Revise bien las casillas!</h3>";

            }
        }
    }

}