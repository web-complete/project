# Авторизация через соц. сети

Виджет: [uLogin](https://ulogin.ru/constructor.php)

Redirect uri: **/api/social-auth**

Куб: **cubes/social/uLogin**

API Контроллер: **cubes\social\uLogin\api\Controller**

Пример кода для вставки на страницу логина:
```html
<?php $fields = 'first_name,last_name,bdate,sex,phone,photo,photo_big,city,country'; ?>
<?php $optional = 'bdate,sex,phone,photo,photo_big,city,country'; ?>
<?php $providers = 'facebook,twitter,vkontakte'; ?>
<?php $callback = 'http://' . $_SERVER['HTTP_HOST'] . '/api/social-auth'; ?>
<script src="//ulogin.ru/js/ulogin.js"></script>
<div id="uLogin" data-ulogin="display=panel;theme=flat;fields=<?=$fields ?>;optional=<?=$optional ?>;providers=<?=$providers ?>;hidden=other;redirect_uri=<?=$callback ?>;mobilebuttons=0;"></div>
```

- **$fields** - поля, требуемые от соц. сети. Если соц. сеть не возвращает одно из этих полей - оно будет запрошено
с помощью uLogin. [Список возможных полей](https://ulogin.ru/help.php#fields)

- **optional** - не обязательные поля (из указаных в fields). Если соц. сеть не возвращает одно из этих полей,
то оно будет проигнорировано

## Регистрация пользователя

За регистрацию пользователя отвечает **ULoginService**. При необходимости, его можно подкорректировать, чтобы
заполнять пользователя необходимыми полями.

## Использование произвольных иконок

[Использование произвольных иконок](https://ulogin.ru/help.php#buttons)
