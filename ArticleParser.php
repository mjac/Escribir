<?php

namespace Escribir;

abstract class ArticleParser {
	abstract public function getArticle($id, \SplFileInfo $file);

	public function getArticleId($path, \SplFileInfo $file) {
		$articlePath = $file->getPathname();
		$articleId = substr($articlePath, strlen($path) + 1, -strlen($file->getExtension()) - 1);
		return str_replace(DIRECTORY_SEPARATOR, '/', $articleId);
	}
}
