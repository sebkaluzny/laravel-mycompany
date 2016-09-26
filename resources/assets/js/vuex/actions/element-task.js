import Vue from "vue"

export const ElementTaskCreate = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/element-task", data).then((response) => {
            resolve(response.data.element_task)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementTaskUpdate = ({ dispatch, state }, id, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http['put']("api/element-task/" + id, data).then((response) => {
            resolve(response.data.element_task)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementTaskIndex = ({ dispatch, state }) => {
    const promise = new Promise((resolve, reject) => {
        dispatch('SET_INDEX_ELEMENT_TASKS_BUSY', true);
        Vue.http.get("api/element-task", null).then((response) => {
            dispatch('SET_INDEX_ELEMENT_TASKS', response.data.element_tasks)
            resolve(response.data.element_tasks)
            dispatch('SET_INDEX_ELEMENT_TASKS_BUSY', false);
        }, (response) => {
            reject(response.data)
            dispatch('SET_INDEX_ELEMENT_TASKS_BUSY', false);
        })
    })
    return promise
}

export const ElementTaskGetAll = ({ dispatch, state }) => {
    const promise = new Promise((resolve, reject) => {
        // dispatch('SET_INDEX_ELEMENT_TASKS_BUSY', true);
        Vue.http.get("api/element-task", null).then((response) => {
            dispatch('SET_ELEMENT_TASK_ALL', response.data.element_tasks)
            resolve(response.data.element_tasks)
            // dispatch('SET_INDEX_ELEMENT_TASKS_BUSY', false);
        }, (response) => {
            reject(response.data)
            // dispatch('SET_INDEX_ELEMENT_TASKS_BUSY', false);
        })
    })
    return promise
}

export const ElementTaskGet = ({ dispatch, state }, id) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.get("api/element-task/" + id, null).then((response) => {
            // dispatch('SET_GOODS_RECEIVED_INDEX', response.data)
            resolve(response.data.element_task)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const setElementTaskEdit = ({ dispatch, state }, id) => {
    const promise = new Promise((resolve, reject) => {
        dispatch('SET_ELEMENT_TASK_EDIT_BUSY', true)

        ElementTaskGet({dispatch, state}, id).then(model => {
            dispatch('SET_ELEMENT_TASK_EDIT_MODEL', model)
            dispatch('SET_ELEMENT_TASK_EDIT_BUSY', false)
            dispatch('SET_ELEMENT_TASK_EDIT_FORM', {
                name: model.name,
                fields: model.fields,
            })
            resolve(model);
        }, e => {
            dispatch('SET_ELEMENT_TASK_EDIT_BUSY', false)
            reject(e);
        });
    })
    return promise
}