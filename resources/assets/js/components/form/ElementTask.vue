<template>
    <form v-on:submit.prevent="submit">
        <div class="ui form">
            <div class="field">
                <label>Zadanie</label>
                <select class="ui fluid dropdown" v-model="activeTask">
                    <option v-for="task in tasks" v-bind:value="task.id">{{ task.name }}</option>
                </select>
            </div>
            <div v-if="taskModel != null" class="three wide field" v-for="(index, field) in taskModel.fields">
                <label>{{ field.name }}</label>
                <div class="ui right labeled fluid input">
                    <input type="text" placeholder="Wpisz wartość.." v-model="form.fields[index]">
                    <div class="ui label">
                        {{ field.unit }}
                    </div>
                </div>
            </div>
            <div class="three wide field">
                <label>Ilość</label>
                <input type="number" v-model="form.quantity" number>
            </div>
        </div>
        <button type="submit" style="display: none;"></button>
    </form>
</template>
<script type="text/ecmascript-6">
    export default {

        props: {
            tasks: {
                default: [],
            },

            form: {
                default: () => { return { id: 0, fields: [], quantity: 0 } }
            },

            submitCallback: {
                type: Function
            }
        },

        watch: {
            tasks: function () {
                this.updateActiveTask();

                $('select.dropdown')
                        .dropdown()
                ;
            },

            activeTask: function () {
                this.updateActiveTask();
            }

        },

        ready: function () {

        },


        data: function () {
            return {
                activeTask: 0,

                taskModel: null,

//                form: { id: 0, fields: [], quantity: 0 },
            }
        },


        events: {
            'element-task:form:refresh': function () {
                this.updateActiveTask();
            }
        },


        /*
         * Component methods
         */
        methods: {
            updateActiveTask: function () {
                console.log('updating task');
                this.form.id = this.activeTask;
                this.taskModel = window._.find(this.tasks, {id: this.activeTask});
            },

            submit: function () {
                this.updateActiveTask();
                this.submitCallback();
            }
        }
    }
</script>