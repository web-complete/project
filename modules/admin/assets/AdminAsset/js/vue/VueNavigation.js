Vue.component('VueNavigation', {
    store: store,
    template: `
        <nav class="nav block">
            <ul>
                <li v-for="(item, k) in nav" v-if="item.items" :class="{_active: item.active}" :key="k">
                    <span @click="toggle(item)">{{item.name}}</span>
                    <ul v-show="item.open">
                        <li v-for="subItem in item.items" @click="mark($event.target)" :class="{_active: subItem.active}">
                            <router-link :to="subItem.url">{{subItem.name}}</router-link>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    `,
    data: function(){
        return {
            nav: this.$store.state.navigation.nav,
            stickyAttached: false,
        }
    },
    mounted: function(){
        this.updateStick();
        var $activeEl = $(this.$el).find('.router-link-active').closest('li');
        if ($activeEl.length) {
            this.mark($activeEl[0]);
        }
    },
    methods: {
        mark: function(target){
            var $el = $(this.$el);
            $el.find('._active').removeClass('_active');
            $(target).addClass('_active').parents('li').addClass('_active').find('> ul').show();
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