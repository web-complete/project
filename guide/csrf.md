# CSRF

Для включения CSRF-защиты необходимо:

1.) Поставить обработчик в контроллере:
```php
    public function beforeAction()
    {
        $this->container->get(CSRF::class)->process();
        ...
    }
```
_Стоит по умолчанию в **modules\admin\controllers\AbstractController**._

2.) Поставить обработчик в js (перед запросом скопировать куку **_csrf** в **_csrf_check**), на примере jquery:
```js
$.ajaxSetup({
    beforeSend: function(){
        Cookies.set('_csrf_check', Cookies.get('_csrf'));
    }
});
```

Далее: [Публичная часть](pub.md)<br>
Вверх: [Оглавление](index.md)
