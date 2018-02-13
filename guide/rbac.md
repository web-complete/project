# Права доступа

Для управления иерархией прав доступа используется библиотека [Web Complete RBAC](https://github.com/web-complete/rbac).

Несмотря на то, что библиотека позволяет хранить настройки персистентно (FileResource),
в платформе используется runtime-конфигурация **config/rbac.php**:
```php
<?php

return [
    'permissions' => [
        'admin' => [
            'description' => 'Полное администрирование',
            'permissions' => [
                'admin:login' => ['description' => 'Вход в CMS'],
                'admin:cubes' => ['description' => 'Управление в CMS'],
            ],
        ],
    ],
    'roles' => [
        'admin' => [
            'description' => 'Администратор',
            'permissions' => ['admin'],
        ],
        'manager' => [
            'description' => 'Контент-менеджер',
            'permissions' => ['admin:login'],
        ]
    ],
];
```

Администраторское управление RBAC не предусмотрено и подразумевается, что разработчик сам настраивает
необходимые роли и права, специфичные для проекта. В интерфейсе CMS у пользователя можно указать одну
или несколько ролей, сконфигурированных разработчиком.

Как роли, так и права поддерживают вложенность.

## Права

Важно понимать, что роли - это сгруппированные наборы прав и в коде проверять необходимо именно права:
```php
if ($user->can('my:permission') {
    ...
}
```

Первоначальная инициализация прав происходит в **Application**. С помощью **RbacLoader** в иерархии
RBAC создаются права верхнего (**admin**) и второго уровня (**admin:login**, **admin:cubes**) - они определены в конфиге.

Далее, каждый куб, может изменить эту структуру, добавив свои собственные права, как правило,
наследующиеся от **admin:cubes**:
```php
$rbac = $this->container->get(Rbac::class);
$permission = $rbac->createPermission('admin:cubes:my:action', 'Permission description');
$rbac->getPermission('admin:cubes')->addChild($permission);
```

См. также вспомогательные методы:
```php
CubeHelper::addPermission()
CubeHelper::addPermissionSimple()
```

Кубы сущностей автоматически (в **CubeHelper::defaultCrud**) добавляют два права: view (просмотр) и edit (редактирование).
Примеры:
- **admin:cubes:article:view**
- **admin:cubes:article:edit**

Также **CubeHelper::defaultCrud** регистрирует элемент бокового меню с учетом права view. В ручную это можно сделать так:
```php
$cubeHelper->addMenuItem('Мой раздел', 'Моя страница', "/myPage", 100, 'admin:crud:my');
```
Таким образом, если у пользователя не будет прав на 'admin:crud:my', то он не увидит этот элемент в боковом меню.

## Роли

После добавления всех прав в Rbac, регистрируются роли (см. module\Application). Роли определены также в конфиге 
**config/rbac.php** и не управляются администратором (но ограничений для реализации управления ролями никаких нет).

Пример конфигурации ролей:
```php
    'roles' => [
        'admin' => [
            'description' => 'Администратор',
            'permissions' => ['admin'],
        ],
        'manager' => [
            'description' => 'Контент-менеджер',
            'permissions' => ['admin:login', 'admin:cubes:article:view', 'admin:cubes:article:edit'],
        ],
        'user' => [
            'description' => 'Пользователь',
            'permissions' => [],
        ]
    ],
```
В данном примере admin может всё, так как имеет права доступа верхнего уровня. Manager может логиниться в CMS и
управлять статьями. User не может ничего.

## Проверка прав на бэкенде
```php
if ($user->can('my:permission') {
    ...
}
```
Либо более продвинутое, с использованием правил (Rules) - см. [Web Complete RBAC](https://github.com/web-complete/rbac)

## Проверка прав на фронтенде

В CMS все права текущего пользователя передаются в Vuex в UserState, с которым работает вспомогательный объект Rbac:
```js
if (Rbac.check('my:permission')) {
    // ... allowed
}
```

В Vue-компоненте можно подключить mixin:
```vue
    mixins: [VueMixinRbac]
```
и использовать метод isAllowed:
```vue
<a v-if="isAllowed(permissions.edit)" @click="deleteItem(item.id)" class="field-edit"><i class="ion-close"></i></a>
```

Необходимо понимать, что проверка прав на фронтенде обязательно должна быть обеспечена проверкой прав на бэкенде.

## Уровни проверки прав доступа

TODO

Далее: [Обработка ошибок](errors.md)<br>
Вверх: [Оглавление](index.md)
