<?php

namespace Escribir;

class MarkdownArticleParser extends ArticleParser {
	public function isSupportedFile(\SplFileInfo $file) {
		return in_array($file->getExtension(), array('markdown'));
	}

	public function getArticle($id, \SplFileInfo $file) {
		$article = new MarkdownArticle($id, $file->getPathname());
		$article->refreshMetadata();
		return $article->getTitle() === NULL ? NULL : $article;
	}
}
