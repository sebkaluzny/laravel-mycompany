<template>
    <div>
        <table class="ui celled table">
            <thead>
            <tr>
                <th colspan="3">Wycena</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="(name, taskz) in tasks">
                <tr class="active">
                    <td colspan="3"><b>{{ name }}</b></td>
                </tr>
                <tr>
                    <td><b>Parametry</b></td>
                    <td><b>Ilość</b></td>
                    <td><b>Cena za jeden</b></td>
                </tr>
                <tr v-for="task in taskz.tasks">
                    <td>
                        <div v-for="(index, field) in taskz.fields">{{ field.name }}: <b>{{
                            jsonToArr(task.pivot.fields)[index] }}{{ field.unit }}</b></div>
                    </td>
                    <td>{{ task.pivot.quantity }}</td>
                    <td>
                        <div class="ui input"><input type="text" v-model="task.price" @change="calculateTasks" number></div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">Suma</td>
                    <td>{{ taskz.quantity }}</td>
                    <td>{{ taskz.price }}</td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>

    <page-loader :busy.sync="busy"></page-loader>
</template>
<script type="text/ecmascript-6">

    import {ElementsPricing} from './../../vuex/actions/element';
    import {clearAllSelected} from './../../vuex/actions/selected-elements';
    import {getElements} from './../../vuex/getters/selected-elements-getters';

    export default{

        vuex: {
            getters: {getElements},
            actions: {ElementsPricing}
        },

        route: {
            data: function () {
                this.loadTasks();
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
                tasks: [],

                busy: false,
            }
        },


        events: {},


        /*
         * Component methods
         */
        methods: {
            loadTasks: function () {
                this.busy = true;
                this.ElementsPricing({elements: this.getElements}).then(tasks => {
                    this.busy = false;
                    this.tasks = tasks;
                    this.calculateTasks();
                }, e => {
                    this.busy = false;
                    console.error(e);
                });
            },

            jsonToArr: function (json) {
                return JSON.parse(json);
            },

            calculateTasks: function () {
                window._.each(this.tasks, function (tazk, index) {
                    if (tazk.tasks) {
                        tazk.quantity = 0;
                        tazk.price = 0;

                        window._.each(tazk.tasks, function (task, index2) {
                            tazk.quantity += task.pivot.quantity;
                            tazk.price += parseInt(task.price) * task.pivot.quantity;
//                            tazk.price += parseInt(task.price) * task.pivot.quantity;
//                            this.tasks[index].$set('price', parseInt(task.price) * task.pivot.quantity);
                        })
                    }

//                    Vue.set(tazk, 'quantity', 0);
//                    this.tasks.$set(index, 'quantity', 0);


//                    window._.each(tazk.tasks, function (task) {
//                        tazk.quantity += task.pivot.quantity;
//                    })
                });
            }
        }
    }
</script>