<?php

namespace Escribir;

class DirectoryLibrary extends Library {
	public function addFromPath($libraryDir) {
		$fileIterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($libraryDir));

		foreach ($fileIterator as $fileInfo) {
			$fileParser = $this->getFileParser($fileInfo);

			if ($fileParser !== NULL) {
				$articleId = $fileParser->getArticleId($libraryDir, $fileInfo);

				$article = $fileParser->getArticle($articleId, $fileInfo);

				if ($article !== NULL) {
					$this[$articleId] = $article;
				}
			}
		}
	}

	public function getFileParser(\SplFileInfo $file) {
		foreach ($this->parsers as $parser) {
			if ($parser->isSupportedFile($file)) {
				return $parser;
			}
		}

		return NULL;
	}

	public function filter($articleFilter) {
		$this->exchangeArray(array_filter((array)$this, $articleFilter));
		
	}
}
