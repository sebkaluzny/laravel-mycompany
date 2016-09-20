<template>
    <h3 class="ui block header">
        Zadania
    </h3>
    <div class="ui internally celled grid">
        <div class="row">
            <div class="three wide column">
                <div class="ui fluid text vertical menu">
                    <element-task-menu></element-task-menu>
                </div>
            </div>
            <div class="thirteen wide column">
                <router-view></router-view>
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