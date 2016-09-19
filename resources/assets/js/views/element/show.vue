<template>
    <div v-if="showModel != null">
        <h3 class="ui block header">
            Ogólne informacje
        </h3>

        <table class="ui celled striped table selectable">
            <thead>
            <tr>
                <th>Nazwa</th>
                <th>Wartość</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Nazwa</td>
                <td>{{ showModel.name }}</td>
            </tr>
            <tr>
                <td>Grubość</td>
                <td>{{ showModel.thickness }}</td>
            </tr>
            <tr>
                <td>Szerokość</td>
                <td>{{ showModel.width }}</td>
            </tr>
            <tr>
                <td>Długość</td>
                <td>{{ showModel.length }}</td>
            </tr>
            <tr>
                <td>Ilość na stanie</td>
                <td>{{ showModel.quantity }}</td>
            </tr>
            <tr>
                <td class="collapsing">Ilość wykonanych</td>
                <td>{{ showModel.done_quantity }}</td>
            </tr>
            <tr>
                <td>Data dodania</td>
                <td>{{ showModel.created_at }}</td>
            </tr>
            <tr>
                <td>Notatka</td>
                <td>{{ showModel.note }}</td>
            </tr>
            </tbody>
            <tfoot class="full-width">
            <tr>
                <th></th>
                <th colspan="4">
                    <a class="ui right floated small primary labeled icon button" v-on:click.prevent="edit">
                        <i class="edit icon"></i> edytuj
                    </a>
                </th>
            </tr>
            </tfoot>
        </table>

        <h3 class="ui block header">
            Załączniki
        </h3>

        <file-dropdown-button v-for="file in showModel.files" :file.sync="file"></file-dropdown-button>

        <div class="ui grey floating labeled icon dropdown button" v-on:click.prevent="addFile">
            <i class="add circle icon"></i>
            <span class="text">dodaj załącznik</span>
        </div>


        <h3 class="ui block header">
            Historia
        </h3>

        <table class="ui celled striped table selectable">
            <thead>
            <tr>
                <th>Data</th>
                <th>Numer dokumentu</th>
                <th>Ilość</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in showModel.goods_received">
                <td>{{ item.created_at }}</td>
                <td>{{ item.number }}</td>
                <td>+ {{ item.pivot.quantity }}</td>
            </tr>
            </tbody>
        </table>


    </div>

    <select-file-modal></select-file-modal>
    <file-unattach-modal></file-unattach-modal>
    <select-element-modal></select-element-modal>

    <page-loader :busy.sync="showIsBusy"></page-loader>
</template>
<script type="text/ecmascript-6">
    import {showIsBusy, showModel} from "./../../vuex/getters/element-getters"
    import {setElementShow, ElementAttachFile, ElementDetachFile,setElementShowModel} from "./../../vuex/actions/element"

    import PageLoader from './../../components/PageLoader.vue';
    import SelectFileModal from './../../components/modals/SelectFile.vue';
    import FileDropdownButton from './../../components/items/FileDropdownButton.vue';
    import FileUnattachModal from './../../components/modals/ConfirmFileUnattach.vue';
    import SelectElementModal from './../../components/modals/SelectElement.vue';

    export default{

        components: {PageLoader, SelectFileModal, FileDropdownButton, FileUnattachModal, SelectElementModal},

        vuex: {
            getters: {
                showIsBusy,
                showModel
            },
            actions: {
                setElementShow,
                ElementAttachFile,
                ElementDetachFile,
                setElementShowModel
            }
        },

        ready: function () {
            $('.dropdown')
                    .dropdown()
            ;
        },


        data: function () {
            return {}
        },


        events: {
            'modal:select-file:selected': function (file) {
                var data = new FormData();

                data.append('element_id', this.showModel.id);

                data.append('file_id', file.id);

                this.$broadcast('modal:select-file:hide')

                this.ElementAttachFile(data).then(() => {
                    this.setElementShow(this.showModel.id);
                });
            },

            'file-unattach': function (file) {
                this.$broadcast('modal:confirm-file-unattach:show', file);
            },

            'modal:confirm-file-unattach:accept': function (file) {
                this.$broadcast('modal:confirm-file-unattach:hide');

                console.log(file);

                var data = new FormData();

                data.append('element_id', this.showModel.id);

                data.append('file_id', file.id);

                this.ElementDetachFile(data).then(element => {
                    this.setElementShow(this.showModel.id);
//                    this.$dispatch('SET_ELEMENT_SHOW_MODEL', element);
//                    this.$broadcast('modal:confirm-file-unattach:hide');
                });
            },

            'modal:select-element:edit:callback': function (index, element) {
                this.setElementShowModel(element);
                this.$broadcast('modal:select-element:hide');
            },
        },

        route: {
            data: function () {
                $('body .modals').remove();

                const id = this.$route.params.id;

                if (this.showModel == null || this.showModel.id != id) {
                    this.setElementShow(id);
                }
            }
        },


        /*
         * Component methods
         */
        methods: {
            addFile: function () {
                this.$broadcast('modal:select-file:show');
            },

            edit: function () {
                this.$broadcast('modal:select-element:show', null, this.showModel, ['name', 'size', 'note', 'done_quantity']);
            },
        }
    }
</script>