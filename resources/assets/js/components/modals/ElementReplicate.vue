<template>
    <div class="ui modal" id="{{ div }}">
        <i class="close icon"></i>
        <div class="header">
            <span>Duplikuj element</span>
        </div>

        <div class="content">
            <div class="ui form">
                <div class="field">
                    <label>Nazwa</label>
                    <input type="text" v-model="form.name">
                </div>
            </div>
        </div>

        <div class="actions">
            <div class="ui button">Cancel</div>
            <div class="ui button" v-on:click.prevent="submit">
                Zapisz
            </div>
        </div>
    </div>
</template>
<script type="text/ecmascript-6">
    export default{

        props: {
            submitCallback: {
                type: Function
            }
        },

        ready: function () {

        },


        data: function () {
            return {
                div: 'elementReplicateModal',

                form: {
                    name: null,
                },
            }
        },


        events: {
            'modal:element-replicate:show': function () {
                $('#' + this.div).modal('show');
            },

            'modal:element-replicate:hide': function () {
//                this.reset();
                $('#' + this.div).modal('hide');
            }
        },


        /*
         * Component methods
         */
        methods: {
            submit: function () {
                this.submitCallback(this.form);
            }
        }
    }
</script>