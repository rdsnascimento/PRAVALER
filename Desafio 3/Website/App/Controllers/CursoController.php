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
        $this->view->instituicaoTodas = $instituicao->getInstituicoes();
        $this->render('curso', 'layout');
    }

    public function cursoCadastrar()
    {
        $curso = Container::getModel('Curso');
        $curso->__set('nome', $_POST['cursoNome']);
        $curso->__set('duracao', $_POST['cursoDuracao']);
        $curso->__set('fk_cnpj', $_POST['cursoInstituicao']);

        if (!isset($_POST['cursoStatus']))
            $curso->__set('status', 0);
        else
            $curso->__set('status', 1);

        session_start();
        if ($curso->cursoVerificar() != '') {
            $_SESSION["mensagem"] = $this->msgErro('Curso já cadastrado nesta instituição!');
            header("Location: /curso");
        } else {
            $curso->cursoCadastrar();
            $_SESSION["mensagem"] = $this->msgSucesso();
            header("Location: /curso");
        }
    }

    public function cursoAlterar()
    {
        $curso = Container::getModel('Curso');
        $curso->__set('nome', $_POST['cursoNome']);
        $curso->__set('duracao', $_POST['cursoDuracao']);
        $curso->__set('idCurso', $_POST['cursoId']);

        if (!isset($_POST['cursoStatus']))
            $curso->__set('status', 0);
        else
            $curso->__set('status', 1);

        session_start();
        $curso->cursoAlterar();
        $_SESSION["mensagem"] = $this->msgSucesso('alterado');
        header("Location: /curso");
    }

    public function cursoListar()
    {
        $curso = Container::getModel('Curso');
        $curso->__set('fk_cnpj', $_POST['cnpj']);
        echo json_encode($curso->cursoListar());
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

    public function msgErro($msgAlerta = '')
    {
        $mensagem = $this->modal();
        $mensagem = str_replace("[modalTipo]", "modal-erro", $mensagem);
        $mensagem = str_replace("[modalIcone]", "&#xE5CD;", $mensagem);
        $mensagem = str_replace("[modalTitulo]", "Ooops! Falha ao cadastrar o curso!", $mensagem);
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
