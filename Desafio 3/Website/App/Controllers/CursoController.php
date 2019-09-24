<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class CursoController extends Action
{

    public function curso()
    {
        $instituicao = Container::getModel('Instituicao');
        $this->view->instituicaoAtiva = $instituicao->getInstituicoesAtivas();
        
        $curso = Container::getModel('Curso');
        $this->view->cursoListar = $curso->cursoListarCompleto();

        $this->render('curso', 'layout');
    }

    public function cursoCadastrar()
    {
        session_start();
        $nome = $_POST['cursoNome'];
        $duracao = $_POST['cursoDuracao'];

        /* Se os campos estiverem vazios */
        if (!isset($nome) || !isset($duracao)) {
            $_SESSION["mensagem"] = $this->msgErro('Você deve preencher todos os campos!');
            header("Location: /curso#abaCadastrar");
        } else {
            $curso = Container::getModel('Curso');
            $curso->__set('nome', $nome);
            $curso->__set('duracao', $duracao);
            $curso->__set('fk_cnpj', $_POST['cursoInstituicao']);

            if (!isset($_POST['cursoStatus']))
                $curso->__set('status', 0);
            else
                $curso->__set('status', 1);

            if ($curso->cursoVerificar() != '') {
                $_SESSION["mensagem"] = $this->msgErro('Curso já cadastrado nesta instituição!');
                header("Location: /curso");
            } else {
                $curso->cursoCadastrar();
                $_SESSION["mensagem"] = $this->msgSucesso();
                header("Location: /curso");
            }
        }
    }

    public function cursoAlterar()
    {
        session_start();
        $nome = $_POST['cursoNome'];
        $duracao = $_POST['cursoDuracao'];
        $idCurso = $_POST['cursoId'];

        /* Se os campos estiverem vazios */
        if (!isset($nome) || !isset($duracao) || !isset($idCurso)) {
            $_SESSION["mensagem"] = $this->msgErro('Você deve preencher todos os campos!', 'Falha ao alterar o curso');
            header("Location: /curso#abaAlterar");
        } else {
            $curso = Container::getModel('Curso');
            $curso->__set('nome', $nome);
            $curso->__set('duracao', $duracao);
            $curso->__set('idCurso', $idCurso);

            if (!isset($_POST['cursoStatus']))
                $curso->__set('status', 0);
            else
                $curso->__set('status', 1);

            $curso->cursoAlterar();
            $_SESSION["mensagem"] = $this->msgSucesso('alterado');
            header("Location: /curso");
        }
    }

    public function cursoListar()
    {
        $curso = Container::getModel('Curso');
        $curso->__set('fk_cnpj', $_POST['cnpj']);
        echo json_encode($curso->cursoListar());
    }

    public function cursoListarAtivos()
    {
        $curso = Container::getModel('Curso');
        $curso->__set('fk_cnpj', $_POST['cnpj']);
        echo json_encode($curso->cursoListarAtivos());
    }

    public function cursoDeletar()
    {
        session_start();
        if (!isset($_POST['cursoId'])) {
            $_SESSION["mensagem"] = $this->msgErro('Você deve escolher um curso!', 'Falha ao tentar deletar!');
            header("Location: /curso#abaDeletar");
        } else {
            $curso = Container::getModel('Curso');
            $curso->__set('idCurso', $_POST['cursoId']);
            
            /* verifica se o curso tem aluno antes de deletar */
            if($curso->cursoDeletarVerificar() != ''){
                $_SESSION["mensagem"] = $this->msgErro('Esse curso têm alunos associados!', 'Falha ao tentar deletar!');
                header("Location: /curso#abaDeletar");
            } else {
                $curso->cursoDeletar();
                $_SESSION["mensagem"] = $this->msgSucesso('deletado');
                header("Location: /curso");
            }
        }
    }

    /* Modal de alerta */
    public function modal()
    {
        $mensagem = '
		<div id="modalMensagem" class="modal fade">
			<div class="modal-dialog modal-template text-center">
				<div class="modal-content">
					<div class="[modalTipo]"> 
					<div class="icon-box">
						<i class="material-icons">[modalIcone]</i>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
					<h4>[modalTitulo]</h4>
					<p>[modalMensagem]</p>
					<button class="btn [modalBtn]" data-dismiss="modal">Fechar</button>
					</div>
				</div>
			</div>
		</div>';
        return $mensagem;
    }

    public function msgErro($msgAlerta = '', $msgPrincipal = '')
    {
        if ($msgPrincipal == '') $msgPrincipal = "Ooops! Falha ao cadastrar o curso!";
        $mensagem = $this->modal();
        $mensagem = str_replace("[modalTipo]", "modal-erro", $mensagem);
        $mensagem = str_replace("[modalIcone]", "&#xE5CD;", $mensagem);
        $mensagem = str_replace("[modalTitulo]", $msgPrincipal, $mensagem);
        $mensagem = str_replace("[modalMensagem]", $msgAlerta, $mensagem);
        $mensagem = str_replace("[modalBtn]", "btn-success", $mensagem);
        return $mensagem;
    }

    public function msgSucesso($param = 'cadastrado')
    {
        $mensagem = $this->modal();
        $mensagem = str_replace("[modalTipo]", "modal-sucesso", $mensagem);
        $mensagem = str_replace("[modalIcone]", "&#xE876;", $mensagem);
        $mensagem = str_replace("[modalTitulo]", "Curso " . $param . " com sucesso!", $mensagem);
        $mensagem = str_replace("[modalMensagem]", "", $mensagem);
        $mensagem = str_replace("[modalBtn]", "btn-danger", $mensagem);
        return $mensagem;
    }
}
