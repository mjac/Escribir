<?php

namespace Escribir;

abstract class Library extends \ArrayObject {
	protected $parsers;

	public function __construct() {
		$this->parsers = new \SplObjectStorage();	
	}

	public function addParser(ArticleParser $parser) {
		$this->parsers->attach($parser);
	}
}
