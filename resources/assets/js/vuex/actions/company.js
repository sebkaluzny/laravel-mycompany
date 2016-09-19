import Vue from "vue"
import VueResource from "vue-resource"

Vue.use(VueResource)

export const CompanyFetchAll = ({ dispatch, state }) => {
    const promise = new Promise((resolve, reject) => {
        Vue.http.get("/api/company").then((response) => {
            dispatch('SET_COMPANIES', response.data.companies)
            resolve(response.data.companies)
        }, (response) => {
            reject(response.data)
        })
    })
    return promise
}