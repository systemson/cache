[![Build Status](https://travis-ci.org/systemson/cache.svg?branch=master)](https://travis-ci.org/systemson/cache)
[![StyleCI](https://styleci.io/repos/126605518/shield?branch=master)](https://styleci.io/repos/126605518)

# Amber/Cache
Simple cache system implementing PSR-16: interface for caching libraries

## Getting started

### Installation

With Composer
```
$ composer require amber/cache
```

## API Usage
### Getting started
```php
use Amber\Cache\Cache;

$cache = Cache::getInstance();
```

### Drivers
Alternatively you can set the driver before geting the instance of the cache.
```php
use Amber\Cache\Cache;

$cache = Cache::driver('file');
```
You can choose from these drivers:
```php
$drivers = [
    'file'  => 'Amber\Cache\Driver\SimpleCache',
    'json'  => 'Amber\Cache\Driver\JsonCache',
    'array' => 'Amber\Cache\Driver\ArrayCache',
    'apcu'  => 'Amber\Cache\Driver\ApcuCache',
];
```

Or you could set the driver class:
```php
$cache = Cache::driver(Amber\Cache\Driver\SimpleCache::class);
```

Finally you could instantiate the driver by yourself:
```php
$cache = new \Amber\Cache\Driver\SimpleCache();
```

### get()
Fetches a value from the cache.
```php
$cache->get($key, $default = null);
```

### set()
Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
```php
$cache->set($key, $value, $ttl = null);
```

### delete()
Delete an item from the cache by its unique key.
```php
$cache->delete($key);
```

### clear()
Wipes clean the entire cache's keys.
```php
$cache->clear();
```

### has()
Determines whether an item is present in the cache.
```php
$cache->has($key);
```

## Multiple actions

### getMultiple()
Obtains multiple cache items by their unique keys.
```php
$cache->getMultiple($keys, $default = null);
```

### setMultiple()
Persists a set of key => value pairs in the cache, with an optional TTL.
```php
$cache->setMultiple($values, $ttl = null);
```

### deleteMultiple()
Deletes multiple cache items in a single operation.
```php
$cache->deleteMultiple($keys);
```

### Static Usage
You can use all the method from the Cache class statically, like this:
```php
use Amber\Cache\Cache;

Cache::set('key', 'value');

Cache::has('key'); // Returns true

Cache::get('key'); // Returns "value"

Cache::delete('key');

// Set the driver and then call the desired method.
Cache::driver('json')->set('key', 'value');

```
