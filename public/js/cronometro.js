//PARA LIMPIAR CACHE Y FUNCIONE BIEN PUSHER
/* php artisan config:cache */
window.livewire.on('idTiempo', function () {
  //  console.log('id: ' + document.getElementById('idTiempo').value);
  localStorage.setItem("idTiempo", document.getElementById('idTiempo').value);
});

window.onload = function () {
  /* if (localStorage.getItem('idTiempo')) {
    var id = document.getElementById('idTiempo');
    id.value = localStorage.getItem('idTiempo');
    id.dispatchEvent(new Event('input'));
  } */
  /* if (localStorage.getItem("estado") == 'f') {
    var tiempo = document.getElementById("tiempo");
    tiempo.value = localStorage.getItem("tiempoFinal");
    tiempo.dispatchEvent(new Event('input'));
    this.estado();
  } */
  console.log('estado: ' + localStorage.getItem("estado"));
  idTiempo = localStorage.getItem("idTiempo");
  /* if (localStorage.getItem("idTiempo")) {
    localStorage.removeItem("estado");
  } */
  window.livewire.emit('recarga', idTiempo);

  if (localStorage.getItem("final1") == 'ok' && localStorage.getItem("final2") != 'ok') {
    estado();
  }

  //console.log('ls: '+localStorage.getItem("inicio"));
  //localStorage.removeItem("inicio");
  if (localStorage.getItem("inicio") != null) {
    //enviado.value = 'f';
    /* terminado = false;
    isMarch = true;
    isStart = true; */
    //timeInicial = localStorage.getItem("inicio");
    control = setInterval(cronometro, 10);

  }

}
var pantalla = document.getElementById("screen");
/* var isMarch = false;
var isStart = false;
var terminado = false;
var setEstado = false;
var piezas = 0;
var exitosas = 0;
var fallidas = 0; */
var tiempoPieza = '00:00:00';
var acumularTime = 0;

