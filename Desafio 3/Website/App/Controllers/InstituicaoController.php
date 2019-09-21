<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class InstituicaoController extends Action
{
	public function instituicao()
	{
		$this->render('instituicao', 'layout');
	}

	public function instituicaoCadastrar()
	{
		$instituicao = Container::getModel('Instituicao');

		//remove caracteres especiais do cnpj
		$cnpj = $_POST['instituicaoCnpj'];
		$cnpj = str_replace(".", "", $cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);

		//verifica se a instituicao ja esta cadastrada
		if (!$instituicao->instituicaoVerificar()) {
			print_r("eh null");
			header("Location: /instituicao");
		}

		//seta a classe instituicao
		$instituicao->__set('nome', $_POST['instituicaoNome']);
		$instituicao->__set('cnpj', $cnpj);

		//verifica se o status eh ativado ou desativado
		if (!isset($_POST['instituicaoStatus']))
			$instituicao->__set('status', 0);
		else
			$instituicao->__set('status', 1);

		session_start();
		//verifica se a instituicao ja esta cadastrada
		if ($instituicao->instituicaoVerificar() != ''){
			$_SESSION["mensagem"] = $this->cadastroErro('Instituição já cadastrada!');
			header("Location: /instituicao");
		} else {
			$instituicao->instituicaoCadastrar();
			$_SESSION["mensagem"] = $this->cadastroSucesso();
			header("Location: /instituicao");
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

	public function cadastroErro($msgAlerta = '')
	{
		$mensagem = $this->modal();
		$mensagem = str_replace("[modalTipo]", "modal-erro", $mensagem);
		$mensagem = str_replace("[modalIcone]", "&#xE5CD;", $mensagem);
		$mensagem = str_replace("[modalTitulo]", "Ooops! Falha ao cadastrar a instituição!", $mensagem);
		$mensagem = str_replace("[modalMensagem]", $msgAlerta, $mensagem);
		$mensagem = str_replace("[modalBtn]", "btn-success", $mensagem);
		return $mensagem;
	}

	public function cadastroSucesso()
	{
		$mensagem = $this->modal();
		$mensagem = str_replace("[modalTipo]", "modal-sucesso", $mensagem);
		$mensagem = str_replace("[modalIcone]", "&#xE876;", $mensagem);
		$mensagem = str_replace("[modalTitulo]", "Instituição cadastrada com sucesso!", $mensagem);
		$mensagem = str_replace("[modalMensagem]", "", $mensagem);
		$mensagem = str_replace("[modalBtn]", "btn-danger", $mensagem);
		return $mensagem;
	}
}
