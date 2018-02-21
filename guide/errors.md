# Обработка ошибок

Обработчик ошибок устанавливается в **modules\Applications** в методе **initErrorHandler** и в его родителе.

В web/index.php устанавливается режим разработки:
```php
defined('ENV') or define('ENV', in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'], false) ? 'dev' : 'prod');
```

Исключения **http 403, 404** отправляются в **ErrorController** для отрисовки.

Исключение **http 500** выводится на экран, если установлен режим разработки,
либо отправляется в **ErrorController** для отрисовки.

По умолчанию в качестве **ErrorController** используется **modules\admin\controllers\ErrorController**.
Свой **ErrorController** можно установить в **config/definitions.php**:
```php
    'errorController' => \DI\autowire(modules\pub\controllers\ErrorController::class),
```
Он должен наследоваться от **AbstractErrorController**.

Далее: [CSRF](csrf.md)<br>
Вверх: [Оглавление](index.md)
