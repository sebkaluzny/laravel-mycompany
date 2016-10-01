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
            <tr>
                <td>Materiał</td>
                <td>{{ showModel.making }}</td>
            </tr>
            <tr>
                <td>Projekt</td>
                <td>{{ showModel.project ? showModel.project.name: '-' }} <a href="#" v-on:click.prevent="chooseProject">wybierz projekt</a></td>
            </tr>
            </tbody>
            <tfoot class="full-width">
            <tr>
                <th></th>
                <th colspan="4">
                    <a class="ui right floated small primary labeled icon button" v-on:click.prevent="edit">
                        <i class="edit icon"></i> edytuj
                    </a>
                    <a class="ui right floated small labeled icon button" v-on:click.prevent="replicate">
                        <i class="edit icon"></i> duplikuj
                    </a>
                </th>
            </tr>
            </tfoot>
        </table>

        <h3 class="ui block header">
            Zadania
        </h3>
        <element-tasks :element.sync="showModel" :refresh-callback="refreshElement"></element-tasks>


        <h3 class="ui block header">
            Załączniki
        </h3>

        <file-dropdown-button v-for="file in showModel.files" :file.sync="file"></file-dropdown-button>

        <div class="ui grey floating labeled icon button" v-on:click.prevent="addFile">
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
                <td><a href="#" v-link="{ name: 'goods-received-show', params: { id: item.id }}">{{ item.number }}</a></td>
                <td>+ {{ item.pivot.quantity }}</td>
            </tr>
            </tbody>
        </table>


    </div>

    <select-file-modal></select-file-modal>
    <file-unattach-modal></file-unattach-modal>
    <select-element-modal></select-element-modal>

    <project-select-modal :project-callback="setProject"></project-select-modal>
    <element-replicate-modal :submit-callback="doReplicate"></element-replicate-modal>
    <page-loader :busy.sync="showIsBusy"></page-loader>
</template>
<script type="text/ecmascript-6">
    import {showIsBusy, showModel} from "./../../vuex/getters/element-getters"
    import {setElementShow, ElementAttachFile, ElementDetachFile,setElementShowModel, ElementUpdate, ElementReplicate} from "./../../vuex/actions/element"

    import PageLoader from './../../components/PageLoader.vue';
    import SelectFileModal from './../../components/modals/SelectFile.vue';
    import FileDropdownButton from './../../components/items/FileDropdownButton.vue';
    import ElementTasks from './../../components/items/ElementTasks.vue';
    import FileUnattachModal from './../../components/modals/ConfirmFileUnattach.vue';
    import SelectElementModal from './../../components/modals/SelectElement.vue';

    export default{

        components: {PageLoader, SelectFileModal, FileDropdownButton, FileUnattachModal, SelectElementModal, ElementTasks},

        vuex: {
            getters: {
                showIsBusy,
                showModel
            },
            actions: {
                setElementShow,
                ElementAttachFile,
                ElementDetachFile,
                setElementShowModel,
                ElementUpdate,
                ElementReplicate
            }
        },

        ready: function () {
            $('.dropdown')
                    .dropdown()
            ;
            $('body .modals').remove();
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
                    this.refreshElement();
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
                this.$broadcast('modal:select-element:show', null, this.showModel, ['name', 'size', 'note', 'done_quantity', 'quantity', 'making']);
            },

            addTask: function () {

            },

            refreshElement: function () {
                this.setElementShow(this.showModel.id);
            },

            chooseProject: function () {
                this.$broadcast('modal:select-project:show');
            },

            setProject: function (project) {

                this.ElementUpdate(this.showModel.id, {project_id: project.id}).then(element => {
//                    this.setElementShowModel(element);
                    this.refreshElement();
                });

                this.$broadcast('modal:select-project:hide');
            },

            replicate: function () {
                this.$broadcast('modal:element-replicate:show');
            },

            doReplicate: function (form) {
                this.$broadcast('modal:element-replicate:hide');

                this.ElementReplicate({
                    id: this.showModel.id,
                    name: form.name
                }).then(element => {
                    this.$route.router.go("/element/" + element.id);
                }, e => {
                    console.error(e);
                });
            }
        }
    }
</script>