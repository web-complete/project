Vue.component('VueTree', {
    template: `
        <div class="tree">
            <div class="tree-root"></div>
            <div class="tree-node" v-if="selectedNode">
                <h2>{{currentNodeName}}</h2>
                <button v-if="!isCreation" @click="emitOpen(0, selectedNode.id)" class="button node-button">Добавить элемент</button>
            </div>
        </div>
    `,
    props: {
        name: {required: true, type: String},
        tree: {required: true, type: Array}
    },
    data(){
        return {
            selectedNode: null,
            isCreation: false,
        }
    },
    computed: {
        computedTree(){
            return this.tree.concat(
                {id: 0, parent: '#', text: 'Корневой элемент', state: {opened: true}, icon: 'ion-folder _disabled'}
            );
        },
        currentNodeName(){
            return this.isCreation ? 'Новый элемент' : this.selectedNode && this.selectedNode.text;
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
                state: {
                    key: this.name,
                    filter: function(state){
                        if(state && state.core) {
                            state.core.selected = [];
                        }
                    }
                },
                types: {default: {icon: "ion-folder"}
                },
                core: {
                    check_callback: function(operation, node, node_parent, node_position, more){
                        switch (operation) {
                            case 'move_node':
                                return node.id !== '#' && node_parent.id !== '#';
                                break;
                        }
                        return true;
                    },
                    data: this.computedTree
                }
            })
                .on('changed.jstree', function (e, data) {
                    if(data.action === 'select_node') {
                        this.selectedNode = data.node;
                        this.emitOpen(data.node.id, data.node.parent);
                    }
            }.bind(this))
                .on('move_node.jstree', function (e, data) {
                    let parent = this.jstree.get_node(data.parent);
                    this.emitMove(data.parent, parent.children);
            }.bind(this))
                .jstree(true);
        },
        refreshTree(){
            $(this.$el).find('.jstree-container-ul').animate({opacity: 0}, 500, function(){
                this.selectedNode = null;
                this.destroyTree();
                this.initTree();
            }.bind(this));
        },
        destroyTree(){
            if (this.jstree) {
                this.jstree.destroy();
            }
        },
        createNode(parentId, id, text){
            this.jstree.create_node(parentId, {id: id, text: text}, 'last', function(){
                this.jstree.open_node(parentId);
            }.bind(this));
        },
        renameNode(id, text){
            this.jstree.rename_node(id, text);
        },
        deleteNode(id){
            this.jstree.delete_node(id);
        },
        closeNode(){
            this.selectedNode = null;
            this.isCreation = false;
            this.jstree.deselect_all();
        },
        emitOpen(id, parentId){
            this.isCreation = (parseInt(id) === 0 && parentId !== '#');
            this.$emit('open', id, parentId);
        },
        emitMove(parentId, childrenIds){
            this.$emit('move', parentId, childrenIds);
        }
    }
});
