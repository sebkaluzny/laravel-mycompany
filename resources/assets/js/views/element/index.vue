<template>
    <h3 class="ui block header">
        Lista elementów
    </h3>
    <div class="ui internally celled grid">
        <div class="row">
            <div class="three wide column">
                <div class="ui fluid text vertical menu">
                    <div class="item">
                        <div class="ui input">
                            <input type="text" placeholder="Szukaj..." v-model="search" debounce="400">
                        </div>
                    </div>

                    <div class="header item">Sort By</div>
                    <a class="active item">
                        TO-DO
                    </a>
                </div>
            </div>
            <div class="thirteen wide column">
                <div class="ui divided items" v-if="indexElements != null">
                    <div class="item" v-for="element in indexElements">
                        <a class="ui tiny image">
                            <img src="http://placehold.it/80x80">
                        </a>
                        <div class="content">
                            <a class="header" v-link="{ name: 'element-show', params: { id: element.id }}">{{ element.name }}</a>
                            <div class="description">
                                {{ element.thickness }} x {{ element.width }} x {{ element.length }} | Projekt:
                            </div>
                            <div class="extra">
                                <div class="ui tiny label" :class="{'grey': element.quantity >= 0 }">
                                    Na stanie: {{ element.quantity }}
                                </div>
                                <div class="ui tiny label" :class="{'red': element.done_quantity == 0 }">
                                    Wykonanych: {{ element.done_quantity }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <page-loader :busy.sync="indexIsBusy"></page-loader>
            </div>
        </div>
    </div>

</template>
<script type="text/ecmascript-6">

    import {ElementIndex} from './../../vuex/actions/element';
    import {indexElements, indexIsBusy} from './../../vuex/getters/element-getters';

    import PageLoader from './../../components/PageLoader.vue';

    export default{

        components: { PageLoader },

        vuex: {
            getters: {
                indexElements,
                indexIsBusy
            },
            actions: {
                ElementIndex,
            }
        },

        watch: {
            search: function () {
                if(this.search != '')
                {
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
                this.ElementIndex().then(() => {
                });
            }
        },


        data: function () {
            return {
                search: '',
            }
        },


        events: {},


        /*
         * Component methods
         */
        methods: {}
    }
</script>