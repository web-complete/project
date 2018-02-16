# Vue masked input

Плагин: [IMask](https://unmanner.github.io/imaskjs/)
Vue-компонент [vue-imask](https://github.com/uNmAnNeR/imaskjs/tree/gh-pages/plugins/vue)

Установка:

```
$ npm install imask
$ npm install vue-imask
```

подключить скрипты:
```php
'node_modules/imask/dist/imask.min.js',
'node_modules/vue-imask/dist/vue-imask.js',
```

Плагин можно использовать двумя способами.

### 1. Как компонент

зарегистрировать в родительском компоненте:
```vue
components: {'masked-input': VueIMask.IMaskComponent}
```

пример использования:
```vue
<masked-input class="_code" v-model="item.code" :mask="/^[a-z0-9-_]+$/"></masked-input>
```
помимо свойства :mask, поддерживаются остальные свойства плагина.
См. описание [Vue-компонента](https://github.com/uNmAnNeR/imaskjs/tree/gh-pages/plugins/vue) и [плагина](https://unmanner.github.io/imaskjs/).

### 2. Как директива

зарегистрировать в родительском компоненте:
```vue
directives: {mask: VueIMask.IMaskDirective}
```

пример использования:
```vue
<input type="text" v-mask="maskOptions" :value="item.value" @accept="accept">
```
