<template>
    <div class="ui modal" id="{{ div}}">
        <i class="close icon"></i>

        <div class="header">
            <span>Wybierz projekt</span>
        </div>

        <div class="ui pointing secondary menu">
            <a class="item active" data-tab="first">Znajdź</a>
            <a class="item" data-tab="second">Dodaj nowy</a>
        </div>

        <div class="content">
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
                        <th>Liczba elementów</th>
                        <th>Data utworzenia</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="project in searchProjects | orderBy 'elements_count' -1" v-on:click.prevent="select(project)">
                        <td>{{ project.name }}</td>
                        <td>{{ project.elements_count }}</td>
                        <td>{{ project.created_at }}</td>
                    </tr>
                    </tbody>
                </table>
                <!--results end-->
            </div>
            <!-- Search end -->
            <!-- Create new -->
            <div class="ui tab" data-tab="second">
                <project-form :form.sync="form" :submit-callback="submit" :busy.sync="busy.form"></project-form>
            </div>
            <!-- Create new end -->
        </div>

        <div class="actions">
            <div class="ui tab active" data-tab="first">
                <div class="ui button">Cancel</div>
            </div>
            <div class="ui tab" data-tab="second">
                <div class="ui button">Cancel</div>
                <div class="ui button" v-on:click.prevent="submit" v-bind:class="{ 'loading disabled': busy.form }">
                    Zapisz
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/ecmascript-6">

    import {ProjectCreate, ProjectGet, ProjectGetAll, ProjectUpdate, ProjectSearch} from './../../vuex/actions/project';
    import {searchIsBusy, searchProjects} from './../../vuex/getters/project-getters';

    export default{

        props: {
            projectCallback: {
                type: Function
            }
        },

        vuex: {
            getters: {searchIsBusy, searchProjects},
            actions: {ProjectCreate, ProjectGet, ProjectGetAll, ProjectUpdate, ProjectSearch}
        },

        ready: function () {
            this.doSearch();
        },


        data: function () {
            return {
                div: 'selectProjectModal',

                form: {
                    name: ''
                },

                busy: {
                    form: false,
                },
            }
        },


        events: {
            'modal:select-project:show': function () {
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

            'modal:select-project:hide': function () {
                this.reset();
                $('#' + this.div).modal('hide');
            }
        },


        /*
         * Component methods
         */
        methods: {
            reset: function () {
                this.form.name = '';
            },

            doSearch: function () {
                this.ProjectSearch(null);
            },

            submit: function () {
                this.busy.form = true;
                this.ProjectCreate(this.form).then(project => {
                    this.busy.form = false;
                    this.projectCallback(project);
                }, e => {
                    this.busy.form = false;
                });
            },

            select: function (project) {
                this.projectCallback(project);
            }
        }
    }
</script>