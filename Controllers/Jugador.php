<?php
class Jugador extends Controller
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
        $data['title'] = "Jugadores";
        $data['script'] = "jugador.js";
        $this->views->getView('jugador', 'index', $data);
    }

    public function listar($idsorteo){

        $data = $this->model->getJugadorSorteo($idsorteo);
        //print_r($data);
        //exit();
        //header('Content-Type: application/json'); // Agrega este encabezado

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function insertarjugador(){
        $jugador = json_decode(file_get_contents("php://input"), true);
        $data = $this->model->existejugador($jugador);

        
        if (empty($data)) {
            //echo "No se encontraron registros";
            //No existe el jugador, procede a insertarlo
            $id_utlimo = $this->model->insertarjugador($jugador);
            $data =  $this->model->jugador_sorteo($jugador,$id_utlimo);

        } else {
            // dicho DNI ya esta insertado
            
            //validar si es el mismo id_sorteo, en caso no lo sea, hacer un insert pero con ese id que no se encuentra.
            $result =  $this->model->mismo_sorteo($jugador);          

            if (empty($result)) {

                echo "No se encontraron registros";
                //Insertar al jugador con su nuevo sorteo!
                $id_utlimo = $this->model->obtenerId($jugador['dni']);
                $data =  $this->model->jugador_sorteo($jugador,$id_utlimo[0]['id_jugador']);

            }
        }
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


}
