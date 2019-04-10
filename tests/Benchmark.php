<?php

require_once 'vendor/autoload.php';

use Lavoiesl\PhpBenchmark\Benchmark;
use Amber\Cache\Driver\SimpleCache as Amber;
use Amber\Cache\Cache;
use Symfony\Component\Cache\Simple\FilesystemCache  as Symfony;
use Phpfastcache\Helper\Psr16Adapter as Phpfastcache;

/* Sets the vars to test */
$key = 'key';
$value = 'value';

$string = 'string';
$integer = 1;
$float = 1.1;
$array = [1,2,3,4,5];

$object = new \stdClass();
$object->string = 'string';
$object->integer = $integer;
$object->array = $array;

for ($x = 0; $x < 1000; $x++) {
    $multiple[$key . $x] = $value . $x;
}

$multiple['string'] = $string;
$multiple['integer'] = $integer;
$multiple['float'] = $float;
$multiple['array'] = $array;
$multiple['object'] = $object;

$data = [
    'key' => $key,
    'value' => $value,
    'string' => $string,
    'string' => $integer,
    'float' => $float,
    'array' => $array,
    'object' => $object,
    'multiple' => $multiple,
];

$function = function ($cache) use ($data) {
    extract($data);

    /* Clears the cache before testing */
    $cache->clear();

    /* Checks for an unexistent key */
    if (!$cache->has($key)) {
    	$cache->set($key, $value);
    }
    $cache->get($key);
};


$benchmark = new Benchmark();

$handler = new Amber(getcwd() . '/tmp/cache');

$cache = new Cache;
$cache->pushHandler($handler);

$benchmark->add('amber_file', function () use ($cache, $function) {
    $function($cache);
});
$cache->clear();

$cache = new Symfony();
$benchmark->add('symfony_file', function () use ($cache, $function) {
    $function($cache);
});
$cache->clear();

$cache = new Phpfastcache('Files');
$benchmark->add('phpfastcache_file', function () use ($cache, $function) {
    $function($cache);
});
$cache->clear();

$benchmark->guessCount(10);
//$benchmark->setCount(10000);
$benchmark->run();
