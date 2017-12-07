Vue.component('VueNavigation', {
    store: store,
    // language=Vue
    template: '<nav class="nav block">\n    <ul>\n        <li v-for="(item, k) in nav" v-if="item.items" :class="{_active: item.active}" :key="k">\n            <span @click="toggle(item)">{{item.name}}</span>\n            <ul v-show="item.open">\n                <li v-for="subItem in item.items" @click="mark($event.target)" :class="{_active: subItem.active}">\n                    <router-link :to="subItem.url">{{subItem.name}}</router-link>\n                </li>\n            </ul>\n        </li>\n    </ul>\n</nav>',
    stickyAttached: false,

    data: function(){
        return {
            nav: this.$store.state.navigation.nav
        }
    },

    mounted: function(){
        this.updateStick();
    },

    methods: {
        mark: function(target){
            var $el = $(this.$el);
            $el.find('._active').removeClass('_active');
            $(target).addClass('_active').parents('li').addClass('_active');
        },
        toggle: function(item){
            item.open = !item.open;
            Vue.nextTick(function(){
                this.updateStick();
            }.bind(this));
        },
        updateStick: function(){
            var self = this;
            var $el = $(this.$el);
            var pageHeight = $('.page.block').height();
            if($el.height() < pageHeight) {
                if(self.stickyAttached) {
                    $el.trigger("sticky_kit:recalc");
                }
                else {
                    $el.stick_in_parent({offset_top: 10, inner_scrolling: true, bottoming: true, spacer: '.nav-wrapper'});
                    this.stickyAttached = true;
                }
            }
            else {
                $el.trigger("sticky_kit:detach");
                self.stickyAttached = false;
            }
        }
    }
});