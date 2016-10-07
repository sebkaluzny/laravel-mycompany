<template>
    <div class="ui modal" id="{{ div }}">
        <i class="close icon"></i>
        <div class="header">
            <span>Eksportuj dane</span>
        </div>

        <div class="content">
            <div class="ui form">
                <div class="field">
                    <label>Dane do wyeksportowania</label>
                    <select multiple="" class="ui dropdown" id="multi-select" v-model="form.exportData">
                        <option value="">Wybierz dane</option>
                        <option value="position">Pozycja</option>
                        <option value="note">Notatka</option>
                        <option value="making">Materiał</option>
                        <option value="size">Wymiary</option>
                        <option value="quantity">Ilość sztuk</option>
                        <option value="done_quantity">Ilość wykonanych sztuk</option>
                        <option value="tasks">Zadania</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="actions">
            <div class="ui button">Cancel</div>
            <div class="ui button" v-on:click.prevent="submit">
                Eksportuj
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
                div: 'exportElementsModal',

                form: {
                    exportData: null,
                },

                type: null,
            }
        },


        events: {
            'modal:export-elements:show': function (type = null) {
                this.type = type;

                $('#' + this.div).modal({
                    onVisible: function () {
                        $('#multi-select')
                                .dropdown()
                        ;
                    }
                }).modal('show');
            },

            'modal:export-elements:hide': function () {
//                this.reset();
                $('#' + this.div).modal('hide');
            }
        },


        /*
         * Component methods
         */
        methods: {
            submit: function () {
                this.submitCallback(this.type, this.form);
            }
        }
    }
</script>