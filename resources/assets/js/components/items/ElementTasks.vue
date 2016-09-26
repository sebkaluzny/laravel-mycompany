<template>
    <div v-if="element != null">

        <table v-if="element.tasks.length > 0" class="ui celled table">
            <thead>
            <tr>
                <th>Nazwa</th>
                <th>Ilość</th>
                <th>Dane</th>
                <th class="right aligned">Akcja</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in element.tasks">
                <td>{{ task.name }}</td>
                <td>{{ task.pivot.quantity }}</td>
                <td>
                    <div v-for="(fieldIndex, field) in task.fields" style="margin-bottom: 3px;">
                        {{ field.name }}: <b>{{ parsePivotFields(task.pivot.fields)[fieldIndex] }} {{ field.unit }}</b>
                    </div>
                </td>
                <td class="right aligned collapsing">
                    <a href="#" class="ui mini button" v-on:click.prevent="removeTask(task)">usuń</a>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="ui grey floating labeled icon button" v-on:click.prevent="addTask">
            <i class="add circle icon"></i>
            <span class="text">dodaj zadanie</span>
        </div>
    </div>

    <element-task-form-modal :submit-callback="submitCallback"></element-task-form-modal>
</template>
<script type="text/ecmascript-6">
    import ElementTaskFormModal from './../modals/ElementTaskForm.vue';

    import {ElementAttachTask, ElementDetachTask} from './../../vuex/actions/element';

    export default{

        components: {ElementTaskFormModal},

        vuex: {
            getters: {},
            actions: {
                ElementAttachTask,
                ElementDetachTask
            }
        },

        props: {
            element: {
                default: null,
            },

            refreshCallback: {
                type: Function
            }
        },

        ready: function () {

        },


        data: function () {
            return {}
        },


        events: {},


        /*
         * Component methods
         */
        methods: {
            addTask: function () {
                this.$broadcast('modal:element-task-form:show');
            },

            removeTask: function (task) {
                var data = new FormData;

                data.append('element_id', this.element.id);
                data.append('task_id', task.id);

                this.ElementDetachTask(data).then(() => {
                    this.refreshCallback();
                });
            },

            submitCallback: function (form) {
                form.element_id = this.element.id;

                this.ElementAttachTask(form).then(() => {
                    this.$broadcast('modal:element-task-form:hide');
                    this.refreshCallback();
                });
            },

            parsePivotFields: function (val) {
                return JSON.parse(val);
            }
        }
    }
</script>