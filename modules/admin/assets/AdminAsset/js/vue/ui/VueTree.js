Vue.component('VueTree', {
    template: `
        <div class="tree">
            <div class="tree-root"></div>
            <div class="tree-node" v-if="selectedNode">
                    <h2>{{selectedNode.text}}</h2>
                    <button @click="addNode" class="button node-button">Добавить элемент</button>
                    <button @click="deleteNode" class="button gray node-button">Удалить</button>
                <hr class="clear">
            </div>
        </div>
    `,
    props: {
        name: {required: true, type: String},
        tree: {required: true, type: Array}
    },
    data(){
        return {
            selectedNode: null
        }
    },
    computed: {
        computedTree(){
            return this.tree.concat(
                {id: 0, parent: '#', text: 'Корневой элемент', state: {opened: true}, icon: 'ion-folder _disabled'}
            );
        }
    },
    watch: {'tree': 'refreshTree'},
    mounted(){
        this.initTree();
    },
    destroyed(){
        this.destroyTree();
    },
    methods: {
        initTree(){
            this.jstree = $(this.$el).find('.tree-root').jstree({
                plugins: ["dnd", "types", "state"],
                state: {key: this.name},
                types: {default: {icon: "ion-folder"}
                },
                core: {
                    check_callback: function(operation, node, node_parent, node_position, more){
                        return !(operation === 'move_node' && (node.id === '#' || node_parent.id === '#'));
                    },
                    data: this.computedTree
                }
            }).on('changed.jstree', function (e, data) {
                if(data.action === 'select_node') {
                    this.selectedNode = data.node;
                }
            }.bind(this)).jstree(true);
        },
        refreshTree(){
            $(this.$el).find('.jstree-container-ul').animate({opacity: 0}, 500, function(){
                this.selectedNode = null;
                this.destroyTree();
                this.initTree();
            }.bind(this));
        },
        destroyTree(){
            this.jstree.destroy();
        },
        addNode(){
            let node = { id: 111, text: 'Новый элемент'};
            this.jstree.create_node(this.selectedNode.id, node);
            this.jstree.open_node(this.selectedNode.id);
        },
        deleteNode(){
            Modal.confirm('Удалить?', function(){
                this.jstree.delete_node(this.selectedNode.id);
                this.selectedNode = null;
            }.bind(this));
        }
    }
});
