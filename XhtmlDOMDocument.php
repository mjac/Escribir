<?php

namespace Escribir;

class XhtmlDOMDocument extends \DOMDocument {
	public function loadXhtml($data) {
		$data = str_replace(array('&rsquo;', '&nbsp;'), array('&#8217;', '&#160;'), $data);
		$loadSuccess = $this->loadXML('<div>' . $data . '</div>');

		if (!$loadSuccess) {
			return FALSE;
		}

		$domXPath = new \DOMXPath($this);

		$nonEmpty = $domXPath->query('//iframe | //script');
		foreach ($nonEmpty as $tag) {
			$tag->appendChild($this->createTextNode(''));
		}

		return TRUE;
	}

	public function saveXhtml() {
		return substr($this->saveXML($this->getElementsByTagName('div')->item(0)), 5, -6);
	}
}
