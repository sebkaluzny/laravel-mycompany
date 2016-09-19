<template>
    <table class="ui celled striped table">
        <thead>
        <tr><th colspan="3">
            Goods received
        </th>
        </tr>
        <tr>
            <th>Firma</th>
            <th>Nr. dokum.</th>
            <th>Data</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in index.goods_received">
            <td>Jakaś firma 1231</td>
            <td class="collapsing">
                <a href="#" v-link="{ name: 'goods-received-show', params: { id: item.id }}">{{ item.number }}</a>
            </td>
            <td class="right aligned collapsing">{{ item.created_at }}</td>
        </tr>
        </tbody>
    </table>

    <a class="ui button" href="#" v-link="{ path: '/goods-received/create' }">Dodaj nowy</a>
    <page-loader :busy.sync="indexIsBusy"></page-loader>
</template>
<script type="text/ecmascript-6">

    import { goodsReceived, index } from "../vuex/getters/goods-received-getters"
    import { fetchGoodsReceived, GoodsReceivedIndex } from "../vuex/actions/goods-received"
    import { triggerLoadAnimation, triggerLoadAnimationDone } from "../vuex/actions/app"
    import PageLoader from './../components/PageLoader.vue';

    export default{
        components: {PageLoader},

        vuex: {
            getters: {
                goodsReceived: goodsReceived,
                index: index,
            },
            actions: {
                fetchGoodsReceived,
                GoodsReceivedIndex,

                triggerLoadAnimation,
                triggerLoadAnimationDone
            }
        },

        route: {
            data() {
                this.busy = true;
                this.GoodsReceivedIndex().then(() => {
                    this.busy = false;
                });
            },
        },

        ready: function () {
//            this.fetchGoodsReceived().then(() => {
//                console.log('Goods received');
//            });
        },


        data: function () {
            return {
                busy: false,
            }
        },


        events: {},


        /*
         * Component methods
         */
        methods: {}
    }
</script>