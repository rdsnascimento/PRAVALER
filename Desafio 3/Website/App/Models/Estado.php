<?php

namespace App\Models;
use MF\Model\Model;

class Estado extends Model {
    private $idEstado;
    private $nomeEstado;
    private $uf;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function getEstados(){
        $query = "select * from estado order by nomeEstado";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}