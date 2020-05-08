<?php
namespace Moxio\PhpExporter\Collector;

class Opcache {
	public static function export($registry) {
		$opcache_status = opcache_get_status();
		$opcache_statistics = $opcache_status["opcache_statistics"];
		$memory_usage = $opcache_status["memory_usage"];

		$registry->registerCounter('php_opcache', 'requests_hit_total', 'The total amount requests that could be served from cache')
			->incBy($opcache_statistics['hits']);
		$registry->registerCounter('php_opcache', 'requests_misses_total', 'The total amount of requests that could not be served from cache')
			->incBy($opcache_statistics['misses']);
		$registry->registerCounter('php_opcache', 'requests_total', 'The total amount of requests')
			->incBy($opcache_statistics['hits'] + $opcache_statistics['misses']);

		$registry->registerGauge('php_opcache', 'keys_used', 'Amount of keys that are in use')
			->set($opcache_statistics['num_cached_keys']);
		$registry->registerGauge('php_opcache', 'keys_free', 'Amount of keys that are not in use')
			->set($opcache_statistics['max_cached_keys'] - $opcache_statistics['num_cached_keys']);
		$registry->registerGauge('php_opcache', 'keys_size', 'Total amount of keys that can be used')
			->set($opcache_statistics['max_cached_keys']);

		$registry->registerGauge('php_opcache', 'memory_used_bytes', 'Used memory in bytes')
			->set($memory_usage['used_memory']);
		$registry->registerGauge('php_opcache', 'memory_free_bytes', 'Free memory in bytes')
			->set($memory_usage['free_memory']);
		$registry->registerGauge('php_opcache', 'memory_wasted_bytes', 'Amount of bytes wasted')
			->set($memory_usage['wasted_memory']);
		$registry->registerGauge('php_opcache', 'memory_size_bytes', 'Size of memory in bytes')
			->set($memory_usage['used_memory'] + $memory_usage['free_memory'] + $memory_usage['wasted_memory']);

		$registry->registerCounter('php_opcache', 'oom_restarts_total', 'The total amount of OOM restarts')
			->incBy($opcache_statistics['oom_restarts']);
		$registry->registerCounter('php_opcache', 'hash_restarts_total', 'The total amount of hash restarts')
			->incBy($opcache_statistics['hash_restarts']);
		$registry->registerCounter('php_opcache', 'manual_restarts_total', 'The total amount of manual restarts')
			->incBy($opcache_statistics['manual_restarts']);

		$registry->registerGauge('php_opcache', 'start_time', 'Unix timestamp of when the opcache was started')
			->set($opcache_statistics['start_time']);
		$registry->registerGauge('php_opcache', 'last_restart_time', 'Zero if not restarted yet or a unix timestamp of when the opcache was last restarted')
			->set($opcache_statistics['last_restart_time']);

		$interned_strings = $opcache_status['interned_strings_usage'];
		$registry->registerGauge('php_opcache', 'interned_strings_buffer_number_of_strings', 'Amount of strings stored')
			->set($interned_strings['number_of_strings']);
		$registry->registerGauge('php_opcache', 'interned_strings_buffer_used_bytes', 'Used memory in bytes')
			->set($interned_strings['used_memory']);
		$registry->registerGauge('php_opcache', 'interned_strings_buffer_free_bytes', 'Free memory in bytes')
			->set($interned_strings['free_memory']);
		$registry->registerGauge('php_opcache', 'interned_strings_buffer_size_bytes', 'Size of buffer in bytes')
			->set($interned_strings['buffer_size']);
	}
}