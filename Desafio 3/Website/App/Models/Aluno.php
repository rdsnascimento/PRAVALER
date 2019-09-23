<?php

namespace App\Models;
use MF\Model\Model;

class Aluno extends Model {
    private $nome;
    private $cpf;
    private $dataNascimento;
    private $email;
    private $celular;
    private $endereco;
    private $numero;
    private $bairro;
    private $fk_idCidade;
    private $fk_idCurso;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function alunoCadastrar(){
        $query = "insert into aluno(nome, cpf, dataNascimento, email, celular, endereco, numero, bairro, fk_idCidade, fk_idCurso) values(:nome, :cpf, :dataNascimento, :email, :celular, :endereco, :numero, :bairro, :fk_idCidade, :fk_idCurso)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->bindValue(':dataNascimento', $this->__get('dataNascimento'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':celular', $this->__get('celular'));
        $stmt->bindValue(':endereco', $this->__get('endereco'));
        $stmt->bindValue(':numero', $this->__get('numero'));
        $stmt->bindValue(':bairro', $this->__get('bairro'));
        $stmt->bindValue(':fk_idCidade', $this->__get('fk_idCidade'));
        $stmt->bindValue(':fk_idCurso', $this->__get('fk_idCurso'));
        $stmt->execute();
        return $this;
    }

    public function alunoVerificar(){
        $query = "select * from aluno where cpf = :cpf";    
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}