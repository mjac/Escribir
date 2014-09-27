<?php

namespace Escribir;

class TimeLibrarySearch implements LibrarySearch, IArticleProvider {
	private $priorityQueue;
		
	public function __construct($newestFirst = TRUE) {
		$this->priorityQueue = new TimeLibrarySearchQueue($newestFirst);
	}
	
	public function getArticles() {
		return iterator_to_array($this->priorityQueue);
	}

	public function addLibrary(IArticleProvider $library) {
		$articles = $library->getArticles();
		foreach ($articles as $article) {
			$this->priorityQueue->insert($article, $article->getDate());
		}
	}
}

class TimeLibrarySearchQueue extends \SplPriorityQueue {
	private $newestFirst;
	
	public function compare($d1, $d2) {
		if ($d1 === $d2) {
			return 0;
		}

		$order = $this->newestFirst ? 1 : -1;
		return $d1 < $d2 ? $order : -$order ;
	}
}
