const state = {
    search: {
        files: null,
        busy: false,
    }
};

const mutations = {

    SET_FILES_SEARCH_FILES(state, files) {
        state.search.files = files;
    },

    SET_FILES_SEARCH_BUSY(state, bool) {
        state.search.busy = bool;
    },
};

export default {
    state,
    mutations
}