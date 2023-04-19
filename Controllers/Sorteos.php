<?php
class Sorteos extends Controller
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
        $data['title'] = "Genera tu sorteo";
        $data['script'] = "sorteos.js";
        $this->views->getView('sorteos', 'index', $data);
    }

    public function sortear()
    {
        //print_r($_SESSION);
        $data['title'] = "Empecemos tu sorteo";
        //$data['script'] = "sorteos.js";
        $this->views->getView('sorteos', 'index', $data);
    }

   

    public function listar()
    {

        $data = $this->model->getSorteos();
        //si quiero unir dos columnas,con un for se puede hacer
        for ($i = 0; $i < count($data); $i++) {
            # code...
            if ($data[$i]['estado'] == 0) {
                $data[$i]['estado'] = '<i class="material-icons-two-tone">cancel</i> ';
            } else {
                $data[$i]['estado'] = '<i class="material-icons-two-tone">check_circle</i>';
            }
            $data[$i]['acciones'] = '
                <div>
                    <a href="#" class ="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')">
                        <span class="material-icons-two-tone">delete_outline</span>
                    </a>
                    <a href="#" class ="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')">
                        <span class="material-icons-two-tone">edit</span>
                    </a>
                        <a href="#" class ="btn btn-info btn-sm" name="boton_premio_sorteo" id="boton_premio_sorteo" onclick="premios_sorteo(' . $data[$i]['id'] . ')">
                            <span class="material-icons-two-tone">stars</span>
                        </a>

                </div>';
        }


        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar($id)
    {
        $data = $this->model->eliminar($id);
        if ($data == 1) {
            # code...
            $res = array('tipo' => 'success', 'mensaje' => 'Sorteo Eliminado!!!');
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'error al elimninar');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function editar($id)
    {
        $data = $this->model->getSorteo($id);

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function guardar()
    {
        $nombre = $_POST['nombre'];
        $intentos = $_POST['intentos'];
        $fechafin = $_POST['fechafin'];
        $fechainicio = $_POST['fechainicio'];
        $idsorteo = $_POST['idsorteo'];

        if ($idsorteo == '') {
            # code...
            //solo agrega
            $data = $this->model->guardar($nombre, $intentos, $fechafin, $fechainicio);

            if ($data > 0) {
                # code...
                $res = array('tipo' => 'success', 'mensaje' => 'Sorteo registrado!!!');
            } else {
                $res = array('tipo' => 'warning', 'mensaje' => 'error al registrar');
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        } else {
            //actualiza
            $data = $this->model->actualiza($nombre, $intentos, $fechafin, $fechainicio, $idsorteo);
            if ($data ==1) {
                # code...
                $res = array('tipo' => 'success', 'mensaje' => 'Sorteo Actualizado!!!');
            } else {
                $res = array('tipo' => 'warning', 'mensaje' => 'error al actualizar');
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function guardarpremiosorteo(){

        //print_r($_POST);
        $premiosSeleccionados = json_decode(file_get_contents('php://input'), true);
        $data = $this->model->insertarpremiosorteo($premiosSeleccionados);

        if($data =='ok'){
            $res = array('tipo' => 'success', 'mensaje' => 'Premio Registrado!!!');

        }else{
            $res = array('tipo' => 'warning', 'mensaje' => 'error al Insertar');

        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();


    }

    public function sorteosvalidos(){
        $data = $this->model->getSorteos();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

  

    


 
}
