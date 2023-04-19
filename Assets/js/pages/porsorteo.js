const frm = document.querySelector('#formulario');
const frmpremios = document.querySelector('#formulariopremios');

const btnnuevo = document.querySelector('#btnNuevoSorteo');
const btnnuevoPremio = document.querySelector('#boton_premio_sorteo');

const modalRegistro = document.querySelector('#modalRegistro');
const modalRegistroPremio = document.querySelector('#modalRegistroPremio');

const title = document.querySelector('#title');
const titlepremio = document.querySelector('#titlepremio');

const myModal = new bootstrap.Modal(modalRegistro);
const myModalPremio = new bootstrap.Modal(modalRegistroPremio);

let tablasorteos;
document.addEventListener('DOMContentLoaded', function () {

    //cargamos los datos en el datatable

    tablasorteos = $('#tablasorteos').DataTable({
        ajax: {
            url: base_url + 'sorteos/listar',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'fecha_inicio' },
            { data: 'fecha_fin' },
            { data: 'intentos' },
            { data: 'estado' },
            { data: 'acciones' },

        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        },
        responsive: true,
    });

    btnnuevo.addEventListener('click', function () {
        title.textContent = "Nuevo Sorteo"
        frm.idsorteo.value = '';
        frmpremios.idsorteopremio.value = '';
        frm.reset();
        myModal.show();
    });



    frm.addEventListener('submit', function (e) {//cuando se presione el boton de guardar
        e.preventDefault();

        if (frm.nombre.value == '' ||
            frm.intentos.value == '' ||
            frm.fechafin.value == '' ||
            frm.fechainicio.value == '') {
            alertaPersonalizada('warning', 'TODOS LOS CAMPOS SON IMPORTANTES');

        } else {
            //alertaPersonalizada('success', 'Envio correcto!');
            //registrarlo en la tabla

            const data = new FormData(frm);

            const http = new XMLHttpRequest();

            const url = base_url + 'sorteos/guardar';

            http.open("POST", url, true);

            http.send(data);

            http.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {

                    console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    alertaPersonalizada(res.tipo, res.mensaje);
                    if (res.tipo == 'success') {
                        frm.reset();
                        myModal.hide();
                        tablasorteos.ajax.reload();
                        //$('#tablasorteos').DataTable().ajax.reload(); //para recargar la tabla y aparezca los nuevos elementos.
                    }

                }
            }

        };

    });
});


function editar(id) {

    const url = base_url + 'sorteos/editar/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();


    http.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            frm.nombre.value = res.nombre;
            frm.intentos.value = res.intentos;
            frm.fechainicio.value = res.fecha_inicio;
            frm.fechafin.value = res.fecha_fin;
            frm.idsorteo.value = res.id;
            title.textContent = "Actualizar Sorteo"
            myModal.show();

        }
    }

}

$(document).on('click', '.quitarPremio', function () {
    $(this).closest('.row').remove();
});


// Manejador de eventos para el botón de "Agregar"
$('#agregarPremio').click(async function () {

    try {
        // Obtener los premios en formato JSON
        const premios = await traerPremios('');

        // Crear un nuevo elemento div que contendrá el select y el botón "Quitar"
        var nuevoDiv = $('<div></div>').addClass('row mb-3');
        var nuevoSelect = $('<select></select>').addClass('col-md-6').attr('name', 'premionombre');

        nuevoDiv.append(nuevoSelect);

        // Agregar opciones al nuevo select
        for (var i = 0; i < premios.length; i++) {
            var nuevaOpcion = $('<option></option>').attr('value', premios[i].id).text(premios[i].nombre);
            nuevoSelect.append(nuevaOpcion);
        }

        // Agregar un botón "Quitar" al nuevo div
        var nuevoBoton = $('<button></button>').addClass('btn btn-danger quitarPremio col-md-6').text('Quitar');
        nuevoDiv.append(nuevoBoton);

        // Agregar el nuevo div al HTML
        $('#premiosdinamicos').append(nuevoDiv);

        // Manejador de eventos para el botón de "Quitar"
        nuevoBoton.click(function () {
            $(this).parent().remove(); // Eliminar el div completo que contiene tanto el select como el botón
        });

    } catch (error) {
        console.error(error);
    }
});


