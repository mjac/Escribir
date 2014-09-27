<?php

namespace Escribir\Feeds;

class FeedWriterFeed {
	public function __construct($feedWriter) {
		$this->feedWriter = $feedWriter;
	}

	public function setTitle($title) {
		$this->feedWriter->setTitle($title);
	}

	public function setLink($linkUrl) {
		$this->feedWriter->setLink($linkUrl);
	}

	public function setDescription($title) {
		$this->feedWriter->setDescription($title);
	}

	public function addArticles($catArticles) {
		array_splice($catArticles, 6);

		foreach ($catArticles as $article) {
			$newItem = $this->feedWriter->createNewItem();

			$newItem->setTitle($article->getTitle());
			$newItem->setLink('http://mjac.co.uk' . \Config::urlArticle($article->getId()));
			$newItem->setDate($article->getDate()->getTimestamp());

			$ac = new \ArticleCache(\Config::$pathArticleCache);
			$newContent = $ac->get($article);

			$newItem->setDescription($newContent);

			$this->feedWriter->addItem($newItem);
		}
	}

	public function generateFeed() {
		echo $this->feedWriter->generateFeed();
	}
}

