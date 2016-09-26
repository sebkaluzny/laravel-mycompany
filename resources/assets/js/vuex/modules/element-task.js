const state = {
    index: {
        element_tasks: [],
        busy: false,
    },

    edit: {
        model: null,
        busy: false,
        form: null,
    },

    all: [],
};

const mutations = {
    SET_INDEX_ELEMENT_TASKS(state, elements) {
        state.index.element_tasks = elements;
    },

    SET_INDEX_ELEMENT_TASKS_BUSY(state, busy) {
        state.index.busy = busy;
    },

    SET_ELEMENT_TASK_EDIT_MODEL(state, model) {
        state.edit.model = model;
    },
    SET_ELEMENT_TASK_EDIT_BUSY(state, busy) {
        state.edit.busy = busy;
    },
    SET_ELEMENT_TASK_EDIT_FORM(state, form) {
        state.edit.form = form;
    },

    SET_ELEMENT_TASK_ALL(state, all) {
        state.all = all;
    },

};

export default {
    state,
    mutations
}