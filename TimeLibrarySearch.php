<?php

namespace Escribir;

class TimeLibrarySearch extends \SplPriorityQueue implements LibrarySearch {
	public function __construct($newestFirst = TRUE) {
		$this->newestFirst = $newestFirst;
	}

	public function compare($d1, $d2) {
		if ($d1 === $d2) {
			return 0;
		}

		$order = $this->newestFirst ? 1 : -1;
		return $d1 > $d2 ? $order : -$order ;
	}

	public function addLibrary(\Traversable $library) {
		foreach ($library as $article) {
			$this->insert($article, $article->getDate());
		}
	}
}
