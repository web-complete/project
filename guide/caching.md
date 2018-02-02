# Кеширование

На низком уровне работу с кешем в системе обеспечивает сервис **CacheService** (пакет **Core**).

Он принимает в качестве аргументов два PSR-6 адаптера - системный кеш и пользовательский кеш.
Рекомендуется использовать адаптеры от Symfony для поддержки тегов.

**Системный кеш** обеспечивает производительность ядра - кеширование путей кубов, кеширование зависимостей контейнера.
На боевом сервере рекомендуется использовать **FilesystemAdapter** или **ApcuAdapter**. В разработке - **NullAdapter**,
чтобы не приходилось сбрасывать кеш после каждого изменения зависимости или добавления кеша.

**!!! На боевом сервере, после обновления необходимо вызвать сброс кеша командой: php console.php cache:clear**

**Пользовательский кеш** обеспечивает производительность приложения и используется разработчиком.
На боевом сервере рекомендуется использовать **FilesystemAdapter**, **ApcuAdapter**, **MemcachedAdapter** или **RedisAdapter**.
В разработке - **NullAdapter**

**CacheService** конфигурируется в **config/definitions.php**

Пример 1 (кеш-заглушка):
```php
    CacheService::class => function () {
        $systemCache = new \Symfony\Component\Cache\Adapter\NullAdapter();
        $userCache = new \Symfony\Component\Cache\Adapter\NullAdapter();
        return new CacheService($systemCache, $userCache);
    },
```

Пример 2 (file + file):
```php
    CacheService::class => function (\DI\Container $di) {
        $aliasService = $di->get(\WebComplete\core\utils\alias\AliasService::class);
        $dir = $aliasService->get('@runtime/cache');
        $systemCache = new \Symfony\Component\Cache\Adapter\FilesystemAdapter('system', 0, $dir);
        $userCache = new \Symfony\Component\Cache\Adapter\FilesystemAdapter('user', 0, $dir);
        return new CacheService($systemCache, $userCache);
    },
```
Пример 3 (apc + redis):
```php
    CacheService::class => function (\DI\Container $di) {
        $redis = $di->get(Redis::class);
        $systemCache = new \Symfony\Component\Cache\Adapter\ApcuAdapter();
        $userCache = new \Symfony\Component\Cache\Adapter\RedisAdapter($redis);
        return new CacheService($systemCache, $userCache);
    },
```

_Следует обратить внимание, что большинство адаптеров поддерживают указание namespace, чтобы кеш не пересекался между
проектами._

## Хелпер

Для удобства работы с пользовательским кешем, **Core** предоставляет статический хелпер **Cache** со следующими методами:
```php
public static function get(string $key);
public static function set(string $key, $value, int $ttl = null, array $tags = []);
public static function getOrSet(string $key, \Closure $closure, int $ttl = null, array $tags = []);
public static function html(string $key, int $ttl = null, array $tags = []);
public static function invalidate(string $key);
public static function invalidateTags(array $tags);
public static function clear();
```

Примеры использования:

```php
$result = Cache::get('key1');
if ($result === null) {
    $result = 'value1';
    Cache::set('key1', $result, 3600);
}
return $result;
```

```php
$result = Cache::get('key1');
if ($result === null) {
    $result = 'value1';
    Cache::set('key1', $result, 0, ['tag1']);
}
return $result;
...
Cache::invalidateTags(['tag1']);
```

```php
$result = Cache::getOrSet('key1', function () {
    return 'value1';
}, 3600, ['tag1']);
```

```php
<?php if ($cache = Cache::html('html1', 3600, ['tag1'])) { ?>
    <div>
        Some page content to be cached here.
    </div>
<?php $cache->end(); } ?>
```

## Runtime cache хелпер

Также Core предоставляет хелпер **CacheRuntime**, который обеспечивает хранение данных в памяти в пределах текущего
запроса и предоставляет следующие, схожие с хелпером **Cache**, методы:
```php
public static function get(string $key);
public static function set(string $key, $value);
public static function getOrSet(string $key, \Closure $closure);
public static function invalidate(string $key);
public static function clear();
```

Далее: [Права доступа](auth.md)<br>
Вверх: [Оглавление](index.md)
