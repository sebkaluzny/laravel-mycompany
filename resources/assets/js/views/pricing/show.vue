<template>
    <b>
        Liczba elementów: {{ elements.length }}
        <br/>
        Suma: {{ pricingSum }} zł
    </b>

    <a href="#" class="ui button" v-link="{ name: 'pricing-edit', params: { id: pricing.id }}">edytuj</a>

    <page-loader :busy.sync="busy"></page-loader>
</template>
<script type="text/ecmascript-6">

    import {ElementsPricing, ElementsPricingGet} from './../../vuex/actions/element';

    export default{
        vuex: {
            getters: {},
            actions: {ElementsPricingGet},
        },

        ready: function () {

        },


        data: function () {
            return {
                elements: null,
                pricing: null,
                busy: false,

                elementsSum: 0,
                pricingSum: 0
            }
        },

        route: {
            data: function () {
                const id = this.$route.params.id;

                if (this.pricing == null || this.pricing.id != id) {
                    this.loadPricing(id);
                }
            }
        },


        events: {},


        /*
         * Component methods
         */
        methods: {
            loadPricing: function (id) {
                this.busy = true;
                this.ElementsPricingGet(id).then(pricing => {
                    this.busy = false;
                    this.pricing = pricing;
                    this.elements = JSON.parse(pricing.data);
                    this.doCalculate();
                }, e => {
                    this.busy = false;
                });
            },

            doCalculate: function () {
                var pricing = 0;
                var elements = 0;

                window._.each(this.elements, function (element, index) {
                    if (element.tasks) {
                        Vue.set(element, 'pricing', {quantity: 0, price: 0});

                        window._.each(element.tasks, function (task, index2) {
                            element.pricing.quantity += parseInt(task.pivot.quantity);
                            element.pricing.price += parseInt(task.price) * parseInt(task.pivot.quantity);
                        });

                        element.pricing.price = element.pricing.price * element.done_quantity;
                        element.pricing.quantity = element.pricing.quantity * element.done_quantity;

                        pricing += parseInt(element.pricing.price);
                        elements += parseInt(element.done_quantity);
                    }
                });

                this.elementsSum = elements;
                this.pricingSum = pricing;
            }
        }
    }
</script>