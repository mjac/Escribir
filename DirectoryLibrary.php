<?php

namespace Escribir;

class DirectoryLibrary extends Library implements IArticleProvider {
	public function getArticles() {
		return $this->articles;
	}

	public function addFromPath($libraryDir) {
		$fileIterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($libraryDir));

		foreach ($fileIterator as $fileInfo) {
			$fileParser = $this->getFileParser($fileInfo);

			if ($fileParser !== NULL) {
				$articleId = $fileParser->getArticleId($libraryDir, $fileInfo);

				$article = $fileParser->getArticle($articleId, $fileInfo);

				if ($article !== NULL) {
					$this->articles[$articleId] = $article;
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
		$this->articles = array_filter($this->articles, $articleFilter);
	}
}
