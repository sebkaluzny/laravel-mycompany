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
</template>
<script type="text/ecmascript-6">

    import { goodsReceived, index } from "../vuex/getters/goods-received-getters"
    import { fetchGoodsReceived, GoodsReceivedIndex } from "../vuex/actions/goods-received"
    import { triggerLoadAnimation, triggerLoadAnimationDone } from "../vuex/actions/app"

    export default{
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
                this.GoodsReceivedIndex().then(() => {
                    console.log('loaded');
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

            }
        },


        events: {},


        /*
         * Component methods
         */
        methods: {}
    }
</script>