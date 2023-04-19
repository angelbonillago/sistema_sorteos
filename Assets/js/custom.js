// Here goes your custom javascript
//alertaPersonalizada('success',"hola1!!")
function alertaPersonalizada(icono, mensaje) {
  Swal.fire({
    position: 'top-end',
    icon: icono,
    title: mensaje,
    showConfirmButton: false,
    timer: 1500
  })
}

function spinerPersonalizado(mensaje) {

  let timerInterval
  Swal.fire({
    title: 'Auto close alert!',
    html: 'I will close in <b></b> milliseconds.',
    timer: 2000,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading()
      const b = Swal.getHtmlContainer().querySelector('b')
      timerInterval = setInterval(() => {
        b.textContent = Swal.getTimerLeft()
      }, 100)
    },
    willClose: () => {
      clearInterval(timerInterval)
    }
  }).then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
      console.log('I was closed by the timer')
    }
  })
}


function eliminarRegistro(titulo, texto, accion, url, table) {
  Swal.fire({
    title: titulo,
    //title: 'Are you sure?',
    //text: "You won't be able to revert this!",
    text: texto,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: accion
  }).then((result) => {
    if (result.isConfirmed) {

      const http = new XMLHttpRequest();

      http.open("GET", url, true);

      http.send();

      http.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

          //console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == 'success') {
            table.ajax.reload();
            //myModal.hide();
          }

        }
      }

      /*  Swal.fire(
 
         'Deleted!',
         'Your file has been deleted.',
         'success'
       ) */
    }
  })
}

function acceso(mensaje) {
  let timerInterval
  Swal.fire({
    title: mensaje,
    html: 'Redireccionando en <b></b> milliseconds.',
    timer: 2000,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading()
      const b = Swal.getHtmlContainer().querySelector('b')
      timerInterval = setInterval(() => {
        b.textContent = Swal.getTimerLeft()
      }, 100)
    },
    willClose: () => {
      clearInterval(timerInterval)
    }
  }).then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
      //console.log('I was closed by the timer');
      //console.log('base -> ',base_url);
      window.location = base_url + 'admin';
    }
  })
}