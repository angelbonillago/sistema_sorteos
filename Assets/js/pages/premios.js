const frm = document.querySelector('#formulario');
const btnnuevo = document.querySelector('#btnNuevoPremio');
const modalRegistro = document.querySelector('#modalRegistro');
const title = document.querySelector('#title');

const inputFile = document.getElementById('image');
const preview = document.getElementById('preview');

const myModal = new bootstrap.Modal(modalRegistro);
let tablaPremios;
document.addEventListener('DOMContentLoaded', function () {

    //cargamos los datos en el datatable
    tablaPremios = $('#tablaPremios').DataTable({
        ajax: {
            url: base_url + 'premios/listar',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'caracteristicas' },
            {
                data: 'imagen',
                render: function (data, type, row) {
                    return '<img src="' + base_url + data + '" style="max-width:100px; max-height:100px; margin:0 auto; display:block;" />';
                }
            },
            { data: 'acciones' },

        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        },
        responsive: true,
    });

    //para cargar la foto automaticamente, cuando se a subido una foto
    inputFile.addEventListener('change', () => {

        const file = inputFile.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener('load', () => {
                preview.src = reader.result;
            });
            reader.readAsDataURL(file);
        } else {
            preview.src = base_url + '/Assets/images/regalo.jpg';
        }
    });


    btnnuevo.addEventListener('click', function () {
        title.textContent = "Nuevo Premio"
        frm.idpremio.value = '';
        frm.reset();
        preview.src = base_url + '/Assets/images/regalo.jpg'; //cargamos el regalo por defecto para que no se quede el antiguo premio
        myModal.show();
    });


    frm.addEventListener('submit', function (e) {//cuando se presione el boton de guardar
        e.preventDefault();

        if (frm.nombre.value == '' ||
            
            frm.caracteristicas.value == '' ||
            preview.src == base_url + '/Assets/images/regalo.jpg') {


            //
            alertaPersonalizada('warning', 'TODOS LOS CAMPOS SON IMPORTANTES');

        }

        else {

            const data = new FormData(frm);


            const http = new XMLHttpRequest();

            const url = base_url + 'premios/guardar';

            http.open("POST", url, true);

            http.send(data);

            http.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {

                    console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    alertaPersonalizada(res.tipo, res.mensaje);

                    cargarImgDefault(res);

                    if (res.tipo == 'success') {
                        frm.reset();
                        myModal.hide();
                        //tablaPremios.ajax.reload();
                        $('#tablaPremios').DataTable().ajax.reload(); //para recargar la tabla y aparezca los nuevos elementos.
                    }

                }
            }

        };

    });

});

function editar(id) {
    console.log('edi', id);
    const url = base_url + 'premios/editar/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();


    http.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            cargarImg(res);
            frm.nombre.value = res.nombre;
            frm.caracteristicas.value = res.caracteristicas;
            frm.idpremio.value = res.id;

            title.textContent = "Actualizar Premio"
            myModal.show();

        }
    }

}

function eliminar(id) {
    const url = base_url + 'premios/eliminar/' + id;
    eliminarRegistro('ESTAS SEGURO DE ELIMINAR', 'EL PREMIO SE ELIMINA PERMANETEMENTE', 'Si eliminar', url, tablaPremios);

}

function cargarImgDefault(res) {
    const img = document.createElement('img');
    img.src = res.imagen;

    // Agregar el elemento img al formulario o modal
    const imageContainer = document.querySelector('#preview');
    imageContainer.innerHTML = '';
    imageContainer.appendChild(img);
}


function cargarImg(res) {

    //const preview = document.querySelector('#preview');
    // Si el premio tiene imagen guardada, establecer la imagen como fuente de la etiqueta img
    if (res.imagen) {
        preview.src = base_url + res.imagen;


    } else {
        // Si no hay imagen guardada, establecer la imagen de "sin foto"
        preview.src = base_url + '/Assets/images/regalo.jpg';

    }
}