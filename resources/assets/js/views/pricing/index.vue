<template>
    <div v-for="pricing in indexPricings">
        <a class="ui header" href="#" v-link="{ name: 'pricing-show', params: { id: pricing.id }}">{{ pricing.created_at }}<br /><small>Ostatnia aktualizacja: {{ pricing.updated_at }}</small></a>
        <div class="ui section divider"></div>
    </div>

    <page-loader :busy.sync="indexIsBusy"></page-loader>
</template>
<script type="text/ecmascript-6">

    import {ElementsPricingIndex} from './../../vuex/actions/element';
    import {indexPricings, indexIsBusy} from "./../../vuex/getters/element-pricing-getters"

    export default{

        vuex: {
            getters: {indexPricings, indexIsBusy},
            actions: {ElementsPricingIndex},
        },

        ready: function () {

        },

        route: {
            data: function () {
                this.ElementsPricingIndex();
            }
        },


        data: function () {
            return {}
        },


        events: {},


        /*
         * Component methods
         */
        methods: {}
    }
</script>