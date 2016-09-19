const state = {

    showLoading: false,
    doneLoading: false,
    loadFailed: false
};

const mutations = {
    TRIGGER_LOAD_ANIMATION (state) {
        state.showLoading = !state.loadFailed
    },
    TRIGGER_LOAD_ANIMATION_DONE (state) {
        state.loadFailed = false;
        state.doneLoading = true;
    },
    HIDE_LOAD_ANIMATION (state) {
        state.showLoading = false;
        state.loadFailed = false;
        state.doneLoading = false;
    },
};

export default {
    state,
    mutations
}