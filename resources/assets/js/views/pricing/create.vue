<template>
    <div>
        <pricing-form :elements.sync="elements"></pricing-form>

        <a href="#" class="ui button" v-on:click.prevent="savePricing">Zapisz wycenę</a>

    </div>

    <page-loader :busy.sync="busy"></page-loader>
</template>
<script type="text/ecmascript-6">

    import {ElementsPricing, ElementsPricingCreate} from './../../vuex/actions/element';
    import {clearAllSelected} from './../../vuex/actions/selected-elements';
    import {getElements} from './../../vuex/getters/selected-elements-getters';
    import FileDropdownButton from './../../components/items/FileDropdownButton.vue';

    import PricingForm from './_form.vue';

    export default{

        components: {FileDropdownButton, PricingForm},

        vuex: {
            getters: {getElements},
            actions: {ElementsPricing, ElementsPricingCreate}
        },

        route: {
            data: function () {
                this.loadElements();
            }
        },

        ready: function () {

        },


        data: function () {
            return {
                elements: [],

                busy: false,
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

                    this.$broadcast('pricing:form:calculate');
                }, e => {
                    this.busy = false;
                    console.error(e);
                });
            },

            savePricing: function () {
                this.ElementsPricingCreate({elements: this.elements}).then(data => {
//                    console.log(data);
                    this.$route.router.go("/pricing/" + data.id);
                });
            }
        }
    }
</script>