# Установка

**1.** Склонировать платформу
```
$ cd /var/www
$ git clone https://github.com/web-complete/project project_name
```

**2.** Удалить директорию .git
```
$ cd project_name
$ rm -rf .git
```

**3.** Установить **необходимые** права на запись для следующих директорий
```
$ chmod -R 777 runtime
$ chmod -R 777 storage
$ chmod -R 777 web/assets
$ chmod -R 777 web/usr
```

**4.** Получить зависимости пакетов
```
$ composer update
```

**5.** Создать базу данных
```
$ mysql -u root -e "create database project_name" 
```

**6.** Прописать БД в конфиг config/db.php

**7.** Запустить миграции
```
$ php console.php migrate:up 
```

Далее: [Конфигурация](config.md)<br>
Вверх: [Оглавление](index.md)
