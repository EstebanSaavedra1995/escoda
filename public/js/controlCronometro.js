//PARA LIMPIAR CACHE Y FUNCIONE BIEN PUSHER
/* php artisan config:cache */
$(document).ready(function(){
//window.onload = function () {
  if (document.getElementsByClassName('inicio')) {
    var inicios = document.getElementsByClassName('inicio');
    var fecha;
   
    //console.log('Inicio= '+localStorage.getItem("inicio"));
    for (let i = 0; i < inicios.length; i++) {
      fecha = localStorage.getItem(inicios[i].value);
      fecha = new Date(localStorage.getItem(inicios[i].value));
      console.log(fecha);
      controlI.push(setInterval(cronometro, 1000, fecha,inicios[i].value));
    }
      console.log('array'+controlI);
    
  }

}
)
var isMarch = false;
var isStart = false;
var terminado = false;
var setEstado = false;
var piezas = 0;
var exitosas = 0;
var fallidas = 0;
var tiempoPieza = '';
var acumularTime = 0;
var controlI = [];
var timeInicial;

function start() {
  console.log('start');
  timeInicial = new Date();
  localStorage.setItem("inicio", timeInicial);
  control = setInterval(cronometro, 1000);
}
function cronometro(fecha,pantalla) {

  timeActual = new Date();
  /* if (localStorage.getItem("inicio") != null) {
    timeInicial = new Date(localStorage.getItem("inicio"));
    console.log(timeInicial);
  } */
  timeInicial = fecha;
  acumularTime = timeActual - timeInicial;
  acumularTime2 = new Date();
  acumularTime2.setTime(acumularTime);
  cc = Math.round(acumularTime2.getMilliseconds() / 10);
  ss = acumularTime2.getSeconds();
  mm = acumularTime2.getMinutes();
  hh = acumularTime2.getHours()-21;

  if (cc < 10) { cc = "0" + cc; }
  if (ss < 10) { ss = "0" + ss; }
  if (mm < 10) { mm = "0" + mm; }
  if (hh < 10) {hh = "0"+hh;}
  
  tiempoPieza = hh+" : "+ mm + " : " + ss ;
  //+ " : " + cc
  localStorage.setItem("tiempo", tiempoPieza);
  //localStorage.removeItem("inicio");
  // if(localStorage.getItem("inicio")!=null)
  //inicio=localStorage.getItem("inicio");
  var pantalla = document.getElementById('pantalla'+pantalla);
  if (pantalla != null) {
    
    pantalla.innerHTML = tiempoPieza;
  } else {
    document.location.reload();
  }
  //console.log('crono '+ tiempoPieza);
}

function stop() {
    timeStop = new Date();
    clearInterval(control);
    isMarch = false;
    console.log(localStorage.getItem("inicio"));
}

function resume() {

  if (isMarch == false & isStart == true) {
    timeResume = new Date();
    console.log("Continua: " + timeResume);
    timeActu2 = new Date();
    timeActu2 = timeActu2.getTime();
    acumularResume = timeActu2 - acumularTime;

    timeInicial.setTime(acumularResume);
    control = setInterval(cronometro, 10);
    isMarch = true;
  }
}

function reset() {
  localStorage.setItem("estado", 'f');
  localStorage.setItem("tiempoFinal", tiempoPieza);
  //localStorage.setItem("idTiempo", document.getElementById('idTiempo').value);
  var tiempo = document.getElementById("tiempo");
  tiempo.value = tiempoPieza;
  tiempo.dispatchEvent(new Event('input'));
  tiempo = '';
  if (isStart == true) {
    if (isMarch == true) {
      clearInterval(control);
      isMarch = false;
    }
    localStorage.removeItem("inicio");
    timeReset = new Date();
    console.log("Termina: " + timeReset);
    isStart = false;
    acumularTime = 0;
    pantalla.innerHTML = "00 : 00 : 00";
  }

}


