import Vue from "vue"

export const ProjectCreate = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/project", data).then((response) => {
            resolve(response.data.project)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ProjectUpdate = ({ dispatch, state }, id, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http['put']("api/project/" + id, data).then((response) => {
            resolve(response.data.project)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ProjectGetAll = ({ dispatch, state }) => {
    const promise = new Promise((resolve, reject) => {
        // dispatch('SET_INDEX_ELEMENT_TASKS_BUSY', true);
        Vue.http.get("api/project", null).then((response) => {
            // dispatch('SET_ELEMENT_TASK_ALL', response.data.element_tasks)
            resolve(response.data.projects)
            // dispatch('SET_INDEX_ELEMENT_TASKS_BUSY', false);
        }, (response) => {
            reject(response.data)
            // dispatch('SET_INDEX_ELEMENT_TASKS_BUSY', false);
        })
    })
    return promise
}

export const ProjectGet = ({ dispatch, state }, id) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.get("api/project/" + id, null).then((response) => {
            resolve(response.data.project)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ProjectSearch = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        dispatch('SET_PROJECT_SEARCH_BUSY', true);
        Vue.http.get("api/project").then((response) => {
            dispatch('SET_PROJECT_SEARCH_PROJECTS', response.data.projects);
            resolve(response.data.projects)
            dispatch('SET_PROJECT_SEARCH_BUSY', false);
        }, (response) => {
            reject(response.data)
            dispatch('SET_PROJECT_SEARCH_BUSY', false);
        })
    })
    return promise
}