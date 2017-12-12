Vue.component('VueEntityList', {
    template: `
<div v-if="isLoaded">
    <button class="filter-button">Фильтр: <span>0</span></button>
    <vue-pager :page="page" :items-per-page="itemsPerPage" :items-total="itemsTotal"></vue-pager>

    <div class="table-listing">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th v-for="field in fields"><span :class="{'head-sort': field.sortable}">{{field.label}}</span></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in items">
                    <td v-for="field in fields">
                        <component :is="field.component" :value="item[field.name]"></component>
                    </td>
                    <td><a href="javascript://" class="field-edit"><i class="ion-edit"></i></a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <vue-pager :page="page" :items-per-page="itemsPerPage" :items-total="itemsTotal"></vue-pager>
</div>
    `,
    props: {
        entityName: {required: true}
    },
    data(){
        return {
            isLoaded: false,
            title: '',
            page: 1,
            itemsPerPage: 0,
            itemsTotal: 0,
            fields: [],
            items: []
        }
    },
    mounted(){
        this.fetchData();
    },
    methods: {
        fetchData(){
            Request.get('/admin/api/entity/'+this.entityName, {}, function(response){
                if (response.result) {
                    this.title = response.title;
                    this.page = response.page;
                    this.itemsPerPage = response.itemsPerPage;
                    this.itemsTotal = response.itemsTotal;
                    this.fields = response.fields;
                    this.items = response.items;
                    this.isLoaded = true;
                    this.$emit('title', this.title);
                } else {
                    Notify.errorDefault();
                }
            }.bind(this));
        }
    }
});
