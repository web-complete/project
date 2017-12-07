Vue.component('VueTabs', {
    // language=Vue
    template: '<div>\n    <ul class="tabs">\n        <li v-for="tab in tabs" @click="selectTab(tab)" :class="{_active: tab.selected}">{{tab.name}}</li>\n    </ul>\n    <div class="tabs-content">\n        <slot>\n        </slot>\n    </div>\n</div>',
    data: function(){
        return {
            tabs: []
        }
    },
    created: function(){
        this.tabs = this.$children;
    },
    methods: {
        selectTab: function(tabSelected){
            _.each(this.tabs, function(tab){
                tab.selected = (tab.name === tabSelected.name);
            });
        }
    }
});