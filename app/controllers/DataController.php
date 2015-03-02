<?php
class DataController {
	private $conf;
	private $renderEngine;

	public function __construct($conf) {
		$this->conf = $conf;
		$this->renderEngine = $this->conf->getRenderEngine();
	}

	public function render($path, $page) {
		return 
			$this->renderEngine->render(
				$page, 
				$this->getData($path)
			);
	}

	private function getData($path) {
		$cacheFile = $this->conf->getValue('cache_json') . md5($path) . '.gz';

		if (file_exists($cacheFile) && filemtime($cacheFile) > $this->conf->getValue('cache_ttl')) {
			$data = file_get_contents($cacheFile);
			$data = gzdecode($data);
		} else {
			$data = file_get_contents($this->conf->getValue('proxy') . $path);
			$this->cacheJSON($cacheFile, $data);
		}

		return json_decode($data, true);
	}

	private function cacheJSON($filename, $json) {
		$binary = gzencode($json);
		$file = fopen($filename, 'w');
	    fwrite($file, $binary); 
		fclose($file);
	}
}