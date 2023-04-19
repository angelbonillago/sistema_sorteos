<?php
class SorteosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }


    public function guardar($nombre, $intentos, $fechafin, $fechainicio)
    {
        # code...
        $sql = "INSERT INTO sorteos (nombre,fecha_inicio,fecha_fin,intentos,estado) VALUES (?,?,?,?,?)";
        $datos = array($nombre, $fechainicio, $fechafin, $intentos, 0);
        return $this->insertar($sql, $datos);
    }
    public function getSorteos()
    {
        $sql = "SELECT * FROM sorteos";
        return $this->selectAll($sql);
    }

    public function getSorteo($id)
    {
        $sql = "SELECT * FROM sorteos WHERE id=$id";
        return $this->select($sql);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM sorteos WHERE id = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function actualiza($nombre, $intentos, $fechafin, $fechainicio, $idsorteo)
    {
        $sql = "UPDATE sorteos SET nombre = ?, intentos = ?,fecha_inicio = ?,fecha_fin = ? WHERE id = ?";
        $datos = array($nombre, $intentos, $fechainicio, $fechafin, $idsorteo);
        return $this->save($sql, $datos);
    }

    public function insertarpremiosorteo($premiosSeleccionados)
    {

          $sql = "INSERT INTO premio_sorteo (id_sorteo,id_premio) VALUES (?,?)";
        //return $this->insertar($sql, $datos);
        foreach ($premiosSeleccionados as $premio) {
            $id_premio = $premio['id'];
            $idsorteopremio=$premio['idsorteopremio'];

            $datos = array($idsorteopremio, $id_premio);
            $this->insertar($sql, $datos);  
        }

        return 'ok';
    }
}
