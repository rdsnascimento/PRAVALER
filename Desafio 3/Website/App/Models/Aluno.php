<?php

namespace App\Models;

use MF\Model\Model;

class Aluno extends Model
{
    private $nome;
    private $cpf;
    private $dataNascimento;
    private $email;
    private $celular;
    private $endereco;
    private $numero;
    private $bairro;
    private $fk_idCidade;
    private $fk_idEstado;
    private $fk_idCurso;
    private $status;

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function alunoListar()
    {
        $query = "select aluno.nome, cpf, dataNascimento, email, celular, endereco, numero, bairro, nomeCidade, uf, curso.nome as nomeCurso, instituicao.nome as nomeInstituicao, aluno.status as status 
        from instituicao, curso, aluno, cidade, estado 
        where fk_idCidade = idCidade and aluno.fk_idEstado = idEstado and fk_idCurso = idCurso and cnpj = fk_cnpj
        and instituicao.status = 0 and curso.status = 0"; 
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function alunoCadastrar()
    {
        $query = "insert into aluno(nome, cpf, dataNascimento, email, celular, endereco, numero, bairro, fk_idCidade, fk_idEstado, fk_idCurso, status) values(:nome, :cpf, :dataNascimento, :email, :celular, :endereco, :numero, :bairro, :fk_idCidade, :fk_idEstado, :fk_idCurso, :status)";
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
        $stmt->bindValue(':fk_idEstado', $this->__get('fk_idEstado'));
        $stmt->bindValue(':fk_idCurso', $this->__get('fk_idCurso'));
        $stmt->bindValue(':status', $this->__get('status'));
        $stmt->execute();
        return $this;
    }

    public function alunoAlterar()
    {
        $query = "update aluno set nome = :nome, 
            dataNascimento = :dataNascimento, 
            email = :email, 
            celular = :celular,
            endereco = :endereco,
            numero = :numero,
            bairro = :bairro,
            fk_idCidade = :fk_idCidade,
            fk_idEstado = :fk_idEstado,
            fk_idCurso = :fk_idCurso,
            status = :status
            where cpf = :cpf";
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
        $stmt->bindValue(':fk_idEstado', $this->__get('fk_idEstado'));
        $stmt->bindValue(':fk_idCurso', $this->__get('fk_idCurso'));
        $stmt->bindValue(':status', $this->__get('status'));
        $stmt->execute();
        return $this;
    }

    public function alunoVerificar()
    {
        $query = "select * from aluno where cpf = :cpf";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function alunoDeletar(){
        $query = "delete from aluno where cpf = :cpf";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->execute();
    }

    public function getAlunos()
    {
        $query = "select * from aluno order by nome";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
