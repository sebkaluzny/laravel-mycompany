<template>
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
                        <input @change="doCalculate" type="text" v-model="element.done_quantity" number>
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
                <td class="collapsing"><b>Ilość</b></td>
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

                    <a href="#" class="ui button mini" v-if="checkIfThereIsMoreSameTasks(task)" style="margin-left: 10px;" v-on:click.prevent="setSamePriceToAllSameTask(task)">ustaw tą cenę przy tych samych zadaniach</a>
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
            <th colspan="3" style="text-align: right;">Liczba elementów</th>
            <th>{{ elementsSum }}</th>
        </tr>
        <tr>
            <th colspan="3" style="text-align: right;">Suma</th>
            <th>{{ pricingSum }}</th>
        </tr>
        </tfoot>
    </table>
</template>
<script type="text/ecmascript-6">

    import {ElementsPricing} from './../../vuex/actions/element';
    import {clearAllSelected} from './../../vuex/actions/selected-elements';
    import {getElements} from './../../vuex/getters/selected-elements-getters';
    import FileDropdownButton from './../../components/items/FileDropdownButton.vue';

    export default{

        props: {
            elements: {
                default: {},
            }
        },

        components: {FileDropdownButton},

        vuex: {
            getters: {getElements},
            actions: {ElementsPricing}
        },

        ready: function () {
            this.doCalculate();
        },


        data: function () {
            return {
                busy: false,

                pricingSum: 0,
                elementsSum: 0,
            }
        },


        events: {
            'pricing:form:calculate': function () {
                this.doCalculate();
            }
        },


        /*
         * Component methods
         */
        methods: {
            doCalculate: function () {
                var pricing = 0;
                var elements = 0;

                window._.each(this.elements, function (element, index) {
                    if (element.tasks) {
                        Vue.set(element, 'pricing', {quantity: 0, price: 0});
//
                        window._.each(element.tasks, function (task, index2) {
                            element.pricing.quantity += parseInt(task.pivot.quantity);
                            element.pricing.price += parseInt(task.price) * parseInt(task.pivot.quantity);
                        });

                        element.pricing.price = element.pricing.price * element.done_quantity;
                        element.pricing.quantity = element.pricing.quantity * element.done_quantity;

                        pricing += parseInt(element.pricing.price);
                        elements += parseInt(element.done_quantity);
                    }
                });

                this.elementsSum = elements;
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
            },

            checkIfThereIsMoreSameTasks: function (_task) {
                var count = 0;

                window._.each(this.elements, function (element, index) {
                    if (element.tasks) {
                        window._.each(element.tasks, function (task, index2) {
                            if(task.id == _task.id)
                            {
                                var checkFields = 0;

                                window._.each(task.fields, function (field, index3) {
                                    if(JSON.parse(task.pivot.fields)[index3] == JSON.parse(_task.pivot.fields)[index3]
                                            && parseInt(task.price) != parseInt(_task.price))
                                    {
                                        checkFields++;
                                    }
                                });

                                if(checkFields == task.fields.length)
                                {
                                    count++;
                                }
                            }
                        });
                    }
                });

                console.log(count);

                if(count >= 1)
                    return true;
                else
                    return false;
            },

            setSamePriceToAllSameTask: function (_task) {
                window._.each(this.elements, function (element, index) {
                    if (element.tasks) {
                        window._.each(element.tasks, function (task, index2) {
                            if(task.id == _task.id)
                            {
                                var checkFields = 0;

                                window._.each(task.fields, function (field, index3) {
                                    if(JSON.parse(task.pivot.fields)[index3] == JSON.parse(_task.pivot.fields)[index3])
                                    {
                                        checkFields++;
                                    }
                                });

                                if(checkFields == task.fields.length)
                                {
                                    task.price = _task.price;
                                }
                            }
                        });
                    }
                });

                this.doCalculate();
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