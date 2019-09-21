<?php

namespace App\Models;
use MF\Model\Model;

class Curso extends Model {
    private $nome;
    private $duracao;
    private $status;
    private $fk_cnpj;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function cursoVerificar(){
        $query = "select * from curso where nome = :nome and fk_cnpj = :fk_cnpj";    
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':fk_cnpj', $this->__get('fk_cnpj'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function cursoCadastrar(){
        $query = "insert into curso(nome, duracao, status, fk_cnpj) values(:nome, :duracao, :status, :fk_cnpj)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':duracao', $this->__get('duracao'));
        $stmt->bindValue(':status', $this->__get('status'));
        $stmt->bindValue(':fk_cnpj', $this->__get('fk_cnpj'));
        $stmt->execute();
        return $this;
    }

    public function cursoListar(){
        $query = "select * from curso where fk_cnpj = :fk_cnpj";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':fk_cnpj', $this->__get('fk_cnpj'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}