Vue.component('VueNavigation', {
    store: store,

    // language=Vue
    template: '<nav class="nav block">\n    <ul>\n        <template v-for="item in nav">\n            <li v-if="item.items" :class="{_active: item.active}">\n                <span>{{item.name}}</span>\n                <ul>\n                    <li v-for="subItem in item.items" :class="{_active: subItem.active}">\n                        <a :href="subItem.url">{{subItem.name}}</a>\n                    </li>\n                </ul>\n            </li>\n        </template>\n    </ul>\n</nav>',

    computed: {
        nav: function(){
            return this.$store.state.navigation.nav;
        }
    }
});