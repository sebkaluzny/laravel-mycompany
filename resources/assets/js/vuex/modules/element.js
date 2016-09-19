const state = {
    index: {
        elements: [],
        busy: false,
    },

    show: {
        model: null,
        busy: false,
    }
};

const mutations = {
    SET_INDEX_ELEMENTS(state, elements) {
        state.index.elements = elements;
    },

    SET_INDEX_ELEMENTS_BUSY(state, busy) {
        state.index.busy = busy;
    },

    /*
     Show
     */

    SET_ELEMENT_SHOW_MODEL(state, model) {
        state.show.model = model;
    },

    SET_ELEMENT_SHOW_BUSY(state, bool) {
        state.show.busy = bool;
    },
};

export default {
    state,
    mutations
}