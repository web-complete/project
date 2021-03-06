# CMS. Генератор кубов

Для быстрого создания кубов разработан генератор. Это консольная команда,
которую обслуживает класс **modules\admin\commands\GenerateCommand**.

Вызов команды:
```
php console.php admin:generate
```

Команда позволяет генерировать три типа кубов:

### простые (пустые)
```
php ./console.php admin:generate common feedback -t empty -f
```
1й параметр (common) - нэймспэйс куба. Кубы генерируются в директорию: /cubes/нэймспэйс/название_куба

2й параметр (feedback) - название куба

Опция: -t empty - тип куба (пустой)

Опция: -f - force (перезапись, если куб существует)

### сушности типовые
```
php console.php admin:generate catalog product-property -t entity -f
```

Вышеприведенная команда создаст куб с типовой сущностью. После создания куба
необходимо поправить:
- Конфиг сущности
- Аннотации самой сущности (поля @property)
- Миграции

### сущности кастомные
```
php console.php admin:generate catalog product-property -t entity -a -f
```

Добавлена опция "-a", которая создаст дополнительно к типовой сущности ассеты с скопированными страницами
VuePageEntityList и VuePageEntityDetail + зарегистрирует ассет в классе Cube, таким образом подготовит
типовую сущность для кастомизации.

### Внутреннее устройство генератора

Генератор находится в **/modules/admin/classes/generator**

Шаблоны генератора находятся в **/modules/admin/classes/generator/templates**

Далее: [Работа с ассетами](../assets.md)<br>
Вверх: [Оглавление](../index.md)