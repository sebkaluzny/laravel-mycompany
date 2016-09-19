const state = {
    goodsReceived: [],
    index: [],
    model: {},
    // newGoodsReceived: {},

    show: {
        model: null,
        busy: false,
    },

    edit: {
        form: null,
        model: null,
        busy: false,
    },
};

const mutations = {
    SET_GOODS_RECEIVED(state, goodsReceived) {
        state.goodsReceived = goodsReceived;
    },
    SET_GOODS_RECEIVED_INDEX(state, index) {
        state.index = index;
    },

    /*
    Show
     */

    SET_GOODS_RECEIVED_SHOW_MODEL(state, model) {
        state.show.model = model;
    },

    SET_GOODS_RECEIVED_SHOW_BUSY(state, bool) {
        state.show.busy = bool;
    },

    /*
    Edit/Update
     */

    SET_GOODS_RECEIVED_EDIT_FORM(state, form) {
        state.edit.form = form;
    },

    SET_GOODS_RECEIVED_EDIT_MODEL(state, model) {
        state.edit.model = model;
    },

    SET_GOODS_RECEIVED_EDIT_BUSY(state, busy) {
        state.edit.busy = busy;
    },
};

export default {
    state,
    mutations
}