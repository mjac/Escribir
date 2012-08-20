<?php

namespace Escribir;

abstract class ArticleParser {
	abstract public function getArticle($id, \SplFileInfo $file);

	public function getArticleId($path, \SplFileInfo $file) {
		return substr(
			$file->getPathname(),
			strlen($path) + 1,
			-strlen($file->getExtension()) - 1
		);
	}
}
