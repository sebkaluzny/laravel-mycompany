<template>
    <main-view></main-view>
</template>
<script type="text/ecmascript-6">

    import store from "./../vuex/store"
    import TopBar from './TopBar.vue';
    import MainView from './MainView.vue';

    import { CompanyFetchAll } from "./../vuex/actions/company";

    export default{
        store: store,
        components: { MainView },

        data: function () {
            return {
                store: store,
            }
        },


        events: {},


        /*
         * Component methods
         */
        methods: {}
    }
</script>