<template>
    <div class="header item">Akcja</div>
    <a class="item" v-link="{ path: '/element-task' }" v-bind:class="{'active': $route.path == '/element-task'}">
        Lista zadań
    </a>
    <a class="item" v-link="{ path: '/element-task/create' }" v-bind:class="{'active': $route.path == '/element-task/create'}">
        Dodaj nowe zadanie
    </a>
</template>
<script type="text/ecmascript-6">
    export default{
        ready: function () {

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