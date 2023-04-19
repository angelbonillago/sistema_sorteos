<?php
class Premios extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (!isset($_SESSION['id'])) {
            // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
            header('Location: ' . BASE_URL);
            exit;
        }
    }

    public function index()
    {
        //print_r($_SESSION);
        $data['title'] = "Guarda tus Premios";
        $data['url'] = BASE_URL;

        $data['script'] = "premios.js";
        $this->views->getView('premios', 'index', $data);
    }

   

    public function guardar()
    {
        $nombre = $_POST['nombre'];
        $caracteristicas = $_POST['caracteristicas'];
        $idpremio = $_POST['idpremio'];

        $file = $_FILES['image']; // 'file' es el nombre del input en el formulario
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        $dest_path = '';

        if ($idpremio == '') { //a guardar

            if (isset($_FILES["image"])) {
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    // El archivo es una imagen

                    $allowed_mime_types = array("image/jpeg", "image/png", "image/jpg");
                    if (in_array($check["mime"], $allowed_mime_types)) {
                        // El archivo es una imagen permitida
                        if ($file_error === 0) {
                            // Mover el archivo a la ubicación deseada
                            $dest_path = 'Assets/images/premios/' . $file_name;


                            if ($idpremio == '') {
                                //solo agrega
                                $data = $this->model->guardar($nombre, $dest_path, $caracteristicas);
                                if ($data > 0) {
                                    # code...
                                    move_uploaded_file($file_tmp, $dest_path); //guardo la img

                                    $res = array('tipo' => 'success', 'mensaje' => 'Premio registrado!!!');
                                } else {
                                    $res = array('tipo' => 'warning', 'mensaje' => 'error al registrar');
                                }
                            }
                        } else {
                            $res = array('tipo' => 'warning', 'mensaje' => 'error al guardar imagen');
                            // exit();
                        }
                    } else {
                        // El archivo no es una imagen permitida
                        $res = array('tipo' => 'warning', 'mensaje' => 'Solo se permite formatos JPG,JPEG!!!');
                    }
                } else {
                    // El archivo no es una imagen
                    $res = array('tipo' => 'warning', 'mensaje' => 'El archivo no es una imagen');
                }
            } else {
                // print('solo esuna img');
                $res = array('tipo' => 'warning', 'mensaje' => 'Solo sube una archivo!!!');
            }
        } else {
            //a actualizar

            $data = $this->model->actualiza($nombre, $dest_path, $caracteristicas, $idpremio);
            if ($data == 1) {
                # code...
                $res = array('tipo' => 'success', 'mensaje' => 'Premio Actualizado!!!');
            } else {
                $res = array('tipo' => 'warning', 'mensaje' => 'error al actualizar');
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listar()
    {

        $data = $this->model->getPremios();
        //si quiero unir dos columnas,con un for se puede hacer
        for ($i = 0; $i < count($data); $i++) {
            # code...

            $data[$i]['acciones'] = '
                <div>
                    <a href="#" class ="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')">
                        <span class="material-icons-two-tone">delete_outline</span>
                    </a>
                    <a href="#" class ="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')">
                        <span class="material-icons-two-tone">edit</span>
                    </a>
                </div>';
        }


        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function premiostotales()
    {
        $data = $this->model->getPremios();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function premiosporsorteo($id)
    {
        $data = $this->model->getPremioSorteo($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($id)
    {
        $data = $this->model->getPremio($id);

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function eliminar($id)
    {
        $data = $this->model->eliminar($id);
        if ($data == 1) {
            # code...
            $res = array('tipo' => 'success', 'mensaje' => 'Premio Eliminado!!!');
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'error al elimninar');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    /*     public function sortear()
    {
        //print_r($_SESSION);
        $data['title'] = "Empecemos tu sorteo";
        //$data['script'] = "sorteos.js";
        $this->views->getView('sorteos', 'index', $data);
    }








*/
}
