const formulario = document.getElementById("formulario");
const contrasena = document.getElementById("contrasena");
const correo = document.getElementById("correo");

document.addEventListener('DOMContentLoaded', function () {
    formulario.addEventListener('submit', function (e) {
        e.preventDefault();

        if (correo.value == "" || contrasena.value == "") {
            alertaPersonalizada('warning', "Campos obligatoros, no deben estar vacios");

        } else {
            //peticion AJAX

            const data = new FormData(formulario); //pasamos nuestro formulario para luego obtener los campos

            const http = new XMLHttpRequest();

            const url = base_url + 'principal/validar';

            http.open("POST", url, true);

            http.send(data);

            http.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {

                    //console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    alertaPersonalizada(res.icono, res.mensaje);

                    if (res.icono == 'success') { //Inicia sesion
                        acceso(res.mensaje,base_url);
                    } 

                }

            };

        }

    });
})


