# CMS. Кастомизация страниц

Для создания полностью кастомной страницы потребуется:
1. создать контроллер
2. создать ассет с необходимыми vue-компонентами
3. зарегистрировать ассет, бэкенд-маршрут, vue-маршрут и добавить элемент в меню.

Пункт 3 происходит в классе Cube, в методе bootstrap.

Зарегистрировать ассет:
```php
    $cubeHelper = $container->get(CubeHelper::class);
    $cubeHelper->appendAsset($container->get(SettingsAsset::class))
```

Добавить бэкенд-маршрут:
```php
        ->addBackendRoute(['GET', '/admin/api/settings', [Controller::class, 'actionGet']])
        ->addBackendRoute(['POST', '/admin/api/settings', [Controller::class, 'actionSave']])
```

Добавить vue-маршрут:
```php
        ->addVueRoute(['path' => '/settings', 'component' => 'VuePageSettings'])
```

добавить элемент в меню:
```php
        ->addMenuSection('Система', 900)
        ->addMenuItem('Система', 'Настройки', '/settings', 100);
```

Для примера кастомной страницы можно посмотреть на куб **system/settings**

Далее: [CMS. Поля](fields.md)<br>
Вверх: [Оглавление](../index.md)
