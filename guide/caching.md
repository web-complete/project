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

## Хелпер

Для удобства работы с пользовательским кешем, **Core** предоставляет статический хелпер **Cache** со следующими методами:
```php
public static function get(string $key);
public static function set(string $key, $value, int $ttl = null, array $tags = []);
public static function getOrSet(string $key, \Closure $closure, int $ttl = null, array $tags = []);
public static function html(string $key, int $ttl = null, array $tags = []);
public static function invalidate(string $key);
public static function invalidateTags(array $tags);
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

Далее: [Права доступа](auth.md)<br>
Вверх: [Оглавление](index.md)
