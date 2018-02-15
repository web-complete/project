VuePageEcommerceProperty = {
    // language=Vue
    template: `
<div class="page block">
    <div class="page-detail page-ecommerce-property">
        <div class="page-top">
            <h1>Глобальные товарные свойства</h1>
        </div>
        <table class="table properties-table">
        <thead>
        <tr>
            <th width="30"></th>        
            <th>Название</th>        
            <th>Тип</th>        
            <th>Вкл.</th>
            <th width="30"></th>
        </tr>
        </thead>
        <draggable element="tbody" v-model="properties" :options="{handle: '._sort', draggable: '._item'}" class="_list">
            <tr v-for="property in properties" :property="property" is="VueEcommercePropertyItem"></tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a class="_add" href="javascript://"><i class="fa fa-plus"></i></a></td>
            </tr>
        </draggable>
        </table>
    </div>
</div>
    `,
    data(){
        return {
            properties: [
                {name: 'Prop 1', type: 'string', enabled: 1},
                {name: 'Prop 2', type: 'enum', enabled: 1},
                {name: 'Prop 3', type: 'string', enabled: 0},
            ]
        }
    },
    mounted(){
    }
};