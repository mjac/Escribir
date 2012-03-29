<?php

namespace Escribir;

class DirectoryLibrary extends Library {
	public function addFromPath($path) {
		$fileIter = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
		foreach ($fileIter as $file) {
			$parser = $this->getFileParser($file);
			if ($parser instanceof ArticleParser) {
				$id = $this->getArticleId($path, $file);
				$article = $parser->getArticle($id, $file);
				if ($article !== NULL) {
					$this[$id] = $article;
				}
			}
		}
	}

	protected function getArticleId($path, \SplFileInfo $file) {
		return substr($file->getPathname(),
			strlen($path) + 1,
			-strlen($file->getExtension()) - 1);
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
