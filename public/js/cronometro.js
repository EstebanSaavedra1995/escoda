//PARA LIMPIAR CACHE Y FUNCIONE BIEN PUSHER
/* php artisan config:cache */
window.onload = function () {
  pantalla = document.getElementById("screen");
  //localStorage.removeItem("inicio");
  if (localStorage.getItem("inicio") != null) {
    enviado.value = 'f';
    terminado = false;
    isMarch = true;
    isStart = true;
    //timeInicial = localStorage.getItem("inicio");
    control = setInterval(cronometro, 10);

  }

}
var isMarch = false;
var isStart = false;
var terminado = false;
var piezas = 0;
var exitosas = 0;
var fallidas = 0;
var tiempoPieza = '';
var acumularTime = 0;

function start() {
  if (isMarch == false & isStart == false) {
    // this.controlBotones();
    var enviado = document.getElementById('enviado');
    if (enviado.value == 'f') {
      swal("Debe enviar antes de empezar!", "si ya se envio espere notificacion de envio exitoso", "error");
    } else {

      enviado.value = 'f';
      terminado = false;
      isStart = true;
      timeStart = new Date();
      console.log("Empieza: " + timeStart);
      timeInicial = new Date();
      console.log(timeInicial);
      localStorage.setItem("inicio", timeInicial);
      control = setInterval(cronometro, 10);
      isMarch = true;
    }

  }
}
function cronometro() {
  timeActual = new Date();
  if (localStorage.getItem("inicio") != null) {
    timeInicial = new Date(localStorage.getItem("inicio"));
    //console.log(timeInicial);
  }
  acumularTime = timeActual - timeInicial;
  acumularTime2 = new Date();
  acumularTime2.setTime(acumularTime);
  cc = Math.round(acumularTime2.getMilliseconds() / 10);
  ss = acumularTime2.getSeconds();
  mm = acumularTime2.getMinutes();

  /* hh = acumularTime2.getHours()-21; */
  if (cc < 10) { cc = "0" + cc; }
  if (ss < 10) { ss = "0" + ss; }
  if (mm < 10) { mm = "0" + mm; }
  /* if (hh < 10) {hh = "0"+hh;} */
  /* hh+" : "+ */
  tiempoPieza = mm + " : " + ss + " : " + cc;
  localStorage.setItem("tiempo", tiempoPieza);
  //localStorage.removeItem("inicio");
  // if(localStorage.getItem("inicio")!=null)
  //inicio=localStorage.getItem("inicio");
  pantalla.innerHTML = tiempoPieza;
}

function stop() {

  if (isMarch == true) {
    timeStop = new Date();
    console.log("Pausa: " + timeStop);
    clearInterval(control);
    isMarch = false;
    console.log(localStorage.getItem("inicio"));
  }
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
    var cantidad = document.getElementById("cantidad");
    
    terminado = true;
    //cant = document.getElementById("cant");
    /* piezas++;
    cantidad.value = piezas;
    cantidad.dispatchEvent(new Event('input')); */
    //dispara evento para comunicar el livewire con input
    
    //cant.value= piezas;
    /* var enviado = document.getElementById("enviado");
    enviado.value = 'f';
    enviado.dispatchEvent(new Event('input')); */
    this.estado();
    
    
    /* contPiezas = document.getElementById('contadorPiezas');
    contPiezas.innerHTML = "Total Piezas = "+ piezas ; */
    //console.log(cantidad.value);
    
  }

}

function estado() {
  var estado = document.getElementById("estado");
  swal("En que estado se encuentra la pieza terminada?", {
    buttons: {
      catch1: {
        text: "Apta",
        value: "exito",
      },
      catch: {
        text: "No Apta",
        value: "fallo",
      },
    },
  })
    .then((value) => {
      switch (value) {

        case "exito":
          //swal("Pieza Apta!", "", "success");
          estado.value = 'exitosa';
          //estado.dispatchEvent(new Event('input'));
          window.livewire.emit('reset',estado.value);
          /* exitosas++;
          var exito = document.getElementById("exitosas");
          exito.value = exitosas;
          exito.dispatchEvent(new Event('input')); */
          //terminado = true;
          this.controlBotones();
          break;
        case "fallo":
          //swal("Pieza No Apta!", "", "success");
          estado.value = 'fallida';
          //estado.dispatchEvent(new Event('input'));
          window.livewire.emit('reset',estado.value);
          /* fallidas++;
          var fallo = document.getElementById("fallidas");
          fallo.value = fallidas;
          fallo.dispatchEvent(new Event('input')); */
          //terminado = true;
          this.controlBotones();
          //window.livewire.emit('reset');
          break;

        default:
          this.estado();
      }
    });
}

function manejoBotones(bool, bool1) {
  var start = document.getElementById('start');
  var resume = document.getElementById('resume');
  var reset = document.getElementById('reset');
  var stop = document.getElementById('stop');
  var enviar = document.getElementById('enviar');

  start.disabled = bool;
  reset.disabled = bool;
  resume.disabled = bool;
  stop.disabled = bool;
  enviar.disabled = bool1;
}

function controlBotones() {
  var enviado = document.getElementById('enviado').value;
  if (isMarch || (piezas == 0) || enviado == 'v') {
    manejoBotones(false, true);
  }
}
