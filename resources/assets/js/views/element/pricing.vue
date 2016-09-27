<template>
    <div>
        <table class="ui celled table">
            <thead>
            <tr>
                <th colspan="4">Wycena</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="element in elements">
                <tr class="active">
                    <td colspan="4">
                        <div class="ui ribbon label"><b>{{ element.name }}</b></div>
                        <a href="#" class="ui tiny button" style="float: right;"
                           v-link="{ name: 'element-show', params: { id: element.id }}" target="_blank">pokaż</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Liczba wykonanych elementów:</td>
                    <td colspan="2">
                        <div class="ui input">
                            <input type="text" v-model="element.done_quantity" number>
                        </div>

                        <a href="#" class="ui primary mini labeled icon button" style="float: right;"
                           v-on:click.prevent="moreInfo(element)">
                            <template v-if="!element.more_info"><i class="angle down icon"></i> wyświetl więcej
                                informacji
                            </template>
                            <template v-else><i class="angle up icon"></i> schowaj</template>
                        </a>
                    </td>
                </tr>
                <template v-if="element.more_info">
                    <tr>
                        <td>Pliki:</td>
                        <td colspan="3">
                            <file-dropdown-button v-for="file in element.files" :file.sync="file"
                                                  watch-only="true"></file-dropdown-button>
                        </td>
                    </tr>
                    <tr>
                        <td>Wymiary</td>
                        <td colspan="3">{{ element.thickness }} x {{ element.width }} x {{ element.length }}</td>
                    </tr>
                    <tr>
                        <td>Notatka</td>
                        <td colspan="3">{{ element.note }}</td>
                    </tr>
                    <tr>
                        <td>Materiał</td>
                        <td colspan="3">{{ element.making }}</td>
                    </tr>
                    <tr>
                        <td>Projekt</td>
                        <td colspan="3">{{ element.project ? element.project.name: '-' }}</td>
                    </tr>
                </template>
                <tr class="warning">
                    <td><b>Zadanie</b></td>
                    <td><b>Parametry</b></td>
                    <td><b>Ilość</b></td>
                    <td><b>Cena za jeden</b></td>
                </tr>
                <tr v-for="task in element.tasks">
                    <td>{{ task.name }}</td>
                    <td>
                        <div v-for="(index, field) in task.fields">{{ field.name }}: <b>{{
                            jsonToArr(task.pivot.fields)[index] }}{{ field.unit }}</b></div>
                    </td>
                    <td>{{ task.pivot.quantity }}</td>
                    <td>
                        <div class="ui right labeled input">
                            <input @change="doCalculate" type="text" v-model="task.price" number>
                            <div class="ui label">
                                zł
                            </div>
                        </div>
                    </td>
                </tr>
                <tr v-if="element.pricing">
                    <td colspan="2" style="text-align: right;">Suma</td>
                    <td>{{ element.pricing.quantity }}</td>
                    <td>{{ element.pricing.price }} zł</td>
                </tr>
            </template>
            </tbody>
            <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Suma</th>
                <th>{{ pricingSum }}</th>
            </tr>
            </tfoot>
        </table>
    </div>

    <page-loader :busy.sync="busy"></page-loader>
</template>
<script type="text/ecmascript-6">

    import {ElementsPricing} from './../../vuex/actions/element';
    import {clearAllSelected} from './../../vuex/actions/selected-elements';
    import {getElements} from './../../vuex/getters/selected-elements-getters';
    import FileDropdownButton from './../../components/items/FileDropdownButton.vue';

    export default{

        components: {FileDropdownButton},

        vuex: {
            getters: {getElements},
            actions: {ElementsPricing}
        },

        route: {
            data: function () {
                this.loadElements();
            }
        },

//        watch: {
//            'tasks': {
//                handler: function (val, oldVal) {
//                    this.calculateTasks();
//                },
//                deep: true
//            }
//        },

        ready: function () {

        },


        data: function () {
            return {
                elements: [],

                busy: false,

                pricingSum: 0,
            }
        },


        events: {},


        /*
         * Component methods
         */
        methods: {
            loadElements: function () {
                this.busy = true;
                this.ElementsPricing({elements: this.getElements}).then(elements => {
                    this.busy = false;
                    this.elements = elements;

                    this.doCalculate();
//                    this.calculateTasks();
                }, e => {
                    this.busy = false;
                    console.error(e);
                });
            },

            doCalculate: function () {
                var pricing = 0;

                window._.each(this.elements, function (element, index) {
                    if (element.tasks) {
                        Vue.set(element, 'pricing', {quantity: 0, price: 0});

                        window._.each(element.tasks, function (task, index2) {
                            element.pricing.quantity += parseInt(task.pivot.quantity);
                            element.pricing.price += parseInt(task.price) * parseInt(task.pivot.quantity);
                        });

                        element.pricing.price = element.pricing.price * element.done_quantity;

                        pricing += element.pricing.price;
                    }
                });

                this.pricingSum = pricing;
            },

            jsonToArr: function (json) {
                return JSON.parse(json);
            },

            moreInfo: function (element) {
                if (element.more_info && element.more_info == 1) {
                    Vue.set(element, 'more_info', 0);
                } else {
                    Vue.set(element, 'more_info', 1);
                }
            }

//            calculateTasks: function () {
//                window._.each(this.tasks, function (tazk, index) {
//                    if (tazk.tasks) {
//                        tazk.quantity = 0;
//                        tazk.price = 0;
//
//                        window._.each(tazk.tasks, function (task, index2) {
//                            tazk.quantity += parseInt(task.pivot.quantity);
//                            tazk.price += parseInt(task.price) * parseInt(task.pivot.quantity);
//                        })
//                    }
//                });
//            }
        }
    }
</script>