VuePageStaticBlockList = {
    template: `
<div class="page block">
    <div class="page-list">
        <div class="page-top" v-show="isLoaded">
            <h1>{{title}}</h1>
        </div>
        
        <transition name="fade">
            <vue-entity-list @title="title = $event" :entityName="entityName" :key="entityName"></vue-entity-list>
        </transition>
    </div>
</div>
    `,
    data(){
        return {
            title: ''
        }
    },
    computed: {
        isLoaded(){
            return this.title;
        },
        entityName(){
            return 'static-block';
        }
    }
};