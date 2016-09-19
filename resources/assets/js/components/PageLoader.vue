<template>
    <div class="ui inverted dimmer" v-bind:class="{ 'active': busy }">
        <div class="ui text loader">Wczytywanie</div>
    </div>
</template>
<script type="text/ecmascript-6">
    export default{

        props: {
            busy: {
                default: false,
            }
        },
    }
</script>