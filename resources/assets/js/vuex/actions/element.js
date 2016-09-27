import Vue from "vue"
import VueResource from "vue-resource"

Vue.use(VueResource)

export const ElementCreate = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/element", data).then((response) => {
            resolve(response.data.element)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementUpdate = ({ dispatch, state }, id, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http['put']("api/element/" + id, data).then((response) => {
            resolve(response.data.element)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementGet = ({ dispatch, state }, id) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.get("api/element/" + id, null).then((response) => {
            // dispatch('SET_GOODS_RECEIVED_INDEX', response.data)
            resolve(response.data.element)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementSearch = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/element/search", data).then((response) => {
            resolve(response.data.elements)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementAttachFile = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/element/attach-file", data).then((response) => {
            resolve(response.data)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementDetachFile = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/element/detach-file", data).then((response) => {
            resolve(response.data)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementAttachTask = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/element/attach-task", data).then((response) => {
            resolve(response.data)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementDetachTask = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/element/detach-task", data).then((response) => {
            resolve(response.data)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementsExport = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/element/export", data).then((response) => {
            resolve(response)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementReplicate = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/element/replicate", data).then((response) => {
            resolve(response.data.element)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementsPricing = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/element/pricing", data).then((response) => {
            resolve(response.data.elements)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const ElementIndex = ({ dispatch, state }, data = {}) => {
    const promise = new Promise((resolve, reject) => {
        dispatch('SET_INDEX_ELEMENTS_BUSY', true);
        Vue.http.get("api/element?" + $.param(data), null).then((response) => {
            dispatch('SET_INDEX_ELEMENTS', response.data.elements)
            resolve(response.data.elements)
            dispatch('SET_INDEX_ELEMENTS_BUSY', false);
        }, (response) => {
            reject(response.data)
            dispatch('SET_INDEX_ELEMENTS_BUSY', false);
        })
    })
    return promise
}


export const setElementShow = ({ dispatch, state }, id) => {
    const promise = new Promise((resolve, reject) => {
        dispatch('SET_ELEMENT_SHOW_BUSY', true)

        ElementGet({dispatch, state}, id).then(model => {
            dispatch('SET_ELEMENT_SHOW_MODEL', model)
            dispatch('SET_ELEMENT_SHOW_BUSY', false)
            resolve(model);
        }, e => {
            dispatch('SET_ELEMENT_SHOW_BUSY', false)
            reject(e);
        });
    })
    return promise
}

export const setElementShowModel = ({ dispatch, state }, model) => {
    dispatch('SET_ELEMENT_SHOW_MODEL', model)
}
