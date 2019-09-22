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

		$routes['cursoAlterar'] = array(
			'route' => '/cursoAlterar',
			'controller' => 'cursoController',
			'action' => 'cursoAlterar'
		);

		$this->setRoutes($routes);
	}

}

?>