<template>
    <top-bar></top-bar>

    <selected-elements-bar></selected-elements-bar>

    <div class="ui main container" style="margin-bottom: 100px;">
        <div v-if="busy">
            Wczytywanie danych...
        </div>
        <div v-else>
            <router-view></router-view>
        </div>
    </div>
</template>
<script type="text/ecmascript-6">
    import TopBar from './TopBar.vue';
    import SelectedElementsBar from './SelectedElementsBar.vue';

    import { CompanyFetchAll } from "./../vuex/actions/company";

    export default{

        components: { TopBar, SelectedElementsBar },

        vuex: {
            getters: {},
            actions: {
                CompanyFetchAll
            }
        },

        created: function () {
            this.busy = true;
            this.CompanyFetchAll().then(() => {
                this.busy = false;
            });
        },

        ready: function () {
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