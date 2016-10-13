module.exports = {
    template: '' +
    '<div class="ui pagination menu">\n    ' +
    '' +
    '<a class="item" v-if="pagination.current_page > 2" href="#" aria-label="Previous" @click.prevent="changePage(0)">' +
    '<span aria-hidden="true">&laquo;</span>' +
    '</a>\n    ' +
    '' +
    '' +
    '<a class="item" v-if="pagination.current_page > 1" href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)">' +
    '<span aria-hidden="true">&lsaquo;</span>' +
    '</a>' +
    '\n    ' +
    '' +
    '<a class="item" v-for="num in array" :class="{\'active\': num == pagination.current_page}" href="#" @click.prevent="changePage(num)">{{ num }}</a>' +
    '\n    ' +
    '' +
    '<a class="item" v-if="pagination.current_page < pagination.last_page" href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)">' +
    '<span aria-hidden="true">&rsaquo;</span>' +
    '</a>' +
    '\n    ' +
    '' +
    '<a class="item" v-if="pagination.current_page < (pagination.last_page - 1)" href="#" aria-label="Next" @click.prevent="changePage(pagination.last_page)">' +
    '<span aria-hidden="true">&raquo;</span>' +
    '</a>' +
    '\n' +
    '</div>' +
    '',
    props: {
        pagination: {
            type: Object,
            required: true
        },
        callback: {
            type: Function,
            required: true
        },
        offset: {
            type: Number,
            default: 4
        }
    },
    computed: {
        array: function () {
            if(!this.pagination.to) {
                return [];
            }

            var from = this.pagination.current_page - this.offset;
            if(from < 1) {
                from = 1;
            }

            var to = from + (this.offset * 2);
            if(to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }

            var arr = [];
            while (from <=to) {
                arr.push(from);
                from++;
            }

            return arr;
        }
    },
    watch: {
        'pagination.per_page': function () {
            this.callback();
        }
    },
    methods: {
        changePage: function (page) {
            this.$set('pagination.current_page', page);
            this.callback();
        }
    }
};