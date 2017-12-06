Vue.component('VueNavigation', {
    store: store,
    // language=Vue
    template: '<nav class="nav block">\n    <ul>\n        <li v-for="(item, k) in nav" v-if="item.items" :class="{_active: item.active}" :key="k">\n            <span @click="item.open = !item.open">{{item.name}}</span>\n            <ul v-show="item.open">\n                <li v-for="subItem in item.items" @click="mark($event.target)" :class="{_active: subItem.active}">\n                    <router-link :to="subItem.url">{{subItem.name}}</router-link>\n                </li>\n            </ul>\n        </li>\n    </ul>\n</nav>',

    data: function(){
        return {
            nav: this.$store.state.navigation.nav
        }
    },

    methods: {
        mark: function(target){
            var $el = $(this.$el);
            $el.find('._active').removeClass('_active');
            $(target).addClass('_active').parents('li').addClass('_active');
        }
    }
});