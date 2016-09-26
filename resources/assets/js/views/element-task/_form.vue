<template>
    <form v-if="form != null" v-on:submit.prevent="submit">
        <div class="ui form">
            <div class="field">
                <label>Nazwa</label>
                <input type="text" placeholder="np. Wiercenie, Gwintowanie" v-model="form.name">
            </div>

            <div class="fields" v-for="field in form.fields">
                <div class="ten wide field">
                    <label>Nazwa</label>
                    <input type="text" v-model="field.name" placeholder="np. Średnica, długość">
                </div>
                <div class="four wide field">
                    <label>Jednostka</label>
                    <input type="text" v-model="field.unit" placeholder="np. M, &Oslash;, mm">
                    <div class="form-helper-text">Wstaw: <a href="#"><div class="ui label" v-on:click.prevent="appendSymbolToField(field, '&Oslash;')">&Oslash;</div></a></div>
                </div>
                <div class="two wide field">
                    <label>Akcja</label>
                    <a href="#" class="ui negative basic button" v-on:click.prevent="removeField(field)">usuń</a>
                </div>
            </div>

            <a href="#" class="ui button" v-on:click.prevent="addField" v-bind:class="{'disabled': busy}">Wstaw pole</a>

            <button class="ui button primary" type="submit" v-bind:disabled="busy">
                <span v-if="!busy">Zapisz</span>
                <span v-else>...</span>
            </button>

            <!--<div class="fields">-->
            <!--<div class="six wide field">-->
            <!--<label>Jednostka</label>-->
            <!--<input type="text" placeholder="np. M, &Oslash;,">-->
            <!--<div class="form-helper-text">Wstaw: <a href="#"><div class="ui label">&Oslash;</div></a></div>-->
            <!--</div>-->
            <!--</div>-->
        </div>
    </form>
</template>
<script type="text/ecmascript-6">
    export default{

        props: {
            form: {
                default: function () {
                    return {
                        name: '',
                        fields: [],
                    };
                },
            },

            busy: {
                default: false
            },

            submitCallback: {
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
        methods: {
            addField: function () {
                this.form.fields.push({name: '', unit: ''});
            },

            removeField: function (field) {
                this.form.fields.$remove(field);
            },

            submit: function () {
                this.submitCallback();
            },

            appendSymbolToField: function (field, text) {
                field.unit = field.unit + '' + text;
            }
        }
    }
</script>

<style>
    .form-helper-text {
        margin-top: 4px;
        margin-left: 5px;
        color: gray;
        font-size: 12px;
    }
</style>