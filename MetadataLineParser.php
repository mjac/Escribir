<?php

namespace Escribir;

class MetadataLineParser {
	protected $metadata;

	public function __construct(array $metadata) {
		$this->metadata = $metadata;
	}

	public function parseLine($line) {
		$keyValue = explode(':', $line, 2);
		$key = strtolower(trim($keyValue[0]));
		if (array_key_exists($key, $this->metadata)) {
			$this->metadata[$key] = trim($keyValue[1]);
		}
	}

	public function getMetadata() {
		return $this->metadata;
	}
}
