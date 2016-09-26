import Vue from "vue"
import Vuex from "vuex"
import goodsReceived from "./modules/goods-received"
import app from "./modules/app"
import company from "./modules/company"
import element from "./modules/element"
import elementTask from "./modules/element-task"
import file from "./modules/file"
import project from "./modules/project"
import selectedElements from "./modules/selected-elements"

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        app,
        goodsReceived,
        company,
        element,
        elementTask,
        file,
        project,

        selectedElements
    }
})