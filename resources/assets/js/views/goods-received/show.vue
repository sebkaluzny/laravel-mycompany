<template>
    <div class="ui">
        <h1 class="ui header">Przyjęcie z zewnątrz</h1>

        <div v-if="showModel != null">
            <h3 class="ui block header">
                Ogólne informacje <small><a href="#" class="mini ui button right floated" v-link="{ name: 'goods-received-edit', params: { id: showModel.id }}">edytuj</a></small>
            </h3>

            <table class="ui selectable basic table">
                <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Wartość</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="collapsing">Numer dokumentu</td>
                    <td>{{ showModel.number }}</td>
                </tr>
                <tr>
                    <td>Firma</td>
                    <td>{{ showModel.company.name }}</td>
                </tr>
                <tr>
                    <td>Liczba elementów</td>
                    <td>{{ showModel.elements.length }}</td>
                </tr>
                <tr>
                    <td>Data otrzymania</td>
                    <td>{{ showModel.received_at_date }}</td>
                </tr>
                <tr>
                    <td>Data dodania</td>
                    <td>{{ showModel.created_at }}</td>
                </tr>
                </tbody>
            </table>

            <h3 class="ui block header">
                Lista elementów ({{ showModel.elements.length }})
            </h3>

            <table class="ui selectable celled table" v-if="showModel.elements.length > 0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nazwa</th>
                    <th>Wymiary</th>
                    <th>Liczba</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(index, element) in showModel.elements">
                    <td class="collapsing">{{ index + 1}}</td>
                    <td class="collapsing">{{ element.name }}</td>
                    <td class="collapsing">{{ element.thickness }} x {{ element.width }} x {{ element.length }}</td>
                    <td>{{ element.pivot.quantity }}</td>
                    <td class="collapsing right aligned"><a href="#" class="mini ui button" v-link="{ name: 'element-show', params: { id: element.id }}">wyświetl</a></td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="ui inverted dimmer" v-bind:class="{ 'active': showIsBusy }">
            <div class="ui text loader">Wczytywanie</div>
        </div>
    </div>
</template>
<script type="text/ecmascript-6">

    import {showIsBusy, showModel} from "./../../vuex/getters/goods-received-getters"
    import {setGoodsReceivedShowModel, GoodsReceivedGet} from "./../../vuex/actions/goods-received"

    export default{

        vuex: {
            getters: {
                showIsBusy,
                showModel
            },
            actions: {
                GoodsReceivedGet,
                setGoodsReceivedShowModel,
            }
        },

        ready: function () {

        },


        data: function () {
            return {
                busy: false,
            }
        },

        route: {
            data: function () {
                const id = this.$route.params.id;

                if (this.showModel == null || this.showModel.id != id) {
                    this.setGoodsReceivedShowModel(id);
                }
            }
        },


        events: {},


        /*
         * Component methods
         */
        methods: {}
    }
</script>