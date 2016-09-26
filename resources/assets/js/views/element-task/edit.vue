<template>
    <h1 class="ui header">
        Edytuj
    </h1>

    <element-task-form :form.sync="form" :submit-callback="save" :busy.sync="busy"></element-task-form>
    <page-loader :busy.sync="editIsBusy"></page-loader>
</template>
<script type="text/ecmascript-6">

    import {ElementTaskUpdate, setElementTaskEdit} from './../../vuex/actions/element-task';
    import {editForm, editIsBusy, editModel} from './../../vuex/getters/element-task-getters';

    export default{

        vuex: {
            getters: {
                editForm,
                editIsBusy,
                editModel
            },
            actions: {
                ElementTaskUpdate,
                setElementTaskEdit
            },
        },

        ready: function () {

        },


        data: function () {
            return {
                form: null,
                busy: false,
            }
        },

        route: {
            data: function () {
                const id = this.$route.params.id;

                if (this.form == null || this.editForm == null || this.editModel == null || this.editModel.id != id) {
                    this.setElementTaskEdit(id).then(() => {
                        this.form = this.editForm;
                    });
                }
            }
        },

        events: {},


        /*
         * Component methods
         */
        methods: {
            save: function () {
                this.busy = true;

                this.ElementTaskUpdate(this.editModel.id, this.form).then(element_task => {
                    this.busy = false;
                    this.$route.router.go("/element-task");
                }, e => {
                    this.busy = false;
                });
            }
        }
    }
</script>