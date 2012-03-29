<?php

namespace Escribir;

class XhtmlArticle extends FileArticle {
	protected function loadMetadata() {
		$data = file_get_contents($this->filename);
		$dom = new XhtmlDOMDocument;
		$dom->loadXhtml($data);

		$commentNode = $dom->documentElement->firstChild;
		$dom->documentElement->removeChild($commentNode);

		$metaParser = new MetadataLineParser(array(
			'title' => NULL,
			'date' => NULL,
			'tag' => NULL,
			'author' => NULL,
			'email' => NULL,
		));

		foreach (explode("\n", $commentNode->textContent) as $line) {
			$metaParser->parseLine($line);
		}

		return $metaParser->getMetadata();
	}

	public function getContent() {
		$data = file_get_contents($this->filename);
		$dom = new XhtmlDOMDocument;
		$dom->loadXhtml($data);

		$commentNode = $dom->documentElement->firstChild;
		$dom->documentElement->removeChild($commentNode);

		return $dom->saveXhtml();
	}

	public function getXhtmlContent() {
		return $this->getContent();
	}
}
