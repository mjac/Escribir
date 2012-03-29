<?php

namespace Escribir;

abstract class ArticleParser {
	abstract public function getArticle($id, \SplFileInfo $file);
}
