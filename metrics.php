<?php
require __DIR__ . '/vendor/autoload.php';

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;
use Moxio\PhpExporter\Collector\APC;
use Moxio\PhpExporter\Collector\Opcache;
use Moxio\PhpExporter\Collector\Realpath;

$adapter = new Prometheus\Storage\InMemory();
$registry = new CollectorRegistry($adapter);

APC::export($registry);
Opcache::export($registry);
Realpath::export($registry);

$renderer = new RenderTextFormat();
$result = $renderer->render($registry->getMetricFamilySamples());
header('Content-type: ' . RenderTextFormat::MIME_TYPE);
echo $result;