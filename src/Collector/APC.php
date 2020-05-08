<?php
namespace Moxio\PhpExporter\Collector;
use function Moxio\PhpExporter\Utils\parse_bytesize;

class APC {
	public static function export($registry) {
		$apc_cache_info = apc_cache_info('user', true);
		$apc_sma_info = apcu_sma_info(true);

		$registry->registerCounter('php_apc_cache', 'requests_hit_total', 'The total amount requests that could be served from cache')
			->incBy($apc_cache_info['num_hits']);
		$registry->registerCounter('php_apc_cache', 'requests_misses_total', 'The total amount of requests that could not be served from cache')
			->incBy($apc_cache_info['num_misses']);
		$registry->registerCounter('php_apc_cache', 'requests_total', 'The total amount of requests')
			->incBy($apc_cache_info['num_hits'] + $apc_cache_info['num_misses']);

		$registry->registerGauge('php_apc_cache', 'entries', 'The amount of entries')
			->set($apc_cache_info['num_entries']);

		$registry->registerGauge('php_apc_cache', 'slots', 'The amount of slots')
			->set($apc_cache_info['num_slots']);

		$registry->registerGauge('php_apc_cache', 'memory_used_bytes', 'Used memory in bytes')
			->set($apc_cache_info['mem_size']);
		$registry->registerGauge('php_apc_cache', 'memory_free_bytes', 'Free memory in bytes')
			->set($apc_sma_info['avail_mem']);
		$registry->registerGauge('php_apc_cache', 'memory_size_bytes', 'Size of memory in bytes')
			->set($apc_sma_info['avail_mem'] + $apc_cache_info['mem_size']);

		$registry->registerCounter('php_apc_cache', 'inserts_total', 'Total number of inserts')
			->incBy($apc_cache_info['num_inserts']);

		$registry->registerCounter('php_apc_cache', 'expunges_total', 'Total number of expunges')
			->incBy(isset($apc_cache_info["num_expunges"]) === true ? $apc_cache_info["num_expunges"] : $apc_cache_info["expunges"]);

		$registry->registerGauge('php_apc_cache', 'segments', 'Number of memory segments')
			->set($apc_sma_info['num_seg']);
	}
}