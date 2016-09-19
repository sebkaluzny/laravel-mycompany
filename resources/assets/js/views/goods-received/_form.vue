<template>
    <form v-if="form != null" class="ui form" v-on:submit.prevent="saveCallback">
        <div class="field">
            <label>Numer dokumentu</label>
            <input type="text" placeholder="Numer dokumentu" v-model="form.number">
        </div>

        <div class="field">
            <label>Data otrzymania (rrrr-mm-ddd)</label>
            <input type="date" placeholder="Data otrzymania" v-model="form.received_at">
        </div>

        <div class="field">
            <label>Firma</label>
            <select class="ui search dropdown" v-model="form.company_id">
                <option value="">Wybierz firmę</option>
                <option v-for="company in companies" value="{{ company.dir_id }}">{{ company.name }}</option>
            </select>
        </div>

        <div class="field">
            <label>Elementy</label>
            <table class="ui striped table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nazwa</th>
                    <th>Wymiary</th>
                    <th>Ilość</th>
                    <th class="right aligned">Akcja</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(index, element) in form.elements">
                    <td>{{ index + 1 }}</td>
                    <td>{{ element.name }}</td>
                    <td>{{ element.thickness }} x {{ element.width }} x {{ element.length }}</td>
                    <td>
                        <div class="field">
                            <input type="number" step="1" placeholder="Ilość" v-model="element.count">
                        </div>
                    </td>
                    <td class="right aligned collapsing">
                        <div class="ui small button" v-on:click.prevent="editElement(index, element)">
                            Edytuj
                        </div>
                        <div class="ui small button">
                            Usuń
                        </div>
                    </td>
                </tr>
                </tbody>

                <tfoot class="full-width">
                <tr>
                    <th></th>
                    <th colspan="4">
                        <div class="ui right floated small primary labeled icon button" v-on:click.prevent="addElement">
                            <i class="add circle icon"></i> Dodaj element
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>

        <!--<dynamic-submit-button :busy.sync="form.busy" :text="['Zapisz','Zapisywanie']"></dynamic-submit-button>-->

        <button class="ui button" type="submit" v-bind:disabled="form.busy">
            <span v-if="!form.busy">Zapisz zmiany</span>
            <span v-else>Zapisywanie...</span>
        </button>
        <select-element-modal></select-element-modal>
    </form>
</template>
<script type="text/ecmascript-6">
    import { companies } from "./../../vuex/getters/company-getters"

    import SelectElementModal from './../../components/modals/SelectElement.vue';

    export default{

        components: { SelectElementModal },

        props: {
            form: {
                default: {},
            },

            edit: {
                default: false,
            },

            busy: {
                default: false
            },

            saveCallback: {
                type: Function,
            },
        },

        vuex: {
            getters: {
                companies: companies,
            },
            actions: {
            }
        },

        watch: {
            form: function (val1, val2) {
                $('select.dropdown')
                        .dropdown()
                ;

                if(this.edit)
                {
                    window._.each(this.form.elements, element => {
                        Vue.set(element, 'count', element.pivot.quantity);
                    });
                }
            }
        },

        ready: function () {
        },


        data: function () {
            return {}
        },

        events: {
            'modal:select-element:callback': function (element) {
                this.form.elements.push(element);
                this.$broadcast('modal:select-element:hide');
            },

            'modal:select-element:edit:callback': function (index, element) {
                this.form.elements.$set(index, element);
                this.$broadcast('modal:select-element:hide');
            },
        },


        /*
         * Component methods
         */
        methods: {
            addElement: function () {
                this.$broadcast('modal:select-element:show');
            },

            editElement: function (index, element) {
                this.$broadcast('modal:select-element:show', index, element);
            },
        }

    }
</script>