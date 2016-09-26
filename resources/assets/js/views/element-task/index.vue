<template>
    <h1 class="ui header">
        Lista zadań
    </h1>

    <table class="ui celled padded table">
        <thead>
        <tr>
            <th class="single line">Nazwa</th>
            <th>Ilość pól</th>
            <th class="right aligned">Akcja</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="task in indexElementTasks">
            <td>{{ task.name }}</td>
            <td>{{ task.fields.length }}</td>
            <td class="right aligned collapsing"><a href="#" v-link="{ name: 'element-task-edit', params: { id: task.id }}" class="ui button small">edytuj</a></td>
        </tr>
        </tbody>
    </table>
    <page-loader :busy.sync="indexIsBusy"></page-loader>
</template>
<script type="text/ecmascript-6">

    import {ElementTaskIndex} from './../../vuex/actions/element-task';
    import {indexElementTasks, indexIsBusy} from './../../vuex/getters/element-task-getters';

    export default{

        vuex: {
            getters: {
                indexElementTasks,
                indexIsBusy
            },
            actions: {
                ElementTaskIndex
            },
        },

        ready: function () {

        },


        data: function () {
            return {}
        },

        route: {
            data: function () {
                this.ElementTaskIndex().then(() => {
                });
            }
        },

        events: {},


        /*
         * Component methods
         */
        methods: {}
    }
</script>