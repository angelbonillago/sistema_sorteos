<?php
class Admin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (!isset($_SESSION['id'])) {
            // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
            header('Location: '.BASE_URL);
            exit;
        } 

       
    }

    public function index()
    {
        //print_r($_SESSION);
        $data['title']="Panel";
        $this->views->getView('admin', 'home',$data);
  
    }

}
