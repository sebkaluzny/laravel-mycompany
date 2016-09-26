<template>
    <h1 class="ui header">
        Dodaj nowe zadanie
    </h1>

    <element-task-form :form.sync="form" :submit-callback="create" :busy.sync="busy"></element-task-form>
</template>
<script type="text/ecmascript-6">

    import {ElementTaskCreate} from './../../vuex/actions/element-task';

    export default{

        vuex: {
            getters: {

            },
            actions: {
                ElementTaskCreate
            },
        },

        ready: function () {

        },


        data: function () {
            return {
                form: {
                    name: '',
                    fields: []
                },

                busy: false,
            }
        },


        events: {},


        /*
         * Component methods
         */
        methods: {
            create: function () {
                this.busy = true;

                var data = new FormData;

                data.append('name', this.form.name);

                data.append('fields', this.form.fields);

                this.ElementTaskCreate(this.form).then(element_task => {
                    this.busy = false;
                    this.$route.router.go("/element-task");
                }, e => {
                    this.busy = false;
                });
            }
        }
    }
</script>