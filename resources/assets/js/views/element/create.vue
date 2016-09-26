<template>
    <h3 class="ui block header">
        Dodaj element
    </h3>

    <element-form :fields.sync="fields" :busy.sync="busy.form" :form.sync="form" :callback="create"></element-form>

    <br />
    <button class="ui button" v-on:click.prevent="create" v-bind:class="{ 'loading disabled': form.busy }">Zapisz</button>
</template>
<script type="text/ecmascript-6">

    import {ElementCreate} from './../../vuex/actions/element';

    export default{

        vuex: {
            getters: {},
            actions: {ElementCreate},
        },

        ready: function () {

        },


        data: function () {
            return {
                form: {
                    name: '',
                    thickness: 0,
                    width: 0,
                    length: 0,
                    note: '',
                    done_quantity: 0,
                    making: '',
                    quantity: 0,
                },

                busy: {
                    form: false,
                },

                fields: ['name', 'size', 'note', 'done_quantity', 'quantity', 'making'],
            }
        },


        events: {},

        route: {
            data: function () {
                this.reset();
            }
        },


        /*
         * Component methods
         */
        methods: {
            create: function () {
                this.busy.form = true;

                this.ElementCreate(this.form).then(element => {
                    this.busy.form = false;
                    this.$route.router.go("/element/" + element.id);
                }, e => {
                    this.busy.form = false;
                });
            },

            reset: function () {
                this.form = {
                    name: '',
                    thickness: 0,
                    width: 0,
                    length: 0,
                    note: '',
                    done_quantity: 0,
                    making: '',
                    quantity: 0,
                }
            }
        }
    }
</script>