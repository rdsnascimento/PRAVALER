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

		$this->setRoutes($routes);
	}

}

?>