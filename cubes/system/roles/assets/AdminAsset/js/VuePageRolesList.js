VuePageRolesList = {
    template: `
<div class="page block">
    <div class="page-list">
        <div class="page-top">
            <h1>Пользовательские роли</h1>
            <router-link class="button" :to="'/roles/0'">Добавить</router-link>
        </div>
        
        <div class="table-listing">
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                    <tr>
                        <th v-for="field in listFields">
                            <span>{{field.label}}</span>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in items" @dblclick="$router.push('/roles/'+item.name)">
                        <td v-for="field in listFields">
                            <component :is="field.component" :value="item[field.name]"></component>
                        </td>
                        <td>
                            <a @click="deleteItem(item.name, $event)" href="javascript://" class="field-edit"><i class="ion-close"></i></a>
                            <router-link class="field-edit" :to="'/roles/'+item.name"><i class="ion-edit"></i></router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
    `,
    data(){
        return {
            listFields: [],
            items: []
        }
    },
    created(){
        this.fetchData()
    },
    watch: {'$route': 'fetchData'},
    methods: {
        deleteItem(id, e){
            Modal.confirm('Вы уверены?', function(){
                Request.delete('/admin/api/roles/' + id, {id: id}, function(){
                    Notify.successDefault();
                    this.fetchData();
                }.bind(this));
            }.bind(this));
        },
        fetchData: function(){
            Request.get('/admin/api/roles', {}, function(response){
                if (response.result) {
                    this.items = response.items;
                    this.listFields = response.listFields;
                } else {
                    Notify.errorDefault();
                }
            }.bind(this));
        }
    }
};