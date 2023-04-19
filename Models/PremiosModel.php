<?php
class PremiosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }


    public function guardar($nombre, $imagen, $caracteristicas)
    {
        # code...
        $sql = "INSERT INTO premios (nombre,imagen,caracteristicas) VALUES (?,?,?)";
        $datos = array($nombre, $imagen, $caracteristicas);
        return $this->insertar($sql, $datos);
    }


    public function getPremios()
    {
        $sql = "SELECT * FROM premios";
        return $this->selectAll($sql);
    }

    public function getPremio($id)
    {
        $sql = "SELECT * FROM premios WHERE id=$id";
        return $this->select($sql);
    }

    public function getPremioSorteo($id)
    {
        $sql = "SELECT pst.id_premio_sorteo,pst.id_sorteo,pst.id_premio,p.nombre FROM premio_sorteo pst INNER JOIN premios p ON(pst.id_premio=p.id) WHERE id_sorteo=$id;";
        return $this->selectAll($sql);
    }

    public function actualiza($nombre, $imagen, $caracteristicas, $idpremio)
    {
        if ($imagen == '') {
            // no actualices el campo img
            $sql = "UPDATE premios SET nombre = ?, caracteristicas = ? WHERE id = ?";
            $datos = array($nombre, $caracteristicas, $idpremio);

        } else {
            //actualiza el campo img
            $sql = "UPDATE premios SET nombre = ?, imagen = ?,caracteristicas = ? WHERE id = ?";
            $datos = array($nombre, $imagen, $caracteristicas, $idpremio);

        }
        return $this->save($sql, $datos);
    }

    public function eliminar($id)
    {

        //Eliminar la img de la carpeta
        $premio = $this->getPremio($id);
        if ($premio['imagen'] && file_exists($premio['imagen'])) {
            unlink($premio['imagen']);
        }

        $sql = "DELETE FROM premios WHERE id = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }
}
