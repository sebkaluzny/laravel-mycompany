const state = {
    search: {
        projects: null,
        busy: false,
    }
};

const mutations = {

    SET_PROJECT_SEARCH_PROJECTS(state, projects) {
        state.search.projects = projects;
    },

    SET_PROJECT_SEARCH_BUSY(state, bool) {
        state.search.busy = bool;
    },
};

export default {
    state,
    mutations
}