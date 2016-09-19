const state = {
    companies: [],
};

const mutations = {
    SET_COMPANIES(state, companies) {
       state.companies = companies;
    },
};

export default {
    state,
    mutations
}