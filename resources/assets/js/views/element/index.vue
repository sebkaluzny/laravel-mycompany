<template>
    <h3 class="ui block header">
        Lista elementów
    </h3>
    <div class="ui internally celled grid">
        <div class="row">
            <div class="three wide column">
                <div class="ui secondary vertical menu fluid">
                    <div class="item">
                        <div class="ui input">
                            <input type="text" placeholder="Szukaj..." v-model="search" debounce="400">
                        </div>
                    </div>

                    <div class="header item">Projekt</div>
                    <a class="item" v-for="project in projects | orderBy 'elements_count' -1"
                       v-on:click.prevent="selectProject(project)"
                       v-bind:class="{'active': $route.params.project == project.id}">
                        {{ project.name }} <span class="ui label">{{ project.elements_count }}</span>
                    </a>
                </div>
            </div>
            <div class="thirteen wide column" id="ElementsList">

                <div class="ui secondary  menu">
                    <div class="right menu">
                        <a class="ui item" v-on:click.prevent="selectAll">
                            Zaznacz wszystko
                        </a>
                    </div>
                </div>

                <div class="ui divided items" v-if="indexElements != null">
                    <div class="item ElementItem" v-for="element in indexElements"
                         v-bind:class="{ 'selected': isSelectedElement(element)}">
                        <a class="ui tiny image">
                            <img src="http://placehold.it/80x80">
                        </a>
                        <div class="content" id="elementShow">
                            <div class="ui grid">
                                <div class="fifteen wide column">
                                    <a class="header" v-link="{ name: 'element-show', params: { id: element.id }}">{{
                                        element.name }}</a>
                                    <span class="created_date">
                                        {{ element.created_at }}
                                    </span>
                                    <div class="description">
                                        {{ element.thickness }} x {{ element.width }} x {{ element.length }}
                                        <span v-if="element.project">
                                            | Projekt: {{ element.project.name }}
                                        </span>
                                        <span> | Materiał: {{ element.making }} </span>
                                    </div>
                                    <div class="extra">
                                        <div class="ui tiny label" :class="{'grey': element.quantity > 0 }">
                                            Na stanie: {{ element.quantity }}
                                        </div>
                                        <div class="ui tiny label" :class="{'grey': element.done_quantity > 0 }">
                                            Ukończonych: {{ element.done_quantity }}
                                        </div>
                                        <div v-if="element.quantity > 0" class="ui tiny label"
                                             :class="{'red': element.done_quantity == 0 }">
                                            Wykonanych: {{ element.done_quantity }}
                                        </div>
                                        <div v-if="element.tasks.length == 0" class="ui tiny label yellow">
                                            Brak określonych zadań
                                        </div>
                                        <div v-for="task in element.tasks" class="ui tiny label">
                                            {{ task.name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="one wide column column-centered-content">
                                    <div class="ui checkbox" v-on:click.prevent="elementSelectClick(null, element)"
                                         v-bind:class="{ 'checked': isSelectedElement(element)}">
                                        <input type="checkbox" tabindex="0" class="hidden"
                                               v-bind:checked="isSelectedElement(element)">
                                        <label></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <pagination v-if="indexPagination" :pagination="indexPagination" :callback="loadPagination"
                            :offset="3"></pagination>

                <page-loader :busy.sync="indexIsBusy"></page-loader>
            </div>
        </div>
    </div>

</template>
<script type="text/ecmascript-6">

    import {ElementIndex} from './../../vuex/actions/element';
    import {ProjectGetAll} from './../../vuex/actions/project';
    import {isSelectedElement, SelectElement, clearAllSelected} from './../../vuex/actions/selected-elements';
    import {indexElements, indexIsBusy, indexPagination} from './../../vuex/getters/element-getters';
    import {searchProjects} from './../../vuex/getters/project-getters';

    import PageLoader from './../../components/PageLoader.vue';

    export default{

        components: {PageLoader},

        vuex: {
            getters: {
                indexElements,
                indexIsBusy,
                indexPagination
            },
            actions: {
                ElementIndex,
                ProjectGetAll,
                isSelectedElement, SelectElement, clearAllSelected
            }
        },

        watch: {
            search: function () {
                if (this.search != '') {
                    this.ElementIndex({search: this.search});
                }
                else {
                    this.ElementIndex();
                }
            },
        },

        ready: function () {

        },

        route: {
            data: function () {
                this.loadData();
                this.loadIndex(0);
            }
        },


        data: function () {
            return {
                search: '',

                projects: [],
            }
        },


        events: {},


        /*
         * Component methods
         */
        methods: {

            loadIndex: function (page = 0) {
                var data = {};

                const project_id = this.$route.params.project;

                if (project_id != null) {
                    data.project_id = project_id;
                }

                data.page = page;

                this.ElementIndex(data).then(() => {});
            },

            loadData: function () {
                this.ProjectGetAll().then(projects => {
                    this.projects = projects;
                });
            },

            selectProject: function (project) {
                if (this.$route.params.project == project.id) {
                    this.$route.router.go({name: 'element-index-filter', params: {project: 0}});

                }
                else {
                    this.$route.router.go({name: 'element-index-filter', params: {project: project.id}});
                }
            },

            elementSelectClick: function (event, element) {

//                console.log(element);

                this.SelectElement(event, element);
            },

            selectAll: function () {
//                this.clearAllSelected();

                window._.each(this.indexElements, element => {
                    this.SelectElement(null, element);
                })
            },

            loadPagination: function () {
                this.loadIndex(this.indexPagination.current_page);
            }
        }
    }
</script>

<style>
    .column-centered-content {
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    #elementShow .header {
        font-size: 1.28571429em;
        color: rgba(0, 0, 0, .85);
        display: inline-block;
        margin: -.21425em 0 0;
        font-family: Lato, 'Helvetica Neue', Arial, Helvetica, sans-serif;
        font-weight: 700;
    }

    #elementShow .description {
        margin-top: .6em;
        font-size: 1em;
        line-height: 1.4285em;
        color: rgba(0, 0, 0, .87);
    }

    #ElementsList .ElementItem:last-child,
    #ElementsList .ElementItem:first-child,
    #ElementsList .ElementItem {
        padding: 1em 12px !important;
    }

    #ElementsList .ElementItem.selected {
        background: #f1f1f1;
    }

    .created_date {
        color: #c5c5c5;
        float: right;
        font-size: 11px;
    }
</style>