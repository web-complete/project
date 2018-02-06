VuePageLog = {
    template: `
<div class="page block">
    <div class="page-detail">
        <div class="page-top">
            <h1>Последние ошибки</h1>
            <button @click="clearLog" class="button">Очистить лог</button>
        </div>
        
        <div v-if="isLoaded">
            <table class="table">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Категория</th>
                    <th>Сообщение</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="row in rows">
                <td class="nowrap">{{row.date}}</td>
                <td>{{row.category}}</td>
                <td>{{row.message}}</td>
            </tr>
            </tbody>
            </table>
        </div>
    </div>
</div>
`,
    data(){
        return {
            isLoaded: false,
            rows: []
        }
    },
    created(){
        this.fetchData()
    },
    watch: {'$route': 'fetchData'},
    methods: {
        fetchData(){
            Request.get('/admin/api/log/last/25', function(response){
                if (response.result) {
                    this.rows = response.rows;
                    this.isLoaded = true;
                }
            }.bind(this));
        },
        clearLog(){
            Request.delete('/admin/api/log', function(){
                this.fetchData();
            }.bind(this));
        }
    }
};