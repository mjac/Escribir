<?php

namespace Escribir;

class XhtmlArticleParser extends ArticleParser {
	public function isSupportedFile(\SplFileInfo $file) {
		return in_array($file->getExtension(), array('html'));
	}

	public function getArticle($id, \SplFileInfo $file) {
		$article = new XhtmlArticle($id, $file->getPathname());
		$article->refreshMetadata();
		return $article->getTitle() === NULL ? NULL : $article;
	}
}
