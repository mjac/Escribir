<?php

namespace Escribir;

class TagLibrarySearch implements LibrarySearch {
	private $repeatPlacement;
	private $tagMap = array();

	public function __construct($repeatPlacement = FALSE) {
		$this->repeatPlacement = $repeatPlacement;
	}

	public function addLibrary(IArticleProvider $library) {
		$articles = $library->getArticles();

		foreach ($articles as $article) {
			$this->placeArticle($article, $article->getTags(), $this->tagMap);
		}
	}

	protected function placeArticle($article, $articleTags, &$tagList)
	{
		if ($this->repeatPlacement || empty($articleTags)) {
			if (!isset($tagList['/'])) {
				$tagList['/'] = array();
			}
			$tagList['/'][] = $article;
		}

		foreach ($articleTags as $tagName => $subTags) {
			$tagName = strtolower($tagName);

			if (!isset($tagList[$tagName])) {
				$tagList[$tagName] = array();
			}

			$this->placeArticle($article, $subTags, $tagList[$tagName]);
		}
	}

	public function getCategories()
	{
		return $this->tagMap;
	}
	
	public function getArticlesByTag($tagComponents = array())
	{
		if (!is_array($tagComponents)) {
			$tagComponents = array($tagComponents);
		}

		$target =& $this->tagMap;
		foreach ($tagComponents as $tag) {
			if ($tag === '') {
				break;
			}

			$tag = strtolower($tag);
			if (!isset($target[$tag])) {
				return array();
			}

			$target =& $target[$tag];
		}

		return isset($target['/']) ? $target['/'] : array();
	}
}
