<?php
namespace Moxio\PhpExporter\Utils;
use ByteUnits;

function inisize_to_bytes($size) {
	$rewrite_units = array(
		'K' => 'KiB',
		'M' => 'MiB',
		'G' => 'GiB',
	);
	$rewritten_size = str_ireplace(array_keys($rewrite_units), $rewrite_units, $size);
	return ByteUnits\parse($rewritten_size)->numberOfBytes();
}