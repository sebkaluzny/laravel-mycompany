<template>
    <div class="ui teal floating labeled icon dropdown button" style="margin-bottom: 3px;">
        <i class="file outline icon"
           v-bind:class="{ 'pdf': file.type == 'application/pdf', 'image': file.type.indexOf('image') !== -1}"></i>
        <span class="text">{{ file.name }}</span>
        <div class="menu">
            <div class="header">
                <i class="help icon"></i>
                Co chcesz zrobić?
            </div>
            <div class="divider"></div>
            <div class="item">
                <i class="unhide icon"></i>
                Zobacz
            </div>
            <div class="item">
                <i class="download icon"></i>
                Ściągnij
            </div>
            <div class="divider"></div>
            <div class="item" v-on:click.prevent="unattach">
                <i class="ban icon"></i>
                Usuń załącznik
            </div>
        </div>
    </div>

</template>
<script type="text/ecmascript-6">

    import FileUnattachModal from './../modals/ConfirmFileUnattach.vue';

    export default{

        components: {FileUnattachModal},

        props: ['file'],

        ready: function () {
            $('.ui.dropdown')
                    .dropdown({
                        action: 'hide'
                    })
            ;
        },


        data: function () {
            return {}
        },


        events: {},


        /*
         * Component methods
         */
        methods: {
            unattach: function () {
                this.$dispatch('file-unattach', this.file);
            }
        }
    }
</script>