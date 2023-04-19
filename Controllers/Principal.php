<?php
class Principal extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        /* if (!isset($_SESSION['id'])) {
            // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
            header('Location: '.BASE_URL);
            exit;
        }  */      
    }

    public function index()
    {
        $data['title'] = "Iniciar Sesion";

        $this->views->getView('principal', 'index', $data);
    }

    public function cerrar_sesion()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
    }

    public function validar()
    {
        # code...
        //print_r($_POST); //para saber que esta llegando
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena']; //llega como String
        $data = $this->model->getUsuario($correo);
        //print_r($data);

        if (!empty($data)) { //hubo algun registro con el correo que se mandó
            # code...
            if (password_verify($contrasena, $data["clave"])) {
                //print('es ok!');
                $_SESSION['id'] = $data['id'];
                $_SESSION['correo'] = $data['correo'];
                $_SESSION['nombre'] = $data['nombre'];
                $res = array('icono' => 'success', 'mensaje' => 'Bienvenido');
            } else {
                //print("Incorrecto");
                $res = array('icono' => 'warning', 'mensaje' => 'Contaseña Incorrecta');
                //alertaPersonalizada('warning',"Datos invalids");
            }
        } else {
            # code...
            $res = array('icono' => 'info', 'mensaje' => 'Usuario no existe');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
