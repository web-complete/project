Vue.component('VuePager', {
    template: `
<div class="pager" v-if="show">
    <span class="_text">{{from}}-{{to}} из {{itemsTotal}}</span>
    <a @click="prev" href="javascript://" :class="{_disabled: !hasPrev}"><i class="ion-ios-arrow-back"></i></a>
    <a @click="next" href="javascript://" :class="{_disabled: !hasNext}"><i class="ion-ios-arrow-forward"></i></a>
</div>
    `,
    props: {
        page: {required: true, type: Number, default: 1},
        itemsPerPage: {required: true, type: Number},
        itemsTotal: {required: true, type: Number}
    },
    computed: {
        show(){
            return this.hasPrev || this.hasNext;
        },
        from(){
            if (!this.itemsTotal) return 0;
            return this.itemsPerPage * (this.page - 1) + 1;
        },
        to(){
            let to = this.from + this.itemsPerPage;
            return to > this.itemsTotal ? this.itemsTotal : to;
        },
        hasPrev(){
            return this.from > 1;
        },
        hasNext(){
            return this.to < this.itemsTotal;
        }
    },
    methods: {
        prev(){
            if(this.hasPrev && this.page > 1) {
                this.$emit('page', this.page - 1);
            }
        },
        next(){
            if(this.hasNext) {
                this.$emit('page', this.page + 1);
            }
        }
    }
});
