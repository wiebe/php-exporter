<?php
namespace Moxio\PhpExporter\Collector;
use function Moxio\PhpExporter\Utils\inisize_to_bytes;

class Realpath {
	public static function export($registry) {
		$realpath_memory_used_bytes = realpath_cache_size();
		$realpath_memory_size_bytes = inisize_to_bytes(ini_get('realpath_cache_size'));

		$registry->registerGauge('php_realpath_cache', 'memory_used_bytes', 'Used memory in bytes')
			->set($realpath_memory_used_bytes);
		$registry->registerGauge('php_realpath_cache', 'memory_free_bytes', 'Free memory in bytes')
			->set($realpath_memory_size_bytes - $realpath_memory_used_bytes);
		$registry->registerGauge('php_realpath_cache', 'memory_size_bytes', 'Total memory in bytes')
			->set($realpath_memory_size_bytes);
	}
}