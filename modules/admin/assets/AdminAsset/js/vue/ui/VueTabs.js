Vue.component('VueTabs', {
    template: `
        <div>
            <ul class="tabs">
                <li v-for="tab in tabs" @click="selectTab(tab)" :class="{_active: tab.selected}">{{tab.name}}</li>
            </ul>
            <div class="tabs-content">
                <slot></slot>
            </div>
        </div>    
    `,
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