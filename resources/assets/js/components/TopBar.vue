<template>
    <div class="ui fixed inverted menu">
        <div class="ui container">
            <a href="#" class="header item">
                <img class="logo" style="width: 52px" src="/images/logo.png" alt="">
                My Company
            </a>
            <a href="#" class="item">Home</a>

            <div class="ui simple dropdown item">
                Elementy <i class="dropdown icon"></i>
                <div class="menu">
                    <a class="item" href="#" v-link="{ path: '/element' }">Lista elementów</a>
                    <a class="item" href="#" v-link="{ path: '/element/create' }">Nowy element</a>
                    <a class="item" href="#" v-link="{ path: '/element-task' }">Lista zadań</a>
                </div>
            </div>

            <div class="ui simple dropdown item">
                Magazyn <i class="dropdown icon"></i>
                <div class="menu">
                    <a class="item" href="#" v-link="{ path: '/goods-received' }">Przyjęcie z zewnątrz</a>
                    <a class="item" href="#">Wydanie na zewnątrz</a>
                </div>
            </div>
        </div>
    </div>
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