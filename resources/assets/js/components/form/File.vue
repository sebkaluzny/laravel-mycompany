<template>
    <form v-on:submit.prevent="submit" enctype="multipart/form-data">
        <div class="ui equal width form" v-bind:class="{ 'loading': form.busy }">
            <div class="fields">
                <div class="field">
                    <label>Nazwa</label>
                    <input type="text" placeholder="Nazwa" v-model="form.name">
                </div>
            </div>
            <div class="field">
                <label>Wybierz plik</label>
                <input type="file" id="fileInput" v-el:fileInput>
            </div>
        </div>
        <button type="submit" style="display: none;"></button>
    </form>
</template>
<script type="text/ecmascript-6">
    export default{

        props: {
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


        events: {
            'form:file:submit': function () {
                this.submit();
            }
        },


        /*
         * Component methods
         */
        methods: {
            submit: function () {
                var data = new FormData();

                data.append('name', this.form.name);

                data.append('file', this.$els.fileinput.files[0]);

                console.log(data);

                this.callback(data);

            }
        }
    }
</script>