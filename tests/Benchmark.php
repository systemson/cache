<?php

require_once 'vendor/autoload.php';

use Amber\Cache\Cache;
use Lavoiesl\PhpBenchmark\Benchmark;

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
    $cache->has($key);

    /* Caches an item */
    $cache->set($key, $value);

    /* Checks if that item exists in the cache */
    $cache->has($key);

    /* Gets the item from cache */
    $cache->get($key);

    /* Checks for an inexistent key adding a default argument */
    $cache->get('unkwonKey', 'default');

    /* Deletes the item from cache */
    $cache->delete($key);

    /* Caches an array of items */
    $cache->setMultiple($multiple, 15);

    /* Gets the array of items */
    $cache->getMultiple(array_keys($multiple));

    /* Tests single actions from a setMultiple */
    $cache->has('string');
    $cache->has('integer');
    $cache->has('float');
    $cache->has('array');
    $cache->has('object');

    $cache->get('string');
    $cache->get('integer');
    $cache->get('float');
    $cache->get('array');
    $cache->get('object');

    $cache->delete('string');
    $cache->delete('integer');
    $cache->delete('float');
    $cache->delete('array');
    $cache->delete('object');

    /* Deletes the array of items from the cache */
    $cache->deleteMultiple(array_keys($multiple));

    /* Clears the cache after testing */
    $cache->clear();
};

$benchmark = new Benchmark();

$benchmark->add('array', function () use ($function) {
    $cache = Cache::driver('array');

    $function($cache);
});

$benchmark->add('file', function () use ($function) {
    $cache = Cache::driver('file');

    $function($cache);
});

$benchmark->add('apcu', function () use ($function) {
    $cache = Cache::driver('apcu');

    $function($cache);
});


$benchmark->add('json', function () use ($function) {
    $cache = Cache::driver('json');

    $function($cache);
});

$benchmark->run();
