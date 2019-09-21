<?php

namespace App\Models;
use MF\Model\Model;

class Instituicao extends Model {
    private $cnpj;
    private $nome;
    private $status;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function instituicaoVerificar(){
        $query = "select * from instituicao where cnpj = :cnpj or nome = :nome";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cnpj', $this->__get('cnpj'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function instituicaoCadastrar(){
        $query = "insert into Instituicao(cnpj, nome, status) values(:cnpj, :nome, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cnpj', $this->__get('cnpj'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':status', $this->__get('status'));
        $stmt->execute();
        return $this;
    }
}