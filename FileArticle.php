<?php

namespace Escribir;

abstract class FileArticle extends Article {
	protected $filename;

	public function __construct($id, $filename) {
		parent::__construct($id);
		$this->filename = $filename;
	}

	public function refreshMetadata() {
		$meta = $this->loadMetadata();

		if ($meta['title'] !== NULL) {
			$this->setTitle($meta['title']);
		}
		if ($meta['date'] !== NULL) {
			$this->setDateFromString($meta['date']);
		}
		if ($meta['tag'] !== NULL) {
			$this->setTagsFromString($meta['tag']);
		}
		if ($meta['author'] !== NULL) {
			$this->setAuthor($meta['author']);
		}
		if ($meta['email'] !== NULL) {
			$this->setEmail($meta['email']);
		}

		$modificationDate = new \DateTime();
		$modificationDate->setTimestamp(filemtime($this->filename));
		$this->setDateModified($modificationDate);
	}

	abstract protected function loadMetadata();
}
