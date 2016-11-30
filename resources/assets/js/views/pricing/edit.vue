<template>
    <div>
        <div class="ui yellow message" v-if="pricing.real == 0">
            <div class="header">
                Uwaga
            </div>
            <p>Parametry elementów są z dnia <b>{{ pricing.created_at }}</b>, oznacza to że informacje (wymiary, zadania) mogły się przez ten czas zmienić.<br />
                <a href="#" v-on:click.prevent="getCurrentElementInformations()">Kliknij tutaj aby zaktualizować wszystkie informacje.</a> </p>
        </div>

        <pricing-form :elements.sync="elements"></pricing-form>

        <a href="#" class="ui button" v-on:click.prevent="updatePricing">Zapisz wycenę</a>
        <a href="#" class="ui button" v-on:click.prevent="savePricing">Zapisz jako nowa wycena</a>

    </div>

    <page-loader :busy.sync="busy"></page-loader>
</template>
<script type="text/ecmascript-6">

    import {ElementsPricing, ElementsPricingGet, ElementsPricingCreate, ElementsPricingUpdate} from './../../vuex/actions/element';
    import PricingForm from './_form.vue';
    import FileDropdownButton from './../../components/items/FileDropdownButton.vue';

    export default{

        components: {FileDropdownButton, PricingForm},

        vuex: {
            getters: {},
            actions: {ElementsPricingGet, ElementsPricingCreate, ElementsPricingUpdate},
        },

        ready: function () {

        },

        route: {
            data: function () {
                const id = this.$route.params.id;

                if (this.pricing == null || this.pricing.id != id) {
                    this.loadPricing(id);
                }
            }
        },


        data: function () {
            return {
                elements: [],
                pricing: null,
                busy: false,

                elementsSum: 0,
                pricingSum: 0
            }
        },


        events: {},


        /*
         * Component methods
         */
        methods: {
            loadPricing: function (id, real = 0) {
                this.busy = true;
                this.ElementsPricingGet(id, real).then(pricing => {
                    this.busy = false;
                    this.pricing = pricing;
                    this.elements = JSON.parse(pricing.data);

                    setTimeout(this.doCalculate, 100);
                }, e => {
                    this.busy = false;
                });
            },

            savePricing: function () {
                this.ElementsPricingCreate({elements: this.elements}).then(data => {
                    this.$route.router.go("/pricing/" + data.id);
                });
            },

            updatePricing: function () {
                this.ElementsPricingUpdate(this.pricing.id, {elements: this.elements}).then(data => {
                    this.$route.router.go("/pricing/" + data.id);
                });
            },

            doCalculate: function () {
                this.$broadcast('pricing:form:calculate');
            },

            getCurrentElementInformations: function () {
                const id = this.$route.params.id;

                this.loadPricing(id, 1);
            }
        }
    }
</script>