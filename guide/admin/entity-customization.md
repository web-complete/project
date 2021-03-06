# CMS. Кастомизация сущностей

## Кастомизация бэкенд

Если требуется кастомизировать поведение логики на бэкенде, без изменения интерфейсов
взаимодействия с фронтендом, то, как правило, достаточно в контроллере переопределить
необходимые методы из родительского AbstractEntityController, либо внести модификации
на уровне конфигурации куба (Cube.php) или сущности (EntityConfig).

Если же требуется изменение интерфейса api, то скорее всего придется затронуть фронтенд.

## Кастомизация фронтенд

Для кастомизации фронтенда (например что-то добавить в листинг или как-то модифицировать
детальную страницу), необходимо создать свои ассеты куба. Пример (куб staticBlock):

```
staticBlock/
    assets/
        AdminAsset/
            js/
                VuePageStaticBlockList.js
                VuePageStaticBlockDetail.js
        AdminAsset.php
```

В данном примере мы переопределяем и страницу листинга, и детальную страницу
(то есть копируем из VuePageEntityList и VuePageEntityDetail, переименовываем и вносим
нужные изменения).

При необходимости, можно добавлять новые vue-компоненты.

Класс ассета AdminAsset.php (наследуемый от AbstractAsset) регистрирует новые js-файлы.

Далее необходимо добавить маршруты и подключить ассет. Это происходит в классе Cube,
метод bootstrap:

```php
    $cubeHelper->defaultCrud($entityConfig);
    $cubeHelper->appendAsset($container->get(AdminAsset::class));
    $cubeHelper->addVueRoute(['path' => '/list/' . $sysName, 'component' => 'VuePageStaticBlockList']);
    $cubeHelper->addVueRoute(['path' => '/detail/' . $sysName . '/:id', 'component' => 'VuePageStaticBlockDetail']);
```

Помимо стандартного подключения куба defaultCrud(), в данном примере мы:
1. регистрируем ассет (он добавляется прицепом к основному modules\admin\assets\AdminAsset)
2. добавляем vue-маршруты, указывающие на переопределенные компоненты страниц.

При необходимости можно использовать вместо defaultCrud() полностью кастомное подключение.

## Кастомизация полей

Про кастомизацию полей см. раздел [CMS. Поля](fields.md).

Далее: [CMS. Кастомизация страниц](custom-page.md)<br>
Вверх: [Оглавление](../index.md)
