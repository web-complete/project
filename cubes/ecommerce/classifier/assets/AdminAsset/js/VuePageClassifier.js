VuePageClassifier = {
    template: `
<div class="page block">
    <div class="page-detail">
        <div class="page-top">
            <h1>Классификатор</h1>
        </div>
        
        <vue-tree :tree="tree" name="classifier"></vue-tree>
        <hr class="clear">
    </div>
</div>
`,
    data(){
        return {
            tree: []
        }
    },
    created(){
        this.fetchData()
    },
    watch: {'$route': 'fetchData'},
    methods: {
        fetchData(){
            this.tree = [
                {id: 100, parent: 0, text: 'Бизнесу'},
                {id: 101, parent: 0, text: 'Частным лицам'},
                {id: 102, parent: 0, text: 'Направления'},
                {id: 201, parent: 102, text: 'Перевозки по России'},
                {id: 202, parent: 102, text: 'Перевозки Россия - Казахстан'},
                {id: 203, parent: 102, text: 'Перевозки Китай - Россия'},
                {id: 204, parent: 102, text: 'Перевозки по Казахстану'},
                {id: 103, parent: 0, text: 'Услуги'},
                {id: 104, parent: 0, text: 'Сервисы'},
                {id: 105, parent: 0, text: 'Условия перевозок'},
                {id: 106, parent: 0, text: 'Контакты'},
                {id: 107, parent: 0, text: 'Новости'},
            ];
        }
    }
};