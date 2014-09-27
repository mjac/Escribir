<?php

namespace Escribir;

interface IArticleProvider {
	/**
	 * @return Array of articles
	 */
	public function getArticles();
}