# Логгирование

Обработка логов в системе производится библиотекой [Monolog](https://github.com/Seldaek/monolog)

Поверх данной библиотеки работает сервис LoggerService, с которым взимодействует платформа.

Конфигурация логов настраивается в конфиге config/logger.php:
```php
return [
    'app' => [
        new StreamHandler(\dirname(__DIR__) . '/runtime/logs/app.log'),
    ],
    'js' => [
        new StreamHandler(\dirname(__DIR__) . '/runtime/logs/js.log'),
    ],
    '*' => [
        new StreamHandler(\dirname(__DIR__) . '/runtime/logs/exceptions.log', Logger::ERROR),
    ],
];
```

В данном массиве ключами являются категории, а значениями ключей monolog-хэндлеры.

Для логгирования в проекте создан специальный хелпер **cubes\system\logger\Log**, который предоставляет следующие методы:
```php
public static function log(int $level, string $message, $category = 'app');
public static function info(string $message, $category = 'app');
public static function warning(string $message, $category = 'app');
public static function error(string $message, $category = 'app');
public static function exception($exception, $category = 'app');
public static function setContext(array $context);
```

**setContext** - позволяет добавить дополнительные данные, такие как, например, id сессии, id пользователя итд.

Также платформа предлагает логгирование на стороне js. Для этого создан объект Log с аналогичными методами, кроме setContext. Сообщения логгируются через ajax на контроллер куба **cubes/system/logger**

Далее: [Кеширование](caching.md)<br>
Вверх: [Оглавление](index.md)
