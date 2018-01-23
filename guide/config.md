# Конфигурация

Конфигурационные файлы находятся в корневой директории config.<br>
Application во время инициализации загружает **config/config.php**,
который в свою очередь подгружает вложенные конфигурационные файлы,
разделенные для удобства использования.

## Основные конфигурационные файлы
#### config.php
Главный конфигурационный файл, подгружаемый приложением.
В данном файле указываются пути подгрузки кубов, а также подгружаются
все вспомогательные конфигурационные файлы.

```php
return [
    'aliases' => require 'aliases.php',
    'routes' => require 'routes.php',
    'commands' => require 'commands.php',
    'cubesLocations' => [
        __DIR__ . '/../modules',
        __DIR__ . '/../cubes',
    ],
    'definitions' => require 'definitions.php',
    'settingsLocation' => __DIR__ . '/settings.php',
    'salt' => 'SomeSecretWord',
];
```
#### aliases.php
Алиасы путей (идея взята из Yii/Yii2).
Резолвинг путей происходит с помощью **AliasService::get** (пакет Core)

```php
return [
    '@app' => \dirname(__DIR__, 1),
    '@web' => \dirname(__DIR__, 1) . '/web',
    '@admin' => \dirname(__DIR__, 1) . '/modules/admin',
    '@pub' => \dirname(__DIR__, 1) . '/modules/pub',
    '@storage' => \dirname(__DIR__, 1) . '/storage',
    '@runtime' => \dirname(__DIR__, 1) . '/runtime',
];
```
#### commands.php
Регистрация консольных комманд

```php
return [
    \modules\admin\commands\AdminInitCommand::class,
    \modules\admin\commands\MinifyJsCommand::class,
    \modules\admin\commands\GenerateCommand::class,
    \WebComplete\core\utils\migration\commands\MigrationUpCommand::class,
    \WebComplete\core\utils\migration\commands\MigrationDownCommand::class,
];
```
#### db.php
Конфигурация базы данных
```php
return 'mysql://root@127.0.0.1/project?charset=UTF8';
```
#### definitions.php
Конфигурация зависимостей классов в нотации библиотеки [PHP-DI](http://php-di.org/).

Важно! В данном файле регистрируются только глобальные зависимости.
Зависимости кубов регистрируются в самом кубе.

```php
return [
    'db' => require 'db.php',
    'errorController' => \DI\object(ErrorController::class),
    Request::class => function () {
        $request = Request::createFromGlobals();
        $request->setSession(new Session());
        return $request;
    },
    ...
];
```

Данные зависимости будут внедрены автоматически в необходимые классы с помощью
технологии autowiring (см документацию PHP-DI), либо получены из контейнера приложения
напрямую:
```php
global $application;
$request = $application->getContainer()->get(Request::class);
```
#### routes.php
Конфигурация глобальных маршрутов в следующем формате:
```
[method, route, callable]
``` 
пример:
```php
return new Routes([
    ['GET', '/', [\modules\pub\controllers\IndexController::class, 'actionIndex']],
    ['GET', '/admin/login', [AuthController::class, 'actionLogin']],
    ['GET', '/admin/api/ping', [AjaxController::class, 'actionPing']],
    ['POST', '/admin/api/auth', [AuthController::class, 'actionAuth']],
    ['GET', '/admin', [IndexController::class, 'actionApp']],
]);
```
Важно! Каждый куб, при необходимости, может регистрировать свои собственные маршруты.

#### settings.php
Настройки проекта. Доступны после инициализации приложения (Application).
Управление настройками происходит в CRM, раздел **Система -> Настройки**.
Получить значения настроек можно с помощью **Settings::get**.

Сервис Settings должен быть внедрен, либо получен из контейнера.

Далее: [Кубы](cubes.md)<br>
Вверх: [Оглавление](index.md)
