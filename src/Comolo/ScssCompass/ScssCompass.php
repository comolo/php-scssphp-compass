<?php
namespace Comolo\ScssCompass;

class ScssCompass {
	protected $libFunctions = array("lib_compact");
	
	static public $true = array("keyword", "true");
	static public $false = array("keyword", "false");

	public function __construct($scss) {
		$this->scss = $scss;
		$this->updateImportPath();
		$this->registerFunctions();
	}

	protected function updateImportPath() {
        // also contao components: vendor/contao-components/compass/css
		$this->scss->addImportPath(__DIR__ . "/stylesheets/");
	}

	protected function registerFunctions() {
		foreach ($this->libFunctions as $fn) {
			$registerName = $fn;
			if (preg_match('/^lib_(.*)$/', $fn, $m)) {
				$registerName = $m[1];
			}
			$this->scss->registerFunction($registerName, array($this, $fn));
		}
	}

	public function lib_compact($args) {
		list($list) = $args;
		if ($list[0] != "list") return $list;

		$filtered = array();
		foreach ($list[2] as $item) {
			if ($item != self::$false) $filtered[] = $item;
		}
		$list[2] = $filtered;
		return $list;
	}
}

