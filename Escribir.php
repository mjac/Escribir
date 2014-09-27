<?php

namespace Escribir;

spl_autoload_register(function($className) {
	$namespace = __NAMESPACE__ . '\\';

	if (strpos($className, $namespace) !== 0) {
		return;
	}

	$classRelativePath = str_replace('\\', DIRECTORY_SEPARATOR, $className);

	require dirname(__FILE__) . DIRECTORY_SEPARATOR . substr($classRelativePath, strlen($namespace)) . '.php';
});