function start() {
  if (localStorage.getItem("estado") == null) {
    localStorage.setItem("estado", 'inicio');
    // this.controlBotones();
    //var enviado = document.getElementById('enviado');
    /* if (enviado.value == 'f') {
      swal("Debe enviar antes de empezar!", "si ya se envio espere notificacion de envio exitoso", "error");
    } else { */
    //enviado.value = 'f';
    /* terminado = false;
    isStart = true; */
    timeStart = new Date();
    //console.log("Empieza: " + timeStart);
    timeInicial = new Date();
    //console.log(timeInicial);
    localStorage.setItem("inicio", timeInicial);

    control = setInterval(cronometro, 1000);
    //isMarch = true;
    //localStorage.setItem("idTiempo", document.getElementById('idTiempo').value);
    window.livewire.emit('start', tiempoPieza);
    //}

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
  hh = acumularTime2.getHours() - 21;

  if (cc < 10) { cc = "0" + cc; }
  if (ss < 10) { ss = "0" + ss; }
  if (mm < 10) { mm = "0" + mm; }
  if (hh < 10) { hh = "0" + hh; }

  tiempoPieza = hh + " : " + mm + " : " + ss;
  //+ " : " + cc
  localStorage.setItem("tiempo", tiempoPieza);
  //localStorage.removeItem("inicio");
  // if(localStorage.getItem("inicio")!=null)
  //inicio=localStorage.getItem("inicio");
  pantalla.innerHTML = tiempoPieza;
}

function stop() {

  if (isMarch == true) {
    timeStop = new Date();
    //console.log("Pausa: " + timeStop);
    clearInterval(control);
    isMarch = false;
    //console.log(localStorage.getItem("inicio"));
  }
}

function resume() {

  if (isMarch == false & isStart == true) {
    timeResume = new Date();
    //console.log("Continua: " + timeResume);
    timeActu2 = new Date();
    timeActu2 = timeActu2.getTime();
    acumularResume = timeActu2 - acumularTime;

    timeInicial.setTime(acumularResume);
    control = setInterval(cronometro, 1000);
    isMarch = true;
  }
}

function reset() {
  //localStorage.setItem("estado", 'f');
  localStorage.setItem("tiempoFinal", tiempoPieza);
  //localStorage.setItem("idTiempo", document.getElementById('idTiempo').value);
  /* var tiempo = document.getElementById("tiempo");
  tiempo.value = tiempoPieza;
  tiempo.dispatchEvent(new Event('input'));
  tiempo = ''; */
  if (localStorage.getItem("estado") != null) {

    clearInterval(control);
    //isMarch = false;

    localStorage.removeItem("inicio");
    timeReset = new Date();
    //console.log("Termina: " + timeReset);
    //isStart = false;
    acumularTime = 0;
    pantalla.innerHTML = "00 : 00 : 00";

    //var cantidad = document.getElementById("cantidad");
    //terminado = true;
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
  localStorage.setItem("final1", 'ok');
  //var estado = document.getElementById("estado");
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
          //estado.value = 'exitosa';
          //estado.dispatchEvent(new Event('input'));

          /* exitosas++;
          var exito = document.getElementById("exitosas");
          exito.value = exitosas;
          exito.dispatchEvent(new Event('input')); */
          //terminado = true;
          //this.controlBotones();
          //setEstado = true;
          //localStorage.setItem("estado", 'v');
          localStorage.removeItem("idTiempo");
          localStorage.removeItem("estado");
          localStorage.setItem("final2", 'ok');
          window.livewire.emit('reset', 'exitosa', tiempoPieza);
          break;
        case "fallo":
          //swal("Pieza No Apta!", "", "success");
          //estado.value = 'fallida';
          //estado.dispatchEvent(new Event('input'));
          /* fallidas++;
          var fallo = document.getElementById("fallidas");
          fallo.value = fallidas;
          fallo.dispatchEvent(new Event('input')); */
          //terminado = true;
          /* this.controlBotones();
          setEstado = true; */
          //localStorage.setItem("estado", 'v');
          localStorage.removeItem("idTiempo");
          localStorage.removeItem("estado");
          localStorage.setItem("final2", 'ok');
          window.livewire.emit('reset', 'fallida', tiempoPieza);
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
  //enviar.disabled = bool1;
}

function controlBotones() {
  //var enviado = document.getElementById('enviado').value;
  if (isMarch || (piezas == 0)) {
    manejoBotones(false, true);
  }
}

function motivoPausa() {
  if (localStorage.getItem("estado") == 'inicio') {

    //localStorage.setItem("estadoPausa", 'v');
    $("#avisoPausa").hide();
    swal("Cual es el motivo de la pausa?", {
      buttons: {

        catch1: {
          text: "Maquina",
          value: "Maquina",
        },
        catch2: {
          text: "Refrigerio/Baño",
          value: "Refrigerio/Baño",
        },
        catch3: {
          text: "Herramienta/Inserto",
          value: "Herramienta/Inserto",
        },
        catch4: {
          text: "Material",
          value: "Material",
        },
      },
    })
      .then((value) => {
        switch (value) {
          case "Maquina":
            //console.log('Maquina');
            //var tiempo = document.getElementById("tiempo").value;
            localStorage.setItem("estado", 'pausa');
            window.livewire.emit('pausa', value);
            break;
          case "Refrigerio/Baño":
            //console.log('Refrigerio/Baño');
            localStorage.setItem("estado", 'pausa');
            window.livewire.emit('pausa', value);
            break;
          case "Herramienta/Inserto":
            //console.log('Herramienta/Inserto');
            localStorage.setItem("estado", 'pausa');
            window.livewire.emit('pausa', value);
            break;
          case "Material":
            //console.log('Material');
            localStorage.setItem("estado", 'pausa');
            window.livewire.emit('pausa', value);
            break;

          default:
            this.motivoPausa();
        }
        
        console.log('estado: ' + localStorage.getItem("estado"));
      });
  }
}

function finPausa() {
  if (localStorage.getItem("estado") == 'pausa') {
    localStorage.setItem("estado", 'inicio');
    console.log('estado: ' + localStorage.getItem("estado"));
    window.livewire.emit('finPausa');
  }
}

function clickArticulo(cod){
  window.livewire.emit('clickArticulo',cod);
}

