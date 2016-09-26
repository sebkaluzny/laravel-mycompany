const state = {
    elements: [],
};

const mutations = {

    SET_SELECTED_ELEMENTS(state, elements) {
        state.elements = elements;
    },

};

export default {
    state,
    mutations
}