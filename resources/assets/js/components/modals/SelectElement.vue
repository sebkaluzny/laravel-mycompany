<template>
    <div class="ui modal" id="{{ div}}">
        <i class="close icon"></i>
        <div class="header">
            <span v-if="edit === false">Wybierz element</span>
            <span v-else>Edytuj element</span>
        </div>
        <div class="ui pointing secondary menu" v-if="edit === false">
            <a class="item active" data-tab="first">Znajdź element</a>
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
                                    v-bind:class="{ 'loading disabled': search.busy }">Szukaj
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
                        <th>Wymiary</th>
                        <th>Ilość</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="element in search.elements" v-on:click.prevent="selectElement(element)">
                        <td>{{ element.name }}</td>
                        <td>{{ element.thickness }} x {{ element.width }} x {{ element.length }}</td>
                        <td>{{ element.done_quantity }}/{{ element.quantity }}</td>
                    </tr>
                    </tbody>
                </table>
                <!--results end-->
            </div>
            <!-- Search end -->
            <!-- Create new -->
            <div class="ui tab" data-tab="second">
                <element-form :busy.sync="form.busy" :form.sync="form" :callback="create"></element-form>
            </div>
            <!-- Create new end -->
        </div>

        <!--Update form-->
        <div class="content" v-else>
            <element-form :fields.sync="fields" :busy.sync="form.busy" :form.sync="form" :callback="update"></element-form>
        </div>
        <!--Update form end-->

        <div class="actions" v-if="edit === false">
            <div class="ui tab active" data-tab="first">
                <div class="ui button">Cancel</div>
            </div>
            <div class="ui tab" data-tab="second">
                <div class="ui button">Cancel</div>
                <div class="ui button" v-on:click.prevent="create" v-bind:class="{ 'loading disabled': form.busy }">
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

    import {ElementCreate, ElementSearch, ElementUpdate} from './../../vuex/actions/element';

    import elementForm from './../form/Element.vue';

    export default{

        components: {elementForm},

        vuex: {
            getters: {},
            actions: {
                ElementCreate,
                ElementSearch,
                ElementUpdate
            }
        },

        ready: function () {
            this.reset();

            this.doSearch();
        },


        data: function () {
            return {
                div: 'selectElementModal',

                form: {
                    name: '',
                    thickness: 0,
                    width: 0,
                    length: 0,
                    note: '',

                    busy: false,
                },

                search: {
                    name: '',

                    elements: [],

                    busy: false,
                },

                edit: false,
                editIndex: false,

                fields: false,
            }
        },


        events: {
            'modal:select-element:show': function (index = false, element = false, fields = false) {
                this.reset();
                this.edit = element;

                if(fields != false) {
                    this.fields = fields;
                }
                else {
                    this.fields = ['name', 'size', 'note'];
                }

                if(element !== false)
                {
                    this.editIndex = index;

                    this.form = {
                        name: element.name,
                        thickness: element.thickness,
                        width: element.width,
                        length: element.length,
                        note: element.note,
                        done_quantity: element.done_quantity,

                        busy: false,
                    }
                }

                $('#' + this.div).modal({
                    onHidden: function () {
//                        $('#selectElementModal.hidden').remove();
                    },
                    onVisible: function () {
                        $('.menu .item')
                                .tab({
                                    context: 'parent'
                                })
                        ;
                    }
                }).modal('show');
            },

            'modal:select-element:hide': function () {
                this.reset();
                $('#' + this.div).modal('hide');
            }
        },


        /*
         * Component methods
         */
        methods: {
            reset() {
//                $('.ui.dimmer.modals.page.transition.hidden').remove();
                this.form = {
                    name: '',
                    thickness: 0,
                    width: 0,
                    length: 0,
                    note: '',

                    busy: false,
                };

                this.fields = false;
                this.edit = false;
                this.editIndex = false;
            },

            createFormData: function() {
                var data = new FormData;

                data.append('name', this.form.name);
                data.append('thickness', this.form.thickness);
                data.append('width', this.form.width);
                data.append('length', this.form.length);
                data.append('note', this.form.note);

                return data;
            },

            create: function () {
                if (this.form.busy)
                    return;

                this.form.busy = true;

                this.ElementCreate(this.createFormData()).then(element => {
                    this.form.busy = false;
                    this.$dispatch('modal:select-element:callback', element);
                }, e => {
                    this.form.busy = false;
                });
            },

            update: function() {
                if (this.form.busy && this.edit !== false)
                    return;

                this.form.busy = true;

                this.ElementUpdate(this.edit.id, this.form).then(element => {
                    this.form.busy = false;
//                    this.edit = element;
                    this.$dispatch('modal:select-element:edit:callback', this.editIndex, element);
                }, e => {
                    this.form.busy = false;
                });
            },

            selectElement: function(element) {
                this.$dispatch('modal:select-element:callback', element);
            },

            doSearch: function () {
                var data = new FormData;

                data.append('name', this.search.name);

                this.search.busy = true;

                this.ElementSearch(data).then(elements => {
                    this.search.busy = false;
                    this.search.elements = elements;

                    setTimeout(() => {
                        $('#' + this.div).modal('refresh');
                    }, 50);
                }, e => {
                    this.search.busy = false;
                });
            }
        }
    }
</script>