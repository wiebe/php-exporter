PHP Exporter
========

Exports metrics about the PHP process to be scraped by Prometheus, it is designed to be run with your webserver instead of a seperate process.
It currently exports metrics about:
 - APC cache
 - Opcache
 - Realpath cache