<?php

namespace Escribir;

class TagLibrarySearch extends \ArrayObject implements LibrarySearch {
	private $repeatPlacement;

	public function __construct($repeatPlacement = FALSE) {
		$this->repeatPlacement = $repeatPlacement;
	}

	public function addLibrary(\Traversable $library) {
		foreach ($library as $article) {
			$this->placeArticle($article, $article->getTags(), $this);
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

		if (is_array($articleTags) || $articleTags instanceof \Traversable) {
			foreach ($articleTags as $tagName => $subTags) {
				$tagName = strtolower($tagName);

				if (!isset($tagList[$tagName])) {
					$tagList[$tagName] = array();
				}

				$this->placeArticle($article, $subTags, $tagList[$tagName]);
			}
		}
	}

	public function getArticlesByTag($tagComponents = array())
	{
		if (!is_array($tagComponents)) {
			$tagComponents = array($tagComponents);
		}

		$target =& $this;
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
