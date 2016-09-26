<template>
    <div class="ui modal" id="{{ div }}">
        <i class="close icon"></i>
        <div class="header">
            <span>Zadanie</span>
        </div>

        <div class="content">
            <element-task-element-form :tasks.sync="allTasks" :form.sync="form" :submit-callback="submit"></element-task-element-form>
        </div>

        <div class="actions">
            <div class="ui button">Cancel</div>
            <div class="ui button" v-on:click.prevent="submit">
                Zapisz zmiany
            </div>
        </div>
    </div>
</template>
<script type="text/ecmascript-6">

    import {ElementTaskGetAll} from './../../vuex/actions/element-task';
    import {allTasks} from './../../vuex/getters/element-task-getters';

    import ElementTaskElementForm from './../form/ElementTask.vue';

    export default{

        props: {
            submitCallback: {
                type: Function
            }
        },

        components: {ElementTaskElementForm},

        vuex: {
            getters: {
                allTasks
            },
            actions: {
                ElementTaskGetAll
            },
        },

        ready: function () {
            this.ElementTaskGetAll();
        },


        data: function () {
            return {
                div: 'elementTaskFormModal',

                form: { id: 0, fields: [], quantity: 0 },
            }
        },


        events: {
            'modal:element-task-form:show': function () {
                $('#' + this.div).modal('show');
            },

            'modal:element-task-form:hide': function () {
                this.reset();
                $('#' + this.div).modal('hide');
            }
        },


        /*
         * Component methods
         */
        methods: {
            submit: function () {
                this.submitCallback(this.form);
            },

            reset: function () {
                this.form = { id: 0, fields: [], quantity: 0 };
            }
        }
    }
</script>