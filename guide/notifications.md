# Работа с уведомлениями

За отправку уведомлений по почте отвечает куб **cubes/notification/mail**,
который работает на базе [Symfony Swiftmailer](https://swiftmailer.symfony.com/)

За шаблоны уведомлений отвечает куб **cubes/notification/template**

## Настройка

Для того, чтобы отправка почты заработала, необходимо сконфигурировать
транспортный класс **Swift_Transport::class** в конфиге **config/definitions.php**.

Конфигурация без отправки почты:
```php
    Swift_Transport::class => function () {
        return new \Swift_Transport_NullTransport(new Swift_Events_SimpleEventDispatcher());
    },
```

Конфигурация для отправки через Google Mail:
```php
    Swift_Transport::class => function () {
        return new \(new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
            ->setUsername('username')
            ->setPassword('***');
    },
```

Конфигурация для отправки через Yandex Mail:
```php
    Swift_Transport::class => function () {
        return new \(new Swift_SmtpTransport('smtp.yandex.ru', 465, 'ssl'))
            ->setUsername('username')
            ->setPassword('***');
    },
```

Конфигурация для отправки через sendmail:
```php
    Swift_Transport::class => function () {
        return new \Swift_SendmailTransport('/usr/sbin/sendmail -bs');
    },
```

## Отправка

Пример отправки почты:
```php
/** @var MailService $mailService */
$mailService->send(
    'FromName',
    'from@example.com',
    'to@example.com',
    'Subject',
    'html body',
    'text body', // не обязательный. Будет сгенерирован из html body
    'bcc1@example.com, bcc2@example.com', // не обязательный
    ['/tmp/attachment.rar'] // не обязательный
);
```
Метод вернет количество отправленных писем или 0, если что-то пошло не так.

## Шаблоны

Шаблоны редактируются через раздел CMS: **Оповещения / Шаблоны**.

В шаблоне необходимо заполнить поля: **код, тема, шаблон html**.
Поле **шаблон text** к заполнению необязателен и может быть автоматически сгенерирован из **шаблон html**.

В полях **тема, шаблон html, шаблон text** можно использовать синтаксис [Twig](https://twig.symfony.com/)

Пример отправки шаблона:
```php
$template = $templateService->findByCode('simple');
$mailService->sendTemplate('to@example.com', $template);
```
или
```php
$template = $templateService->findByCode('new_order');
$mailService->sendTemplate(
    'to@example.com',
    $template,
    ['order' => $order->mapToArray()], // переменные для шаблона
    'NameFrom', // не обязательный, будет взят из Settings: from_name
    'from@example.com', // не обязательный, будет взят из Settings: from_email
    'bcc1@example.com, bcc2@example.com', // не обязательный
    ['/tmp/invoice.pdf'] // не обязательный
);
```

Далее: [Работа с SEO](seo.md)<br>
Вверх: [Оглавление](index.md)