VuePageStaticBlockList = {
    template: `
<div class="page block">
    <div class="page-list">
        <div class="page-top" v-show="isLoaded">
            <h1>{{title}}</h1>
        </div>
        
        <transition name="fade">
            <vue-static-block-list @title="title = $event" :entityName="entityName" :key="entityName"></vue-static-block-list>
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