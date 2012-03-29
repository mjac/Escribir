<?php

namespace Escribir;

abstract class Article {
	protected $id;
	protected $title;
	protected $date;
	protected $dateModified;
	protected $tags = array();
	protected $author;
	protected $email;

	public function __construct($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function getDate() {
		return $this->date === NULL ? $this->dateModified : $this->date;
	}

	public function getDateModified() {
		return $this->dateModified;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setDateModified(\DateTime $dateModified) {
		$this->dateModified = $dateModified;
	}

	public function setDateFromString($dateString) {
		$this->date = new \DateTime($dateString);
	}

	public function setTagsFromString($tagString) {
		$this->tags = array();
		$tagList = explode(',', $tagString);
		foreach ($tagList as $tagName) {
			$this->addTag(trim($tagName));
		}
	}

	/**
	 * Tags are composed one or more categories, each separated
	 * by a / symbol.
	 */
	public function addTag($tagName)
	{
		$target =& $this->tags;
		$tagComponents = explode('/', $tagName);
		foreach ($tagComponents as $tag) {
			if (!isset($target[$tag])) {
				$target[$tag] = array();
			}
			// Extraneous in last iteration.
			$target =& $target[$tag];
		}
	}

	/**
	 * Is the article tagged this way?
	 *
	 * Symmetrical to addTag due to array traversal
	 */
	public function hasTag($tagName)
	{
		$target =& $this->tags;
		$tagComponents = explode('/', strtolower($tagName));

		foreach ($tagComponents as $tag) {
			$found = false;
			foreach ($target as $tagName => $tagInner) {
				if (strtolower($tagName) === $tag) {
					$found = $tagInner;
					break;
				}
			}

			if ($found === false) {
				return false;
			}
			// Extraneous in last iteration.
			$target =& $found;
		}

		return true;
	}

	public function getTags() {
		return $this->tags;
	}

	public function flatTagList()
	{
		$strList = array();
		self::tagRecurse($this->tags, $strList, '');
		return $strList;
	}

	static private function tagRecurse(&$tagList, &$strList, $prefix)
	{
		foreach ($tagList as $name => $subTags) {
			$newTag = empty($prefix) ? $name : $prefix . '/' . $name;
			if (empty($subTags)) {
				$strList[] = $newTag;
			} else {
				self::tagRecurse($subTags, $strList, $newTag);
			}
		}
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function setAuthor($author) {
		$this->author = $author;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	abstract protected function getContent();
	abstract protected function getXhtmlContent();
}
