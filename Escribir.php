<?php

namespace Escribir;

spl_autoload_register(function($className) {
	$namespace = __NAMESPACE__ . '\\';

	if (strpos($className, $namespace) !== 0) {
		return;
	}

	require dirname(__FILE__) . DIRECTORY_SEPARATOR
		. substr($className, strlen($namespace)) . '.php';
});
