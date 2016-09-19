<template>
    <div class="ui basic modal" id="{{ div }}">
        <i class="close icon"></i>
        <div class="ui icon header">
            <i class="ban icon"></i>
            Usunąć załącznik?
        </div>
        <div class="content" style="text-align: center;">
            <p>Czy jesteś pewny, że chcesz usunąć ten załącznik?</p>
        </div>
        <div class="actions">
            <div class="ui cancel red basic inverted button">
                <i class="remove icon"></i>
                Nie
            </div>
            <div class="ui ok green basic inverted button" v-on:click.prevent="accept">
                <i class="checkmark icon"></i>
                Tak
            </div>
        </div>
    </div>
</template>
<script type="text/ecmascript-6">
    export default{
        ready: function () {

        },


        data: function () {
            return {
                div: 'confirmFileUnattach',

                callback: false,
            }
        },


        events: {
            'modal:confirm-file-unattach:show': function (callback) {
                $('#' + this.div).modal({
                    onVisible: function () {

                    }
                }).modal('show');

                this.callback = callback;
            },

            'modal:confirm-file-unattach:hide': function () {
                $('#' + this.div).modal('hide');
            }
        },


        /*
         * Component methods
         */
        methods: {
            accept: function () {
                this.$dispatch('modal:confirm-file-unattach:accept', this.callback);
            }
        }
    }
</script>