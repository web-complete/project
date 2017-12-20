Vue.component('VueEntityList', {
    template: `
<div v-if="isLoaded">
    <vue-filter @applyFilter="applyFilter" :filterFields="filterFields"></vue-filter>
    <vue-pager @page="setPage" :page="page" :items-per-page="itemsPerPage" :items-total="itemsTotal"></vue-pager>

    <div class="table-listing">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th v-for="field in listFields">
                        <span @click="toggleSort(field)"
                              :data-dest="sortDir(field)"
                              :class="{'head-sort': field.sortable}">
                              {{field.label}}
                        </span>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in items" @dblclick="$router.push('/detail/'+entityName+'/'+item.id)">
                    <td v-for="field in listFields">
                        <component :is="field.component" :cellParams="field.cellParams" :value="item[field.name]"></component>
                    </td>
                    <td>
                        <a @click="deleteItem(item.id)" href="javascript://" class="field-edit"><i class="ion-close"></i></a>
                        <router-link class="field-edit" :to="'/detail/'+entityName+'/'+item.id"><i class="ion-edit"></i></router-link>
                    </td>
                </tr>
                </tbody>
            </table>
            <div v-if="itemsTotal == 0" class="not-found">Ничего не найдено</div>
        </div>
    </div>
    
    <vue-pager @page="setPage" :page="page" :items-per-page="itemsPerPage" :items-total="itemsTotal"></vue-pager>
</div>
    `,
    props: {
        entityName: {required: true}
    },
    data(){
        return {
            title: '',
            page: 1,
            itemsPerPage: 0,
            itemsTotal: 0,
            listFields: [],
            filterFields: '',
            items: [],
            requestData: {
                page: 1,
                sortField: null,
                sortDir: null,
                filter: {}
            }
        }
    },
    computed: {
        apiUrl(){
            return '/admin/api/entity/'+this.entityName;
        },
        isLoaded(){
            return this.title;
        }
    },
    mounted(){
        this.fetchData();
    },
    methods: {
        applyFilter(filter){
            this.requestData.filter = filter;
            this.fetchData();
        },
        toggleSort(field){
            if (this.requestData.sortField === field.name) {
                this.requestData.sortDir = (this.requestData.sortDir === 'asc') ? 'desc' : 'asc';
                this.fetchData();
            } else if (field.sortable) {
                this.requestData.sortField = field.name;
                this.requestData.sortDir = field.sortable;
                this.fetchData();
            }
        },
        sortDir(field){
            if (this.requestData.sortField === field.name) {
                return this.requestData.sortDir;
            }
        },
        setPage(page){
            this.requestData.page = page;
            this.fetchData();
        },
        deleteItem(id){
            Modal.confirm('Вы уверены?', function(){
                Request.delete(this.apiUrl + '/' + id, {id: id}, function(){
                    Notify.successDefault();
                    this.fetchData();
                }.bind(this));
            }.bind(this));
        },
        fetchData(){
            Request.get(this.apiUrl, this.requestData, function(response){
                if (response.result) {
                    this.title = response.title;
                    this.page = response.page;
                    this.itemsPerPage = response.itemsPerPage;
                    this.itemsTotal = response.itemsTotal;
                    this.listFields = response.listFields;
                    this.filterFields = this.filterFields || response.filterFields;
                    this.items = response.items;
                    this.$emit('title', this.title);
                } else {
                    Notify.errorDefault();
                }
            }.bind(this));
        }
    }
});
