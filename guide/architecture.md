# Архитектура

## Структура приложения

```
config/ - конфигурационные файлы
cubes/ - кубы компонентов
    content/ - пространство контентных кубов
        article/ - куб статей
        ... - прочие кубы пространства
    multilang/ - пространство кубов мультиязычности
    system/ - пространство системных кубов
guide/ - данная документация
modules/ - кубы глобальных модулей
    admin/ - куб Web Complete CMS
    pub/ - куб публичной части
runtime/ - временные файлы - кэш, логи итд.
storage/ - постоянное файловое хранилище
tests/ - юнит-тесты
vendor/ - библиотеки composer
web/ - document root
```

## Жизненный цикл приложения

Приложение имеет единую точку входа и обрабатывается FrontController-ом:

![workflow1](img/workflow1.png)

Детальный цикл приложения:

![workflow2](img/workflow2.png)

1. index.php. Создание приложения
1. Application. Конструктор класса, инициализация конфига
3. Application. Инициализация обработчика ошибок
4. Application. Инициализация глобальных зависимостей (из config/definitions.php)
5. Application. Рекурсивная загрузка кубов из путей, указанных в конфиге (config -> cubesLocations)
6. Application. Инициализация зависимостей кубов
7. Application. Bootstrap кубов
8. Вызов Front Controller-а
9. Определение контроллера маршрута
10. Выполнение контроллера
11. Выполнение действия (beforeAction - action - afterAction)
12. Отправка ответа из controller/action

Далее: [Установка](installation.md)<br>
Вверх: [Оглавление](index.md)
