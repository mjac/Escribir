<?php

namespace Escribir;

class XhtmlDOMDocument extends \DOMDocument {
	public function loadXhtml($data) {
		$this->loadXML('<div>' . $data . '</div>');

		$domXPath = new \DOMXPath($this);
		$nonEmpty = $domXPath->query('//iframe | //script');
		foreach ($nonEmpty as $tag) {
			$tag->appendChild($this->createTextNode(''));
		}
	}

	public function saveXhtml() {
		return substr($this->saveXML($this->getElementsByTagName('div')->item(0)), 5, -6);
	}
}
