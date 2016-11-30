const state = {
    index: {
        pricings: [],
        busy: false,
    },
};

const mutations = {
    SET_INDEX_ELEMENT_PRICINGS(state, pricings) {
        state.index.pricings = pricings;
    },

    SET_INDEX_ELEMENT_PRICINGS_BUSY(state, busy) {
        state.index.busy = busy;
    }

};

export default {
    state,
    mutations
}