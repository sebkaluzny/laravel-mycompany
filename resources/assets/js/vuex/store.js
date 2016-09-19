import Vue from "vue"
import Vuex from "vuex"
import goodsReceived from "./modules/goods-received"
import app from "./modules/app"
import company from "./modules/company"
import element from "./modules/element"
import file from "./modules/file"

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        app,
        goodsReceived,
        company,
        element,
        file
    }
})