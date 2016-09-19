<template>
    <h1 class="ui header">Dodaj PZ</h1>

    <goods-received-form :form.sync="form" :save-callback="submit"></goods-received-form>

</template>
<script type="text/ecmascript-6">

    import {GoodsReceivedCreate, fetchGoodsReceived} from "./../../vuex/actions/goods-received"
    import { companies } from "./../../vuex/getters/company-getters"

    import SelectElementModal from './../../components/modals/SelectElement.vue';
    import GoodsReceivedForm from './_form.vue';

    export default{

        components: { SelectElementModal, GoodsReceivedForm },

        vuex: {
            getters: {
//                goodsReceived: goodsReceived,
                companies: companies,
            },
            actions: {
                GoodsReceivedCreate,
                fetchGoodsReceived
            }
        },

        ready: function () {
            $('select.dropdown')
                    .dropdown()
            ;

            console.log('routeee');
        },


        data: function () {
            return {
                form: {
                    number: '',
                    company_id: 0,
                    received_at: '',

                    elements: [],

                    busy: false,
                }
            }
        },


        events: {
            'modal:select-element:callback': function (element) {
                this.form.elements.push(element);
                this.$broadcast('modal:select-element:hide');
            },

            'modal:select-element:edit:callback': function (index, element) {
                this.form.elements.$set(index, element);
                this.$broadcast('modal:select-element:hide');
            },
        },

        route: {
            data() {
                $('body .modals').remove();
//                $('#selectElementModal').remove();
            }
        },


        /*
         * Component methods
         */
        methods: {
            submit: function () {
                this.form.busy = true;

                this.GoodsReceivedCreate(this.form).then(() => {
                    this.form.busy = false;

                    this.fetchGoodsReceived().then(() => {
                        this.$route.router.go("/goods-received");
                    });
                });
            },

            addElement: function () {
                this.$broadcast('modal:select-element:show');
            },

            editElement: function (index, element) {
                this.$broadcast('modal:select-element:show', index, element);
            }
        }
    }
</script>