const btnnuevo = document.querySelector('#btnNuevoJugador');
let selectSorteo = document.getElementById("selectSorteo");
let tablajugadores;

document.addEventListener('DOMContentLoaded', function () {
    traerSorteos();


    btnnuevo.addEventListener('click', function () {

        //Mostrar spinner para consumir a la API 
        spinerAPI();
        //buscarJugadores();
        //Cerrar Spinner cuando se haya validado.

    });

    selectSorteo.addEventListener("change", () => {
        const seleccionado = selectSorteo.value;

        if (seleccionado == '') {

            alertaPersonalizada('warning', 'No se eligio un sorteo!');
            actualizarTabla();

        } else {

            //Mostrar los jugadores de dicho sorteo
            mostrarTabla(seleccionado);

        }
    });
});

async function buscarJugadores() {
    try {
        const response = await axios.get('http://127.0.0.1:8000/api/participante/');
        const jugadores = response.data; // Guardamos los valores de la respuesta en una variable

        //console.log(jugadores); // Aquí se muestra la respuesta de la API

        jugadores.forEach(jugador => {
            const jugadorData = {
                id: jugador.id,
                dni: jugador.dni,
                id_sorteo: jugador.id_sorteo,
                intentos: jugador.intentos,
            };
            enviarJugador(jugadorData);

        });
        
    } catch (error) {
        console.error('error -> '+error);
    }
}

async function enviarJugador(jugadorData) {
    let direccion = base_url + 'jugador/insertarjugador';

    axios.post(direccion, jugadorData, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
            
        });
}


async function spinerAPI() {
    try {
        // Comprobar si la API está disponible
        await axios.get('http://127.0.0.1:8000/api/participante/');

        // Mostrar el spinner
        Swal.fire({
            title: 'Procesando',
            html: 'Por favor espere...',
            allowOutsideClick: false,
            didOpen: async () => {
                // medir el tiempo que tarda el proceso
                const start = new Date().getTime();
                await buscarJugadores();
                const end = new Date().getTime();
                const duration = end - start;

                // cerrar la alerta después de que termine el proceso
                Swal.close();

                // mostrar una alerta de éxito con la duración del proceso
                Swal.fire({
                    title: 'Éxito',
                    html: `El proceso tardó ${duration} milisegundos`,
                    icon: 'success'
                });
            }
        });
    } catch (error) {
        // Mostrar alerta personalizada si la API no está disponible
        //console.log(error);
        //console.log('aquii')
        alertaPersonalizada('warning','La API no está disponible en este momento. Por favor, inténtalo de nuevo más tarde.');
    }
}



function traerSorteos() {

    const url = base_url + 'sorteos/sorteosvalidos/';
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();


    http.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            //console.log('informaci -> ', this.responseText);
            let response = JSON.parse(this.responseText);
            cargarSorteo(response);

        }
    }
}

function cargarSorteo(response) {
    //const selectSorteo = document.getElementById("selectSorteo");

    // Agregar la opción vacía al principio
    selectSorteo.add(new Option("Elige un Sorteo", "", true));

    // Agregar las opciones del response
    response.forEach(({ id, nombre }) => {
        selectSorteo.add(new Option(nombre, id));
    });
}

function destruirTabla() {

    if ($.fn.DataTable.isDataTable('#tablajugadores')) {
        $('#tablajugadores').DataTable().destroy();
    }
}

function actualizarTabla() {
    $('#tablajugadores').DataTable().clear().draw();
}

function mostrarTabla(idsorteo) {

    destruirTabla();

    // inicializar la tabla después de mostrar la alerta
    tablajugadores = $('#tablajugadores').DataTable({
        ajax: {
            url: base_url + 'jugador/listar/' + idsorteo,
            dataSrc: ''
        },
        columns: [
            { data: 'id_jugador_sorteo' },
            { data: 'nombre' },
            { data: 'dni' },
            { data: 'intentos' },

        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        },
        responsive: true,

        initComplete: function (settings, json) {
            if (tablajugadores.data().any()) {
                // se han proporcionado datos para al menos una columna
            } else {
                // no se han proporcionado datos para ninguna columna
                //mostrar alerta
                alertaPersonalizada('warning', 'No se encontraron jugadores');
            }
        }

    });

}
