<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AlunoController extends Action
{
	public function aluno()
	{
		$instituicao = Container::getModel('Instituicao');
		$this->view->instituicaoAtiva = $instituicao->getInstituicoesAtivas();

		$estado = Container::getModel('Estado');
		$this->view->estados = $estado->getEstados();

		$this->render('aluno', 'layout');
	}

	public function alunoCadastrar()
	{
		session_start();

		$aluno = Container::getModel('Aluno');

		$curso = $_POST['alunoCurso'];
		$nome = $_POST['alunoNome'];
		$cpf = $_POST['alunoCpf'];
		$email = $_POST['alunoEmail'];
		$dataNascimento = $_POST['alunoData'];
		$celular = $_POST['alunoCelular'];
		$endereco = $_POST['alunoLogradouro'];
		$numero = $_POST['alunoEnderecoNum'];
		$bairro = $_POST['alunoEnderecoBairro'];
		$cidade = $_POST['alunoCidade'];

		if (
			!isset($curso) || !isset($nome) || !isset($cpf) ||
			!isset($email) || !isset($dataNascimento) || !isset($celular) ||
			!isset($endereco) || !isset($numero) || !isset($bairro) || !isset($cidade)
		) {
			$_SESSION["mensagem"] = $this->msgErro('Você deve preencher todos os campos!', 'Falha ao cadastrar o aluno');
			header("Location: /aluno#abaAlterar");
		} else {
			$cpf = str_replace(".", "", $cpf);
			$cpf = str_replace("-", "", $cpf);
			$aluno->__set('cpf', $cpf);

			if ($aluno->alunoVerificar() != '') {
				$_SESSION["mensagem"] = $this->msgErro('Aluno já cadastrado!');
				header("Location: /aluno");
			} else {
				$aluno->__set('nome', $nome);
				$aluno->__set('dataNascimento', $dataNascimento);
				$aluno->__set('email', $email);
				$aluno->__set('celular', $celular);
				$aluno->__set('endereco', $endereco);
				$aluno->__set('numero', $numero);
				$aluno->__set('bairro', $bairro);
				$aluno->__set('fk_idCidade', $cidade);
				$aluno->__set('fk_idCurso', $curso);
				$aluno->alunoCadastrar();
				$_SESSION["mensagem"] = $this->msgSucesso();
				header("Location: /aluno");
			}
		}
	}

	public function cidadeListar()
	{
		$cidade = Container::getModel('Cidade');
		$cidade->__set('fk_idEstado', $_POST['idEstado']);
		echo json_encode($cidade->getCidades());
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
		if ($msgPrincipal == '') $msgPrincipal = "Ooops! Falha ao cadastrar o aluno!";
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
		$mensagem = str_replace("[modalTitulo]", "Aluno " . $param . " com sucesso!", $mensagem);
		$mensagem = str_replace("[modalMensagem]", "", $mensagem);
		$mensagem = str_replace("[modalBtn]", "btn-danger", $mensagem);
		return $mensagem;
	}
}
