<?php

namespace Escribir;

class MarkdownArticle extends FileArticle {
	protected function loadMetadata() {
		$file = new \SplFileObject($this->filename);

		$metaParser = new MetadataLineParser(array(
			'title' => NULL,
			'date' => NULL,
			'tag' => NULL,
			'author' => NULL,
			'email' => NULL,
		));

		foreach ($file as $line) {
			if ($line === "\n") {
				break;
			}
			$metaParser->parseLine($line);
		}

		return $metaParser->getMetadata();
	}

	public function getContent() {
		$content = '';

		$record = FALSE;
		$fileObj = new \SplFileObject($this->filename);
		foreach ($fileObj as $line) {
			if ($line === PHP_EOL) {
				$record = TRUE;
			}
			if ($record) {
				$content .= $line;
			}
		}

		return $content;
	}

	public function getXhtmlContent() {
		return \Michelf\Markdown::defaultTransform($this->getContent());
	}
}
