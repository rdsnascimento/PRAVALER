<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['instituicao'] = array(
			'route' => '/instituicao',
			'controller' => 'instituicaoController',
			'action' => 'instituicao'
		);

		$routes['instituicaoCadastrar'] = array(
			'route' => '/instituicaoCadastrar',
			'controller' => 'instituicaoController',
			'action' => 'instituicaoCadastrar'
		);

		$routes['instituicaoAlterar'] = array(
			'route' => '/instituicaoAlterar',
			'controller' => 'instituicaoController',
			'action' => 'instituicaoAlterar'
		);

		$routes['instituicaoDeletar'] = array(
			'route' => '/instituicaoDeletar',
			'controller' => 'instituicaoController',
			'action' => 'instituicaoDeletar'
		);

		$routes['curso'] = array(
			'route' => '/curso',
			'controller' => 'cursoController',
			'action' => 'curso'
		);

		$routes['cursoCadastrar'] = array(
			'route' => '/cursoCadastrar',
			'controller' => 'cursoController',
			'action' => 'cursoCadastrar'
		);

		$routes['cursoListar'] = array(
			'route' => '/cursoListar',
			'controller' => 'cursoController',
			'action' => 'cursoListar'
		);

		$routes['cursoListarAtivos'] = array(
			'route' => '/cursoListarAtivos',
			'controller' => 'cursoController',
			'action' => 'cursoListarAtivos'
		);

		$routes['cursoAlterar'] = array(
			'route' => '/cursoAlterar',
			'controller' => 'cursoController',
			'action' => 'cursoAlterar'
		);

		$routes['cursoDeletar'] = array(
			'route' => '/cursoDeletar',
			'controller' => 'cursoController',
			'action' => 'cursoDeletar'
		);

		$routes['aluno'] = array(
			'route' => '/aluno',
			'controller' => 'alunoController',
			'action' => 'aluno'
		);

		$routes['alunoCadastrar'] = array(
			'route' => '/alunoCadastrar',
			'controller' => 'alunoController',
			'action' => 'alunoCadastrar'
		);

		$routes['alunoAlterar'] = array(
			'route' => '/alunoAlterar',
			'controller' => 'alunoController',
			'action' => 'alunoAlterar'
		);

		$routes['alunoDeletar'] = array(
			'route' => '/alunoDeletar',
			'controller' => 'alunoController',
			'action' => 'alunoDeletar'
		);

		$routes['alunoAlterarListaInstituicao'] = array(
			'route' => '/alunoAlterarListaInstituicao',
			'controller' => 'alunoController',
			'action' => 'alunoAlterarListaInstituicao'
		);

		$routes['cidadeListar'] = array(
			'route' => '/cidadeListar',
			'controller' => 'alunoController',
			'action' => 'cidadeListar'
		);

		$this->setRoutes($routes);
	}

}

?>