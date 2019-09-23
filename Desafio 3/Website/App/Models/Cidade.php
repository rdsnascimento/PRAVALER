<?php

namespace App\Models;
use MF\Model\Model;

class Cidade extends Model {
    private $idCidade;
    private $nomeCidade;
    private $fk_idEstado;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function getCidades(){
        $query = "select * from cidade where fk_idEstado = :fk_idEstado";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':fk_idEstado', $this->__get('fk_idEstado'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}