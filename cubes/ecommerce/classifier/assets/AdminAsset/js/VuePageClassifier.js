VuePageClassifier = {
    template: `
<div class="page block">
    <div class="page-detail">
        <div class="page-top">
            <h1>Классификатор</h1>
        </div>
        
        <vue-tree :tree="tree" name="classifier"></vue-tree>
    </div>
</div>
`,
    data(){
        return {
            tree: [
                {id: 1, parent: 0, text: 'Категория 1'},
                {id: 2, parent: 0, text: 'Категория 2'},
                {id: 3, parent: 1, text: 'Категория 1.1'},
                {id: 4, parent: 1, text: 'Категория 1.2'},
                {id: 5, parent: 2, text: 'Категория 2.1'},
                {id: 6, parent: 5, text: 'Категория 2.1.1'},
                {id: 7, parent: 5, text: 'Категория 2.1.2'}
            ]
        }
    },
    created(){
        this.fetchData()
    },
    watch: {'$route': 'fetchData'},
    methods: {
        fetchData(){
            this.tree = [
                {id: 1, parent: 0, text: 'Категория 1'},
                {id: 2, parent: 0, text: 'Категория 2'},
                {id: 3, parent: 1, text: 'Категория 1.1'},
                {id: 4, parent: 1, text: 'Категория 1.2'},
                {id: 5, parent: 2, text: 'Категория 2.1'},
                {id: 6, parent: 5, text: 'Категория 2.1.1'},
                {id: 7, parent: 5, text: 'Категория 2.1.2'}
            ];
        }
    }
};