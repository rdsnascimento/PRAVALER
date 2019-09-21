<?php

namespace MF\Controller;

abstract class Action {

	protected $view;

	public function __construct() {
		$this->view = new \stdClass();
	}

	protected function render($view, $layout = 'layout') {
		$this->view->page = $view;

		if(file_exists("App/Views/".$layout.".phtml")) {
			require_once "App/Views/".$layout.".phtml";
		} else {
			$this->content();
		}
	}

	protected function content($trecho = null) {
		$classAtual = get_class($this);

		$classAtual = str_replace('App\\Controllers\\', '', $classAtual);

		$classAtual = strtolower(str_replace('Controller', '', $classAtual));

		if($trecho == null){
			require_once "App/Views/".$classAtual."/".$this->view->page.".phtml";
		} else {
			require_once "App/Views/".$classAtual."/".$trecho.".phtml";
		}
	}
}

?>