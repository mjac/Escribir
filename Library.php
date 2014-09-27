<?php

namespace Escribir;

abstract class Library {
	protected $parsers;
	protected $articles = array();

	public function __construct() {
		$this->parsers = new \SplObjectStorage();	
	}
	
	public function getArticles() {
		return $this->articles;
	}

	public function addParser(ArticleParser $parser) {
		$this->parsers->attach($parser);
	}

	public function sortArticles($fieldGetter, $ascending = true) {
		$orderSwitch = $ascending ? 1 : -1;

		uasort($this->articles, function ($a, $b) use ($fieldGetter, $orderSwitch) {
			$aDate = $fieldGetter($a);
			$bDate = $fieldGetter($b);

			if ($aDate < $bDate) {
				return -1 * $orderSwitch;
			}

			if ($bDate < $aDate) {
				return 1 * $orderSwitch;
			}

			return 0;
		});
	}
}
