<?php

namespace Escribir\Feeds;

class FeedWriterFeedFactory {
	private static $feedType = array(
		'rss2' => 'RSS2',
		'rss1' => 'RSS1',
		'atom' => 'ATOM',
	);

	public function getFeed($feedInputType) {
		$feedTypes = FeedWriterFeedFactory::$feedType;

		if (!isset($feedTypes[$feedInputType])) {
			throw new \OutOfBoundsException('Unsupported feed input type, supported types are: ' . implode(', ', array_keys($feedTypes)));
		}

		$feedWriterType = '\\FeedWriter\\' . $feedTypes[$feedInputType];
		$feedWriter = new $feedWriterType();

		return new FeedWriterFeed($feedWriter);
	}
}

