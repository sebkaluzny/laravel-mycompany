<template>
    <h1 class="ui header">Przyjęcie z zewnątrz</h1>

    <div v-if="editModel != null">
        <goods-received-form :form.sync="form" :save-callback="submit" edit="true"></goods-received-form>
    </div>

    <div class="ui inverted dimmer" v-bind:class="{ 'active': editIsBusy }">
        <div class="ui text loader">Wczytywanie</div>
    </div>
</template>
<script type="text/ecmascript-6">

    import {editIsBusy, editModel, editForm} from "./../../vuex/getters/goods-received-getters"
    import {setGoodsReceivedEditModel, GoodsReceivedGet, GoodsReceivedUpdate, setGoodsReceivedShowModel} from "./../../vuex/actions/goods-received"
    import { companies } from "./../../vuex/getters/company-getters"

    import SelectElementModal from './../../components/modals/SelectElement.vue';
    import GoodsReceivedForm from './_form.vue';

    export default {

        components: { SelectElementModal, GoodsReceivedForm },

        vuex: {
            getters: {
                editIsBusy,
                companies: companies,
                editModel,
                editForm,
            },
            actions: {
                GoodsReceivedGet,
                setGoodsReceivedEditModel,
                GoodsReceivedUpdate,
                setGoodsReceivedShowModel
            }
        },

        ready: function () {
        },

        route: {
            data: function () {
                $('#selectElementModal').remove();
                const id = this.$route.params.id;

                if (this.form == null || this.editForm == null || this.editModel == null || this.editModel.id != id) {
                    this.setGoodsReceivedEditModel(id).then(() => {
                        this.form = this.editForm;
                    });
                }
            }
        },


        data: function () {
            return {
                form: null,
            }
        },


        events: {
        },


        /*
         * Component methods
         */
        methods: {
            submit: function () {
//                this.$dispatch('SET_GOODS_RECEIVED_EDIT_BUSY', true);
                this.form.busy = true;

                this.GoodsReceivedUpdate(this.editModel.id, this.form).then(model => {
                    this.form.busy = false;
                    this.setGoodsReceivedShowModel(model.id);
                    this.$route.router.go("/goods-received/" + model.id);
                }, e => {
                    window.alert("TO-DO ERROR. Czy wszystkie pola zostały uzupełnione?");

                    this.form.busy = false;
                });
            },
        }
    }
</script>