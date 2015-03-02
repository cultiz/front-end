<?php
class AppConfig {
	private $conf;
	private $app;
	private $renderEngine;

	public function __construct() {
		$this->conf = array(
			"proxy" 		=> "http://localhost:8888/wp-api-theme",
			"lib" 			=> "lib/",
			"views"			=> "app/views/",
			"controllers" 	=> "app/controllers/",
			"css" 			=> "public/css/",
			"js" 			=> "public/js/",
			"img" 			=> "public/img/",
			"cache_tpl" 	=> "cache/views/",
			"cache_json" 	=> "cache/json/",
			"cache_ttl"		=> time() - 86400
		);

		$this->app = new \Slim\Slim(array(
		    'debug' => true
		));

		$loader = new Twig_Loader_Filesystem($this->getValue('views'));
		$twig = new Twig_Environment(
		    $loader, 
		    array(
		        'cache' => $this->getValue('cache_tpl')
		));
		$this->renderEngine = $twig;
	}

	public function getValue($var) {
		return $this->conf[$var];
	}

	public function getApp() {
		return $this->app;
	}

	public function getRenderEngine() {
		return $this->renderEngine;
	}
}