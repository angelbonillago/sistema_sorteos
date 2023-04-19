<?php
class JugadorModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    /* 
    public function guardar($nombre, $intentos, $fechafin, $fechainicio)
    {
        # code...
        $sql = "INSERT INTO sorteos (nombre,fecha_inicio,fecha_fin,intentos,estado) VALUES (?,?,?,?,?)";
        $datos = array($nombre, $fechainicio, $fechafin, $intentos, 0);
        return $this->insertar($sql, $datos);
    } */
    /*     public function getSorteos()
    {
        $sql = "SELECT * FROM sorteos";
        return $this->selectAll($sql);
    }
 */
    public function getJugadorSorteo($id)
    {

        $sql = "SELECT js.id_jugador_sorteo,j.dni,s.nombre,js.intentos 
        FROM jugador_sorteo js 
        INNER JOIN jugador j 
        ON(j.id_jugador=js.id_jugador) 
        INNER JOIN sorteos s 
        ON(js.id_sorteo=s.id) 
        WHERE js.id_sorteo = $id";

        return $this->selectAll($sql);
    }

    public function existejugador($jugador)
    {
        $dni = $jugador['dni'];

        $sql = "SELECT * FROM jugador WHERE dni =$dni";
        return $this->selectAll($sql);
    }

    public function insertarjugador($jugador)
    {
        $dni = $jugador['dni'];

        $sql = "INSERT INTO jugador(dni) VALUES (?)";
        $datos = array($dni);
        return $this->insertar($sql, $datos);

    }

    public function jugador_sorteo($jugador,$id_ultimo){

        $id_sorteo = $jugador['id_sorteo'];
        $intentos = $jugador['intentos'];

        $sql = "INSERT INTO jugador_sorteo(id_sorteo,id_jugador,intentos) VALUES (?,?,?)";
        $datos = array($id_sorteo,$id_ultimo,$intentos);
        return $this->insertar($sql, $datos);
    }
    public function obtenerId($dni){
        $sql = "SELECT id_jugador FROM jugador WHERE(dni=$dni)";
        return $this->selectAll($sql);
    }

    public function mismo_sorteo($jugador){
        $id_sorteo = $jugador['id_sorteo'];
        $dni = $jugador['dni'];

        $result  = $this->obtenerId($dni);
        $id_obtenido= $result[0]['id_jugador'];

        $sql = "SELECT * FROM jugador_sorteo WHERE(id_jugador=$id_obtenido AND id_sorteo=$id_sorteo)";

        return $this->selectAll($sql);

    }

}
