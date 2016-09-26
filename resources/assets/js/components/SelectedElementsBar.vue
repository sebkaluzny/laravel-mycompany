<template>
    <div class="ui bottom fixed menu" v-if="getElements.length > 0" id="selectedElementsBar">
        <div class="ui container">
            <div class="header item">
                Zaznaczonych elementów: {{ getElements.length }}
            </div>
            <a class="item" v-on:click.prevent="clearSelected">Wyczyść zaznaczone</a>
            <a class="ui dropdown item">Generuj
                <div class="menu">
                    <div class="item">
                        Wydanie na zewnątrz
                    </div>
                    <div class="item">
                        Wycena
                    </div>
                </div>
            </a>
            <a class="ui dropdown item">Exportuj
                <div class="menu">
                    <div class="item" v-on:click.prevent="exportElements('csv')">
                        Plik .CSV
                    </div>
                    <div class="item" v-on:click.prevent="exportElements('pdf')">
                        Plik .PDF
                    </div>
                </div>
            </a>
        </div>
    </div>
    <export-elements-modal :submit-callback="submit"></export-elements-modal>
</template>
<script type="text/ecmascript-6">

    import {ElementsExport} from './../vuex/actions/element';
    import {clearAllSelected} from './../vuex/actions/selected-elements';
    import {getElements} from './../vuex/getters/selected-elements-getters';

    export default{
        vuex: {
            getters: {
                getElements,
            },
            actions: {
                clearAllSelected, ElementsExport
            }
        },

        watch: {
            getElements: function () {
                $('.ui.dropdown')
                        .dropdown()
                ;
            }
        },

        ready: function () {
            $('.ui.dropdown')
                    .dropdown()
            ;
        },


        data: function () {
            return {}
        },


        events: {},


        /*
         * Component methods
         */
        methods: {
            clearSelected: function () {
                if (confirm("Na pewno?")) {
                    this.clearAllSelected();
                }
            },

            exportElements: function (type) {
                this.$broadcast('modal:export-elements:show', type);
            },

            submit: function (type, form) {
                this.$broadcast('modal:export-elements:hide');

                var data = {
                    type: type,
                    export_data: form.exportData,
                    elements: this.getElements
                };

                this.ElementsExport(data).then(response => {

                    var url = response.data.url;

                    var win = window.open(url, '_blank');
                    win.focus();

//                    var uriContent = "data:application/octet-stream," + encodeURIComponent(response.data);
//
//                    if(type == 'csv')
//                    {
//                        this.saveAs(uriContent, response.headers.FileName);
//                    }
//                    else
//                    {
////                        var newWindow=window.open(uriContent, 'asdasd.txt');
//                        var w = window.open('about:blank', 'windowname');
//                        w.document.write(uriContent);
//                        w.document.close();
//                    }
//                    var a = $('<a href=""></a>');
//                    a.attr("href", uriContent).attr("download", response.headers.FileName);

//                    var newWindow=window.open(uriContent, 'asdasd.txt');
                });

            },

            saveAs: function (uri, filename) {
                var link = document.createElement('a');
                if (typeof link.download === 'string') {
                    document.body.appendChild(link); // Firefox requires the link to be in the body
                    link.download = filename;
                    link.href = uri;
                    link.click();
                    document.body.removeChild(link); // remove the link when done
                } else {
                    location.replace(uri);
                }
            }
        }
    }
</script>

<style>
    #selectedElementsBar .item {
        line-height: 2;
    }

    #selectedElementsBar .dropdown.item .item {
        line-height: 1;
    }
</style>