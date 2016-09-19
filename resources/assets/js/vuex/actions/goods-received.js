import Vue from "vue"
import VueResource from "vue-resource"

Vue.use(VueResource)

export const fetchGoodsReceived = ({ dispatch, state }) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.get("api/goods-received", null).then((response) => {
            dispatch('SET_GOODS_RECEIVED', response.data.goods_received)
            resolve(response.data.goods_received)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const GoodsReceivedGet = ({ dispatch, state }, id) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.get("api/goods-received/" + id).then((response) => {
            resolve(response.data.goods_received)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const GoodsReceivedCreate = ({ dispatch, state }, data) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.post("api/goods-received", data).then((response) => {
            resolve(response.data)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const GoodsReceivedUpdate = ({ dispatch, state }, id, data) => {
    const promise = new Promise((resolve, reject) => {
        // dispatch('SET_GOODS_RECEIVED_EDIT_BUSY', true)
        Vue.http['put']("api/goods-received/" + id, data).then((response) => {
            // dispatch('SET_GOODS_RECEIVED_EDIT_MODEL', response.data.goods_received)
            // dispatch('SET_GOODS_RECEIVED_EDIT_BUSY', false)
            resolve(response.data.goods_received)
        }, (response) => {
            // dispatch('SET_GOODS_RECEIVED_EDIT_BUSY', false)
            reject(response.data)
        })
    })
    return promise
}

export const GoodsReceivedIndex = ({ dispatch, state }) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.get("api/goods-received", null).then((response) => {
            dispatch('SET_GOODS_RECEIVED_INDEX', response.data)
            resolve(response.data.goods_received)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}

export const setGoodsReceivedShowModel = ({ dispatch, state }, id) => {
    const promise = new Promise((resolve, reject) => {
        dispatch('SET_GOODS_RECEIVED_SHOW_BUSY', true)

        GoodsReceivedGet({dispatch, state}, id).then(model => {
            dispatch('SET_GOODS_RECEIVED_SHOW_MODEL', model)
            dispatch('SET_GOODS_RECEIVED_SHOW_BUSY', false)
            resolve(model);
        }, e => {
            dispatch('SET_GOODS_RECEIVED_SHOW_BUSY', false)
            reject(e);
        });
    })
    return promise
}

export const setGoodsReceivedEditModel = ({ dispatch, state }, id) => {
    const promise = new Promise((resolve, reject) => {
        dispatch('SET_GOODS_RECEIVED_EDIT_BUSY', true)

        GoodsReceivedGet({dispatch, state}, id).then(model => {
            dispatch('SET_GOODS_RECEIVED_EDIT_MODEL', model)
            dispatch('SET_GOODS_RECEIVED_EDIT_FORM', {
                number: model.number,
                received_at: model.received_at_date,
                company_id: model.company_id,
                elements: model.elements,
                busy: false,
            });
            dispatch('SET_GOODS_RECEIVED_EDIT_BUSY', false)
            resolve(model);
        }, e => {
            dispatch('SET_GOODS_RECEIVED_EDIT_BUSY', false)
            reject(e);
        });
    })
    return promise
}