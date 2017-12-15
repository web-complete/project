VuePageEntityDetail = {
    template: `
<div class="page block">
    <div class="page-detail">
        <div class="page-top" v-show="isLoaded">
            <h1>
                <router-link class="back" :to="'/list/'+entityName"><i class="ion-chevron-left"></i></router-link>
                {{title}}
                <small v-if="entityId">#{{entityId}}</small>
            </h1>
        </div>
                
        <transition name="fade">
            <vue-entity-form>
            
            </vue-entity-form>
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
            return this.$route.params.entity;
        },
        entityId(){
            return this.$route.params.id;
        }
    }
};