<?php
class DataController {
	private static $conf;
	private static $renderEngine;

	public function __construct($renderEngine) {
		$this::$conf = array(
			'proxy' => 'http://localhost:8888/wp-api-theme',
			'cache' => array(
				'directory' => 'cache/json',
				'expire' => time() - 86400
		));

		$this::$renderEngine = $renderEngine;
	}

	public function render($path, $page) {
		return 
			$this::$renderEngine->render(
				$page, 
				$this->getData($path)
			);
	}

	private function getData($path) {
		$cacheFile = $this::$conf['cache']['directory'] . '/' . md5($path) . '.gz';

		if (file_exists($cacheFile) && filemtime($cacheFile) > $this::$conf['cache']['expire']) {
			$data = file_get_contents($cacheFile);
			$data = gzdecode($data);
		} else {
			$data = file_get_contents($this::$conf['proxy'] . $path);
			$this->cacheJSON($cacheFile, $data);
		}

		return json_decode($data, true);
	}

	private function makeRequest($url) {
	}

	private function cacheJSON($filename, $json) {
		$binary = gzencode($json);
		$file = fopen($filename, 'w');
	    fwrite($file, $binary); 
		fclose($file);
	}
}