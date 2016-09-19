<template>
    <div class="ui modal" id="{{ div}}">
        <i class="close icon"></i>
        <div class="header">
            <span v-if="edit === false">Wybierz plik</span>
            <span v-else>Edytuj plik</span>
        </div>
        <div class="ui pointing secondary menu" v-if="edit === false">
            <a class="item active" data-tab="first">Znajdź plik</a>
            <a class="item" data-tab="second">Dodaj nowy</a>
        </div>
        <div class="content" v-if="edit === false">
            <!-- Search -->
            <div class="ui tab active" data-tab="first">
                <!--Form-->
                <div class="ui form">
                    <div class="fields">
                        <div class="thirteen wide field">
                            <input type="text" placeholder="Wpisz nazwę.." v-model="search.name">
                        </div>
                        <div class="three wide field">
                            <button class="fluid ui button" v-on:click.prevent="doSearch"
                                    v-bind:class="{ 'loading disabled': searchIsBusy }">Szukaj
                            </button>
                        </div>
                    </div>
                </div>
                <!--Form end-->
                <!--results-->
                <table class="ui selectable striped table">
                    <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Rodzaj pliku</th>
                        <th>Data utworzenia</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="file in searchFiles" v-on:click.prevent="selected(file)">
                        <td>{{ file.name }}</td>
                        <td>{{ file.type }}</td>
                        <td>{{ file.created_at }}</td>
                    </tr>
                    </tbody>
                </table>
                <!--results end-->
            </div>
            <!-- Search end -->
            <!-- Create new -->
            <div class="ui tab" data-tab="second">
                <file-form :form.sync="form" :callback="create"></file-form>
            </div>
            <!-- Create new end -->
        </div>

        <!--Update form-->
        <div class="content" v-else>
            <file-form :form.sync="form" :callback="update"></file-form>
        </div>
        <!--Update form end-->

        <div class="actions" v-if="edit === false">
            <div class="ui tab active" data-tab="first">
                <div class="ui button">Cancel</div>
            </div>
            <div class="ui tab" data-tab="second">
                <div class="ui button">Cancel</div>
                <div class="ui button" v-on:click.prevent="sendSubmit" v-bind:class="{ 'loading disabled': form.busy }">
                    Zapisz
                </div>
            </div>
        </div>

        <div class="actions" v-else>
            <div class="ui button">Cancel</div>
            <div class="ui button" v-on:click.prevent="update" v-bind:class="{ 'loading disabled': form.busy }">
                Zapisz zmiany
            </div>
        </div>
    </div>
</template>
<script type="text/ecmascript-6">

    import { searchFiles, searchIsBusy } from './../../vuex/getters/file-getters';
    import { FileCreate, FileSearch } from './../../vuex/actions/file';

    import fileForm from './../form/File.vue';

    export default{

        components: {fileForm},

        vuex: {
            getters: {
                searchFiles,
                searchIsBusy,
            },
            actions: {
                FileCreate,
                FileSearch
            }
        },

        ready: function () {
            this.reset();

            this.doSearch();
        },


        data: function () {
            return {
                div: 'selectFileModal',

                form: {
                    name: '',

                    busy: false,
                },

                search: {
                    name: '',

                    files: [],

                    busy: false,
                },

                edit: false,
                editIndex: false,
            }
        },


        events: {
            'modal:select-file:show': function () {
                $('#' + this.div).modal({
                    onVisible: function () {
                        $('.menu .item')
                                .tab({
                                    context: 'parent'
                                })
                        ;
                    }
                }).modal('show');
            },

            'modal:select-file:hide': function () {
                this.reset();
                $('#' + this.div).modal('hide');
            }
        },


        /*
         * Component methods
         */
        methods: {
            reset: function () {

            },

            doSearch: function () {
                this.FileSearch({name: this.search.name});
            },

            sendSubmit: function () {
                this.$broadcast('form:file:submit');
            },

            selected: function (file) {
                this.$dispatch('modal:select-file:selected', file)
            },

            create: function (data) {

                console.log(data);

                this.form.busy = true;

                this.FileCreate(data).then(file => {
                    this.form.busy = false;
                    this.selected(file);
                }, e => {
                    this.form.busy = false;
                    console.error(e);
                } );
            },

            update: function () {

            }
        }
    }
</script>