// Manejador de eventos para el botón de "Guardar"
function traerPremios(id) {

    if (id == '') {

        return new Promise((resolve, reject) => {
            const url = base_url + 'premios/premiostotales';
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    resolve(res);
                }
            };
        });

    } else {
        frmpremios.idsorteopremio.value = id

        //traer premios por sorteo por ID
        return new Promise((resolve, reject) => {
            const url = base_url + 'premios/premiosporsorteo/' + id;

            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    resolve(res);
                }
            };
        });


    }
}

function eliminar(id) {
    const url = base_url + 'sorteos/eliminar/' + id;
    eliminarRegistro('ESTAS SEGURO DE ELIMINAR', 'EL SORTEO SE ELIMINA PERMANETEMENTE', 'Si eliminar', url, tablasorteos);

}

function premios_sorteo(id) {

    titlepremio.textContent = "Registra Premios del Sorteo"
    //antes de mostrar el modal, debo verificar si dicho sorteo tiene premios registrados, en caso no lo tenga, mostrar el modal vacio.

    const premiosobtenidos = traerPremios(id);
    premiosobtenidos.then(function (resultados) {
        if (resultados.length > 0) {
            // hay premios registrados

            resultados.forEach(function (resultado) {
                /*                 console.log('ID REGISTRO', resultado.id_premio_sorteo);
                                console.log('ID id_sorteo', resultado.id_sorteo);
                                console.log('ID id_premio', resultado.id_premio);
                                console.log('ID id_premio', resultado.nombre);
                 */


                // Crear un nuevo elemento div que contendrá el select y el botón "Quitar"
                nuevoDiv = $('<div></div>').addClass('form-group row mb-3');
                nuevoSelect = $('<select></select>').addClass('form-control col-md-6').attr('name', 'premionombre');

                // Agregar opciones al nuevo select
                nuevaOpcion = $('<option></option>').attr('value', resultado.id_premio_sorteo).text(resultado.nombre);
                nuevoSelect.append(nuevaOpcion);

                // Agregar el select al nuevo div
                nuevoDiv.append(nuevoSelect);

                // Agregar un botón "Quitar" al nuevo div
                nuevoBoton = $('<button></button>').addClass('btn btn-danger quitarPremio col-md-6').text('Quitar');
                nuevoDiv.append(nuevoBoton);

                // Agregar el nuevo div al HTML
                $('#premiosdinamicos').append(nuevoDiv);

                // Manejador de eventos para el botón de "Quitar"
                nuevoBoton.click(function () {
                    $(this).parent().remove(); // Eliminar el div completo que contiene tanto el select como el botón
                });
            });


        }
    });

    myModalPremio.show();
    nuevoDiv = $('#premiosdinamicos');// obtener una referencia al último elemento agregado
    nuevoDiv.empty();

}


$('#guardarPremios').click(function (event) {
    event.preventDefault(); // evita que se recargue la página al hacer submit en el formulario

    var premiosSeleccionados = []; // arreglo para almacenar los premios seleccionados
    var id_sorteo = document.getElementsByName("idsorteopremio")[0].value;

    // Recorre cada select dentro del div premiosdinamicos
    $('#premiosdinamicos select').each(function () {
        var nombre = $(this).find('option:selected').text(); // Obtiene el nombre del premio seleccionado
        var valor = $(this).val(); // Obtiene el valor del select actual

        if (valor !== '') { // Si el valor es distinto a una cadena vacía

            var premioSeleccionado = {
                id: valor,
                idsorteopremio: id_sorteo,
                nombre: nombre
            };
            premiosSeleccionados.push(premioSeleccionado); // Agrega el valor al arreglo
        }
    });

    console.log('premiosSeleccionados---> ', premiosSeleccionados)
    return
    var cantidad = premiosSeleccionados.length;

    if(cantidad>0){

    }else{
        console.log(cantidad);

    }
    return; //revosar para ver si llega la informaCIOON

    const http = new XMLHttpRequest();

    const url = base_url + 'sorteos/guardarpremiosorteo';

    http.open("POST", url, true);

    // Convertir el arreglo a una cadena de texto en formato JSON
    const premiosSeleccionadosTexto = JSON.stringify(premiosSeleccionados);

    // Establecer la cabecera "Content-Type" para indicar que se está enviando datos en formato JSON
    http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    http.send(premiosSeleccionadosTexto);

    http.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            alertaPersonalizada(res.tipo, res.mensaje);
            if (res.tipo == 'success') {
                frm.reset();
                myModalPremio.hide();
                tablasorteos.ajax.reload();
                //$('#tablasorteos').DataTable().ajax.reload(); //para recargar la tabla y aparezca los nuevos elementos.
            } else {
                console.log('else');
            }

        }
    }
});


