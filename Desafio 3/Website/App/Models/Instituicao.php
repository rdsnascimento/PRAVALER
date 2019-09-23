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

    public function instituicaoVerificar($param = ''){
        if($param == 'nome') //verifica apenas o nome
            $query = "select * from instituicao where nome = :nome"; 
        else //verifica nome e cnpj
            $query = "select * from instituicao where cnpj = :cnpj or nome = :nome";
            
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cnpj', $this->__get('cnpj'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function instituicaoCadastrar(){
        $query = "insert into instituicao(cnpj, nome, status) values(:cnpj, :nome, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cnpj', $this->__get('cnpj'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':status', $this->__get('status'));
        $stmt->execute();
        return $this;
    }

    public function instituicaoAlterar(){
        $query = "update instituicao set status = :status, nome = :nome where cnpj = :cnpj";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cnpj', $this->__get('cnpj'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':status', $this->__get('status'));
        $stmt->execute();
    }

    public function instituicaoDeletar(){
        $query = "delete from instituicao where cnpj = :cnpj";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cnpj', $this->__get('cnpj'));
        $stmt->execute();
    }

    public function getInstituicoes(){
        $query = "select * from instituicao";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getInstituicoesAtivas(){
        $query = "select * from instituicao where status = 0";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); 
    }
}