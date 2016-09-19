<template>
    <form v-on:submit.prevent="callback">
        <div class="ui equal width form" v-bind:class="{ 'loading': busy }">
            <div class="fields" v-if="fields.indexOf('name') !== -1">
                <div class="field">
                    <label>Nazwa</label>
                    <input type="text" placeholder="Nazwa" v-model="form.name">
                </div>
            </div>
            <div class="fields" v-if="fields.indexOf('size') !== -1">
                <div class="field">
                    <label>Grubość</label>
                    <input type="number" step="0.01" placeholder="Grubość" v-model="form.thickness">
                </div>
                <div class="field">
                    <label>Szerokość</label>
                    <input type="number" step="0.01" placeholder="Szerokość" v-model="form.width">
                </div>
                <div class="field">
                    <label>Długość</label>
                    <input type="number" step="0.01" placeholder="Długość" v-model="form.length">
                </div>
            </div>
            <div class="field" v-if="fields.indexOf('note') !== -1">
                <label>Notatka</label>
                <textarea rows="2" v-model="form.note"></textarea>
            </div>
            <div class="field" v-if="fields.indexOf('done_quantity') !== -1">
                <label>Wykonanych elementów</label>
                <input type="number" v-model="form.done_quantity" placeholder="Liczba wykonanych elementów">
            </div>
        </div>
        <button type="submit" style="display: none;"></button>
    </form>
</template>
<script type="text/ecmascript-6">
    export default{

        props: {
            fields: {
                type: Array,
                default: function () { return ['note', 'size', 'name'] }
            },

            busy: {
                default: false
            },

            form: {
                default: {}
            },

            callback: {
                type: Function
            }
        },

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