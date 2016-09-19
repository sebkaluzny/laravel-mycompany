import Vue from "vue"
import VueResource from "vue-resource"

Vue.use(VueResource)

export const FileCreate = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/file", data).then((response) => {
            resolve(response.data.file)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const FileSearch = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        dispatch('SET_FILES_SEARCH_BUSY', true);
        Vue.http.post("api/file/search", data).then((response) => {
            dispatch('SET_FILES_SEARCH_FILES', response.data.files);
            resolve(response.data.files)
            dispatch('SET_FILES_SEARCH_BUSY', false);
        }, (response) => {
            reject(response.data)
            dispatch('SET_FILES_SEARCH_BUSY', false);
        })
    })
    return promise
}